<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Mail\CustomerCreate;
use App\Mail\CustomerDeposit;
use App\Mail\SupplierCreate;
use App\Models\Account;
use App\Models\CashRegister;
use App\Models\CustomField;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Deposit;
use App\Models\MailSetting;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Traits\CacheForget;
use App\Traits\MailInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CustomerService
{
    use CacheForget;
    use MailInfo;

    protected CustomerRepositoryInterface $customerRepository;

    /**
     * CustomerService constructor.
     *
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Get all active customers.
     *
     * @return Collection
     */
    public function getActiveCustomers(): Collection
    {
        return $this->customerRepository->getActiveCustomers();
    }

    /**
     * Get customer by ID.
     *
     * @param int|string $id
     * @return Customer
     */
    public function getCustomerById($id): Customer
    {
        return $this->customerRepository->findOrFail($id);
    }

    /**
     * Process DataTables server-side response for customer list.
     *
     * @param Request $request
     * @param array $allPermissions
     * @return array
     */
    public function getCustomerDataTable(Request $request, array $allPermissions): array
    {
        $columns = [
            1 => 'customer_group_id',
            2 => 'name',
            4 => 'points',
        ];

        $totalData = $this->customerRepository->countTotalActiveCustomers();
        $limit = ($request->input('length') != -1) ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $orderColumn = $request->input('order.0.column');
        $order = $columns[$orderColumn] ?? 'name';
        $dir = $request->input('order.0.dir') ?? 'asc';
        $searchValue = $request->input('search.value');

        $customers = $this->customerRepository->getFilteredCustomersForDataTable($start, $limit, $order, $dir, $searchValue);
        $totalFiltered = $this->customerRepository->countFilteredCustomersForDataTable($searchValue);

        $customerIds = $customers->pluck('id')->toArray();

        // Get sales aggregates
        $salesAggregates = DB::table('sales')
            ->select('customer_id', DB::raw('SUM(grand_total) as total_grand_total'), DB::raw('SUM(paid_amount) as total_paid_amount'))
            ->whereIn('customer_id', $customerIds)
            ->where('payment_status', '!=', PaymentStatus::PAID->value)
            ->groupBy('customer_id')
            ->get()
            ->keyBy('customer_id');

        // Get returns aggregates
        $returnsAggregates = DB::table('returns')
            ->join('sales', 'sales.id', '=', 'returns.sale_id')
            ->select('sales.customer_id', DB::raw('SUM(returns.grand_total) as total_returned_amount'))
            ->whereIn('sales.customer_id', $customerIds)
            ->where('sales.payment_status', '!=', PaymentStatus::PAID->value)
            ->groupBy('sales.customer_id')
            ->get()
            ->keyBy('customer_id');

        $customFields = CustomField::where([
            ['belongs_to', 'customer'],
            ['is_table', true]
        ])->pluck('name');

        $data = [];
        foreach ($customers as $key => $customer) {
            $salesInfo = $salesAggregates->get($customer->id);
            $returnInfo = $returnsAggregates->get($customer->id);

            $totalGrandTotal = $salesInfo ? $salesInfo->total_grand_total : 0;
            $totalPaidAmount = $salesInfo ? $salesInfo->total_paid_amount : 0;
            $totalReturnedAmount = $returnInfo ? $returnInfo->total_returned_amount : 0;
            $due = $totalGrandTotal - $totalReturnedAmount - $totalPaidAmount;

            $nestedData = [];
            $nestedData['id'] = $customer->id;
            $nestedData['key'] = $key;
            $nestedData['customer_group'] = $customer->customerGroup->name ?? 'N/A';

            $details = '<strong>' . $customer->name . '</strong>';
            if ($customer->company_name) {
                $details .= '<br>' . $customer->company_name;
            }
            if ($customer->email) {
                $details .= '<br>' . $customer->email;
            }
            $details .= '<br>' . $customer->phone_number;
            $details .= '<br>' . $customer->address . ', ' . $customer->city;
            if ($customer->country) {
                $details .= ', ' . $customer->country;
            }
            $nestedData['customer_details'] = $details;

            $discountPlans = [];
            foreach ($customer->discountPlans as $discountPlan) {
                $discountPlans[] = $discountPlan->name;
            }
            $nestedData['discount_plan'] = count($discountPlans) > 0 ? implode(', ', $discountPlans) : 'N/A';
            $nestedData['points'] = $customer->points;
            $nestedData['deposit'] = number_format($customer->deposit - $customer->expense, 2);
            $nestedData['total_due'] = number_format($due, 2);

            foreach ($customFields as $fieldName) {
                $fieldNameClean = str_replace(" ", "_", strtolower($fieldName));
                $nestedData[$fieldNameClean] = $customer->$fieldNameClean;
            }

            $options = '<div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . trans('file.action') . '
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">';

            if (in_array("customers-edit", $allPermissions)) {
                $options .= '<li><a href="' . route('customer.edit', $customer->id) . '" class="btn btn-link"><i class="dripicons-document-edit"></i> ' . trans('file.edit') . '</a></li>';
            }
            if (in_array("due-report", $allPermissions)) {
                $options .= '<li>
                                <form action="' . route('report.customerDueByDate') . '" method="post" class="d-inline">
                                    ' . csrf_field() . '
                                    <input type="hidden" name="start_date" value="' . date('Y-m-d', strtotime('-30 year')) . '" />
                                    <input type="hidden" name="end_date" value="' . date('Y-m-d') . '" />
                                    <input type="hidden" name="customer_id" value="' . $customer->id . '" />
                                    <button type="submit" class="btn btn-link"><i class="dripicons-pulse"></i> ' . trans('file.Due Report') . '</button>
                                </form>
                            </li>';
            }
            $options .= '<li><button type="button" data-id="' . $customer->id . '" class="clear-due btn btn-link" data-toggle="modal" data-target="#clearDueModal"><i class="dripicons-brush"></i> ' . trans('file.Clear Due') . '</button></li>';

            if (in_array("customers-delete", $allPermissions)) {
                $options .= \Form::open(["route" => ["customer.destroy", $customer->id], "method" => "DELETE", "class" => "d-inline"]) . '
                            <li>
                              <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> ' . trans("file.delete") . '</button>
                            </li>' . \Form::close();
            }

            $options .= '</ul></div>';
            $nestedData['options'] = $options;

            $data[] = $nestedData;
        }

        return [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];
    }

    /**
     * Clear customer due across unpaid sales.
     *
     * @param int $customerId
     * @param float $amount
     * @param string|null $note
     * @return void
     */
    public function clearDue(int $customerId, float $amount, ?string $note = null): void
    {
        $dueSales = Sale::select('id', 'warehouse_id', 'grand_total', 'paid_amount', 'payment_status')
            ->where([
                ['payment_status', '!=', PaymentStatus::PAID->value],
                ['customer_id', $customerId]
            ])->get();

        $totalPaidAmount = $amount;
        foreach ($dueSales as $sale) {
            if ($totalPaidAmount == 0) {
                break;
            }

            $dueAmount = $sale->grand_total - $sale->paid_amount;
            $cashRegister = CashRegister::select('id')
                ->where([
                    ['user_id', Auth::id()],
                    ['warehouse_id', $sale->warehouse_id],
                    ['status', 1]
                ])->first();

            $cashRegisterId = $cashRegister ? $cashRegister->id : null;
            $account = Account::select('id')->where('is_default', 1)->first();

            if ($totalPaidAmount >= $dueAmount) {
                $paidAmount = $dueAmount;
                $paymentStatus = PaymentStatus::PAID->value;
            } else {
                $paidAmount = $totalPaidAmount;
                $paymentStatus = PaymentStatus::DUE->value;
            }

            Payment::create([
                'payment_reference' => 'spr-' . date("Ymd") . '-' . date("his"),
                'sale_id'           => $sale->id,
                'user_id'           => Auth::id(),
                'cash_register_id'  => $cashRegisterId,
                'account_id'        => $account ? $account->id : null,
                'amount'            => $paidAmount,
                'change'            => 0,
                'due_payment'       => 1,
                'paying_method'     => 'Cash',
                'payment_note'      => $note
            ]);

            $sale->paid_amount += $paidAmount;
            $sale->payment_status = $paymentStatus;
            $sale->save();
            $totalPaidAmount -= $paidAmount;
        }
    }

    /**
     * Create a new customer.
     *
     * @param array $requestData
     * @param Request $request
     * @return array Array with customer model and message
     */
    public function createCustomer(array $requestData, Request $request): array
    {
        $customerData = $requestData;
        $customerData['is_active'] = true;
        $prefixMessage = 'Customer';

        if (isset($requestData['user'])) {
            $customerData['phone'] = $customerData['phone_number'];
            $customerData['role_id'] = 5;
            $customerData['is_deleted'] = false;
            $customerData['password'] = bcrypt($customerData['password']);
            $user = User::create($customerData);
            $customerData['user_id'] = $user->id;
            $prefixMessage .= ', User';
        }

        $customerData['name'] = $customerData['customer_name'];

        if (isset($requestData['both'])) {
            Supplier::create($customerData);
            $prefixMessage .= ' and Supplier';
        }

        $fullMessage = $prefixMessage . ' created successfully!';
        $mailSetting = MailSetting::latest()->first();
        $message = $this->mailAction($customerData, $mailSetting, $request, $fullMessage);

        $customer = Customer::create($customerData);

        // Custom fields
        $customFieldData = [];
        $customFields = CustomField::where('belongs_to', 'customer')->select('name', 'type')->get();
        foreach ($customFields as $customField) {
            $fieldName = str_replace(' ', '_', strtolower($customField->name));
            if (isset($customerData[$fieldName])) {
                if ($customField->type == 'checkbox' || $customField->type == 'multi_select') {
                    $customFieldData[$fieldName] = implode(",", $customerData[$fieldName]);
                } else {
                    $customFieldData[$fieldName] = $customerData[$fieldName];
                }
            }
        }
        if (count($customFieldData)) {
            DB::table('customers')->where('id', $customer->id)->update($customFieldData);
        }

        $this->cacheForget('customer_list');

        return [
            'customer' => $customer,
            'message'  => $message
        ];
    }

    /**
     * Update an existing customer.
     *
     * @param int|string $id
     * @param array $requestData
     * @param Request $request
     * @return array
     */
    public function updateCustomer($id, array $requestData, Request $request): array
    {
        $customer = Customer::findOrFail($id);
        $input = $requestData;

        if (isset($input['user'])) {
            $input['phone'] = $input['phone_number'];
            $input['role_id'] = 5;
            $input['is_active'] = true;
            $input['is_deleted'] = false;
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $input['user_id'] = $user->id;
            $message = 'Customer updated and user created successfully';
        } else {
            $message = 'Customer updated successfully';
        }

        $input['name'] = $input['customer_name'];
        $customer->update($input);

        // Custom fields
        $customFieldData = [];
        $customFields = CustomField::where('belongs_to', 'customer')->select('name', 'type')->get();
        foreach ($customFields as $customField) {
            $fieldName = str_replace(' ', '_', strtolower($customField->name));
            if (isset($input[$fieldName])) {
                if ($customField->type == 'checkbox' || $customField->type == 'multi_select') {
                    $customFieldData[$fieldName] = implode(",", $input[$fieldName]);
                } else {
                    $customFieldData[$fieldName] = $input[$fieldName];
                }
            }
        }
        if (count($customFieldData)) {
            DB::table('customers')->where('id', $customer->id)->update($customFieldData);
        }

        $this->cacheForget('customer_list');

        return [
            'customer' => $customer,
            'message'  => $message
        ];
    }

    /**
     * Import customers from CSV.
     *
     * @param UploadedFile $file
     * @param Request $request
     * @return string
     */
    public function importCustomers(UploadedFile $file, Request $request): string
    {
        $filePath = $file->getRealPath();
        $handle = fopen($filePath, 'r');
        $header = fgetcsv($handle);
        $escapedHeader = [];

        foreach ($header as $value) {
            $lheader = strtolower($value);
            $escapedItem = preg_replace('/[^a-z]/', '', $lheader);
            $escapedHeader[] = $escapedItem;
        }

        $mailSetting = MailSetting::latest()->first();
        $message = 'Customer Imported Successfully';

        while ($columns = fgetcsv($handle)) {
            if ($columns[0] == '') {
                continue;
            }
            foreach ($columns as $key => $value) {
                $columns[$key] = preg_replace('/\D/', '', $value);
            }
            $data = array_combine($escapedHeader, $columns);
            $customerGroup = CustomerGroup::where('name', $data['customergroup'])->first();
            $customer = Customer::firstOrNew(['name' => $data['name']]);
            $customer->customer_group_id = $customerGroup ? $customerGroup->id : null;
            $customer->name = $data['name'];
            $customer->company_name = $data['companyname'];
            $customer->email = $data['email'];
            $customer->phone_number = $data['phonenumber'];
            $customer->address = $data['address'];
            $customer->city = $data['city'];
            $customer->state = $data['state'];
            $customer->postal_code = $data['postalcode'];
            $customer->country = $data['country'];
            $customer->is_active = true;
            $customer->save();

            $message = $this->mailAction($data, $mailSetting, $request, 'Customer Imported Successfully');
        }

        fclose($handle);
        $this->cacheForget('customer_list');

        return $message;
    }

    /**
     * Get deposit history for a customer.
     *
     * @param int|string $customerId
     * @return array
     */
    public function getDepositHistory($customerId): array
    {
        $depositsList = Deposit::where('customer_id', $customerId)->get();
        $depositId = [];
        $date = [];
        $amount = [];
        $note = [];
        $name = [];
        $email = [];

        foreach ($depositsList as $deposit) {
            $depositId[] = $deposit->id;
            $date[] = $deposit->created_at->toDateString() . ' ' . $deposit->created_at->toTimeString();
            $amount[] = $deposit->amount;
            $note[] = $deposit->note;
            $user = User::find($deposit->user_id);
            $name[] = $user ? $user->name : 'N/A';
            $email[] = $user ? $user->email : 'N/A';
        }

        if (!empty($depositId)) {
            return [$depositId, $date, $amount, $note, $name, $email];
        }

        return [];
    }

    /**
     * Add deposit to a customer.
     *
     * @param array $data
     * @param Request $request
     * @return string Message
     */
    public function addDeposit(array $data, Request $request): string
    {
        $data['user_id'] = Auth::id();
        $customer = Customer::findOrFail($data['customer_id']);
        $customer->deposit += $data['amount'];
        $customer->save();

        Deposit::create($data);
        $message = 'Data inserted successfully';
        $mailSetting = MailSetting::latest()->first();

        if ($customer->email && $mailSetting) {
            $data['name'] = $customer->name;
            $data['email'] = $customer->email;
            $data['balance'] = $customer->deposit - $customer->expense;
            $data['currency'] = config('currency');
            $message = $this->mailAction($data, $mailSetting, $request);
        }

        return $message;
    }

    /**
     * Update an existing deposit.
     *
     * @param array $data
     * @return void
     */
    public function updateDeposit(array $data): void
    {
        $deposit = Deposit::findOrFail($data['deposit_id']);
        $customer = Customer::findOrFail($deposit->customer_id);
        $amountDif = $data['amount'] - $deposit->amount;
        $customer->deposit += $amountDif;
        $customer->save();

        $deposit->update($data);
    }

    /**
     * Delete a deposit.
     *
     * @param int|string $id
     * @return void
     */
    public function deleteDeposit($id): void
    {
        $deposit = Deposit::findOrFail($id);
        $customer = Customer::findOrFail($deposit->customer_id);
        $customer->deposit -= $deposit->amount;
        $customer->save();

        $deposit->delete();
    }

    /**
     * Deactivate a customer.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteCustomer($id): bool
    {
        $result = $this->customerRepository->deactivate($id);
        $this->cacheForget('customer_list');

        return $result;
    }

    /**
     * Deactivate multiple customers.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleCustomers(array $ids): bool
    {
        $result = $this->customerRepository->deactivateMultiple($ids);
        $this->cacheForget('customer_list');

        return $result;
    }

    /**
     * Get HTML options for customer select dropdown.
     *
     * @return string
     */
    public function getCustomerOptionsHtml(): string
    {
        $customers = $this->customerRepository->getActiveCustomers();
        $html = '';
        foreach ($customers as $customer) {
            $html .= '<option value="' . $customer->id . '">' . $customer->name . ' (' . $customer->phone_number . ')' . '</option>';
        }

        return $html;
    }

    /**
     * Helper to send notification mail.
     */
    protected function mailAction($data, $mailSetting, $request, $customMessage = null): string
    {
        $message = $customMessage ?? 'Data inserted successfully';
        if (!$mailSetting) {
            $message = 'Data inserted successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
        } elseif (!empty($data['email']) && $mailSetting) {
            try {
                $this->setMailInfo($mailSetting);
                Mail::to($data['email'])->send(new CustomerCreate($data));
                if (isset($request->both)) {
                    Mail::to($data['email'])->send(new SupplierCreate($data));
                }
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }

        return $message;
    }
}
