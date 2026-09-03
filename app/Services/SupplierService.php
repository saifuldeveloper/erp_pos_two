<?php

namespace App\Services;

use App\Mail\CustomerCreate;
use App\Mail\SupplierCreate;
use App\Models\Account;
use App\Models\CashRegister;
use App\Models\Customer;
use App\Models\MailSetting;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\SupplierDue;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use App\Traits\CacheForget;
use App\Traits\FileHandleTrait;
use App\Traits\MailInfo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SupplierService
{
    use CacheForget;
    use FileHandleTrait;
    use MailInfo;

    protected SupplierRepositoryInterface $supplierRepository;

    /**
     * SupplierService constructor.
     *
     * @param SupplierRepositoryInterface $supplierRepository
     */
    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * Get all active suppliers.
     *
     * @return Collection
     */
    public function getActiveSuppliers(): Collection
    {
        return $this->supplierRepository->getActiveSuppliers();
    }

    /**
     * Get supplier by ID.
     *
     * @param int|string $id
     * @return Supplier
     */
    public function getSupplierById($id): Supplier
    {
        return $this->supplierRepository->findOrFail($id);
    }

    /**
     * Create a new supplier.
     *
     * @param array $requestData
     * @param UploadedFile|null $image
     * @param Request $request
     * @return array
     */
    public function createSupplier(array $requestData, ?UploadedFile $image, Request $request): array
    {
        $supplierData = $requestData;
        unset($supplierData['image']);
        $supplierData['is_active'] = true;

        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $requestData['company_name'] ?? 'supplier');
            $imageName = $imageName . '.' . $ext;
            $image->move(public_path('images/supplier'), $imageName);
            $supplierData['image'] = $imageName;
        }

        $supplier = $this->supplierRepository->create($supplierData);
        $message = 'Supplier';

        if (isset($requestData['both'])) {
            Customer::create($supplierData);
            $message .= ' and Customer';
        }

        $mailSetting = MailSetting::latest()->first();
        if (!empty($supplierData['email']) && $mailSetting) {
            $this->setMailInfo($mailSetting);
            try {
                Mail::to($supplierData['email'])->send(new SupplierCreate($supplierData));
                if (isset($requestData['both'])) {
                    Mail::to($supplierData['email'])->send(new CustomerCreate($supplierData));
                }
                $message .= ' created successfully!';
            } catch (\Exception $e) {
                $message .= ' created successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            }
        } else {
            $message .= ' created successfully!';
        }

        $this->cacheForget('supplier_list');

        return [
            'supplier' => $supplier,
            'message'  => $message
        ];
    }

    /**
     * Update an existing supplier.
     *
     * @param int|string $id
     * @param array $requestData
     * @param UploadedFile|null $image
     * @return Supplier
     */
    public function updateSupplier($id, array $requestData, ?UploadedFile $image): Supplier
    {
        $supplier = $this->supplierRepository->findOrFail($id);
        $input = $requestData;
        unset($input['image']);

        if ($image) {
            $this->fileDelete('images/supplier/', $supplier->image);

            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $requestData['company_name'] ?? 'supplier');
            $imageName = $imageName . '.' . $ext;
            $image->move(public_path('images/supplier'), $imageName);
            $input['image'] = $imageName;
        }

        $supplier->update($input);
        $this->cacheForget('supplier_list');

        return $supplier;
    }

    /**
     * Clear supplier due across unpaid purchases.
     *
     * @param int $supplierId
     * @param int $accountId
     * @param float $amount
     * @param string|null $note
     * @param string|null $createdAt
     * @return void
     */
    public function clearDue(int $supplierId, int $accountId, float $amount, ?string $note = null, ?string $createdAt = null): void
    {
        $supplierDue = new SupplierDue();
        $supplierDue->supplier_id = $supplierId;
        $supplierDue->account_id = $accountId;
        $supplierDue->amount = $amount;
        $supplierDue->note = $note;

        if ($createdAt) {
            $supplierDue->created_at = date('Y-m-d H:i:s', strtotime($createdAt . ' ' . date('H:i:s')));
        }
        $supplierDue->save();

        $account = Account::find($accountId);
        if ($account) {
            $account->total_balance -= $amount;
            $account->save();
        }

        $duePurchases = Purchase::select('id', 'warehouse_id', 'grand_total', 'paid_amount', 'payment_status')
            ->where([
                ['payment_status', 1],
                ['supplier_id', $supplierId]
            ])->get();

        $totalPaidAmount = $amount;
        $paymentIds = [];

        foreach ($duePurchases as $purchase) {
            if ($totalPaidAmount == 0) {
                break;
            }

            $dueAmount = $purchase->grand_total - $purchase->paid_amount;
            $cashRegister = CashRegister::select('id')
                ->where([
                    ['user_id', Auth::id()],
                    ['warehouse_id', $purchase->warehouse_id],
                    ['status', 1]
                ])->first();

            $cashRegisterId = $cashRegister ? $cashRegister->id : null;

            if ($totalPaidAmount >= $dueAmount) {
                $paidAmount = $dueAmount;
                $paymentStatus = 2;
            } else {
                $paidAmount = $totalPaidAmount;
                $paymentStatus = 1;
            }

            $payment = new Payment();
            if ($createdAt) {
                $payment->payment_reference = 'ppr-' . date("Ymd", strtotime($createdAt)) . '-' . date("his");
            } else {
                $payment->payment_reference = 'ppr-' . date("Ymd") . '-' . date("his");
            }

            $payment->purchase_id = $purchase->id;
            $payment->user_id = Auth::id();
            $payment->cash_register_id = $cashRegisterId;
            $payment->account_id = $accountId;
            $payment->amount = $paidAmount;
            $payment->change = 0;
            $payment->paying_method = ($accountId == 1) ? 'cash' : 'bank';
            $payment->payment_note = $note;

            if ($createdAt) {
                $payment->created_at = date('Y-m-d H:i:s', strtotime($createdAt . ' ' . date('H:i:s')));
            }
            $payment->save();

            $paymentIds[] = $payment->id;

            $purchase->paid_amount += $paidAmount;
            $purchase->payment_status = $paymentStatus;
            $purchase->save();
            $totalPaidAmount -= $paidAmount;
        }

        $supplierDue->payment_ids = $paymentIds;
        $supplierDue->save();
    }

    /**
     * Get due clear list for a supplier.
     *
     * @param int|string $supplierId
     * @param string|null $startDate
     * @param string|null $endDate
     * @return Collection
     */
    public function getDueClearList($supplierId, ?string $startDate = null, ?string $endDate = null): Collection
    {
        $query = SupplierDue::where('supplier_id', $supplierId);

        if ($startDate) {
            $formattedStartDate = Carbon::createFromFormat('d-m-Y', $startDate)->format('Y-m-d');
            $query->whereDate('created_at', '>=', $formattedStartDate);
        }
        if ($endDate) {
            $formattedEndDate = Carbon::createFromFormat('d-m-Y', $endDate)->format('Y-m-d');
            $query->whereDate('created_at', '<=', $formattedEndDate);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Update an existing clear due entry.
     *
     * @param int|string $id
     * @param array $data
     * @return SupplierDue
     */
    public function updateClearDue($id, array $data): SupplierDue
    {
        $supplierDue = SupplierDue::findOrFail($id);

        $account = Account::find($supplierDue->account_id);
        if ($account) {
            $account->total_balance += $supplierDue->amount;
            $account->save();
        }

        $supplierDue->account_id = $data['account_id'];
        $supplierDue->amount = $data['amount'];
        $supplierDue->note = $data['note'] ?? null;
        if (!empty($data['created_at'])) {
            $supplierDue->created_at = date('Y-m-d H:i:s', strtotime($data['created_at'] . ' ' . date('H:i:s')));
        }
        $supplierDue->save();

        $newAccount = Account::find($data['account_id']);
        if ($newAccount) {
            $newAccount->total_balance -= $data['amount'];
            $newAccount->save();
        }

        $paymentIds = is_array($supplierDue->payment_ids) ? $supplierDue->payment_ids : json_decode((string) $supplierDue->payment_ids, true);

        if (!empty($paymentIds)) {
            foreach ($paymentIds as $paymentId) {
                $oldPayment = Payment::find($paymentId);
                if ($oldPayment) {
                    $purchase = Purchase::find($oldPayment->purchase_id);
                    if ($purchase) {
                        $purchase->paid_amount -= $oldPayment->amount;
                        $purchase->payment_status = 1;
                        $purchase->save();
                    }
                    $oldPayment->delete();
                }
            }
        }

        $supplierDue->payment_ids = null;
        $supplierDue->save();

        $newPaymentIds = [];
        $totalPaidAmount = $supplierDue->amount;

        $duePurchases = Purchase::select('id', 'warehouse_id', 'grand_total', 'paid_amount', 'payment_status')
            ->where([
                ['payment_status', 1],
                ['supplier_id', $supplierDue->supplier_id]
            ])->get();

        foreach ($duePurchases as $purchase) {
            if ($totalPaidAmount == 0) {
                break;
            }

            $dueAmount = $purchase->grand_total - $purchase->paid_amount;
            $cashRegister = CashRegister::select('id')
                ->where([
                    ['user_id', Auth::id()],
                    ['warehouse_id', $purchase->warehouse_id],
                    ['status', 1]
                ])->first();

            $cashRegisterId = $cashRegister ? $cashRegister->id : null;

            if ($totalPaidAmount >= $dueAmount) {
                $paidAmount = $dueAmount;
                $paymentStatus = 2;
            } else {
                $paidAmount = $totalPaidAmount;
                $paymentStatus = 1;
            }

            $payment = new Payment();
            if (!empty($data['created_at'])) {
                $payment->payment_reference = 'ppr-' . date("Ymd", strtotime($data['created_at'])) . '-' . date("his");
            } else {
                $payment->payment_reference = 'ppr-' . date("Ymd") . '-' . date("his");
            }

            $payment->purchase_id = $purchase->id;
            $payment->user_id = Auth::id();
            $payment->cash_register_id = $cashRegisterId;
            $payment->account_id = $supplierDue->account_id;
            $payment->amount = $paidAmount;
            $payment->change = 0;
            $payment->paying_method = ($supplierDue->account_id == 1) ? 'cash' : 'bank';
            $payment->payment_note = $data['note'] ?? null;

            if (!empty($data['created_at'])) {
                $payment->created_at = date('Y-m-d H:i:s', strtotime($data['created_at'] . ' ' . date('H:i:s')));
            }
            $payment->save();

            $newPaymentIds[] = $payment->id;

            $purchase->paid_amount += $paidAmount;
            $purchase->payment_status = $paymentStatus;
            $purchase->save();
            $totalPaidAmount -= $paidAmount;
        }

        $supplierDue->payment_ids = $newPaymentIds;
        $supplierDue->save();

        return $supplierDue;
    }

    /**
     * Delete a clear due entry.
     *
     * @param int|string $id
     * @return void
     */
    public function deleteClearDue($id): void
    {
        $supplierDue = SupplierDue::findOrFail($id);
        $account = Account::find($supplierDue->account_id);
        if ($account) {
            $account->total_balance += $supplierDue->amount;
            $account->save();
        }

        $paymentIds = is_array($supplierDue->payment_ids) ? $supplierDue->payment_ids : json_decode((string) $supplierDue->payment_ids, true);

        if (!empty($paymentIds)) {
            foreach ($paymentIds as $paymentId) {
                $oldPayment = Payment::find($paymentId);
                if ($oldPayment) {
                    $purchase = Purchase::find($oldPayment->purchase_id);
                    if ($purchase) {
                        $purchase->paid_amount -= $oldPayment->amount;
                        $purchase->payment_status = 1;
                        $purchase->save();
                    }
                    $oldPayment->delete();
                }
            }
        }

        $supplierDue->delete();
    }

    /**
     * Import suppliers from CSV.
     *
     * @param UploadedFile $file
     * @return void
     */
    public function importSuppliers(UploadedFile $file): void
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

        while ($columns = fgetcsv($handle)) {
            if ($columns[0] == "") {
                continue;
            }
            foreach ($columns as $key => $value) {
                $columns[$key] = preg_replace('/\D/', '', $value);
            }
            $data = array_combine($escapedHeader, $columns);

            $supplier = $this->supplierRepository->firstOrNew(['company_name' => $data['companyname']]);
            $supplier->name = $data['name'];
            $supplier->image = $data['image'];
            $supplier->vat_number = $data['vatnumber'] ?? null;
            $supplier->email = $data['email'] ?? null;
            $supplier->phone_number = $data['phonenumber'];
            $supplier->address = $data['address'];
            $supplier->city = $data['city'];
            $supplier->state = $data['state'] ?? null;
            $supplier->postal_code = $data['postalcode'] ?? null;
            $supplier->country = $data['country'] ?? null;
            $supplier->is_active = true;
            $supplier->save();

            if (!empty($data['email']) && $mailSetting) {
                try {
                    $this->setMailInfo($mailSetting);
                    Mail::to($data['email'])->send(new SupplierCreate($data));
                } catch (\Exception $e) {
                    // ignore email failure
                }
            }
        }

        fclose($handle);
        $this->cacheForget('supplier_list');
    }

    /**
     * Deactivate a supplier and delete its image.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteSupplier($id): bool
    {
        $supplier = $this->supplierRepository->find($id);
        if ($supplier) {
            $this->fileDelete('images/supplier/', $supplier->image);
            $this->supplierRepository->deactivate($id);
            $this->cacheForget('supplier_list');
            return true;
        }
        return false;
    }

    /**
     * Deactivate multiple suppliers and delete images.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleSuppliers(array $ids): bool
    {
        foreach ($ids as $id) {
            $supplier = $this->supplierRepository->find($id);
            if ($supplier) {
                $this->fileDelete('images/supplier/', $supplier->image);
            }
        }

        $result = $this->supplierRepository->deactivateMultiple($ids);
        $this->cacheForget('supplier_list');

        return $result;
    }

    /**
     * Get HTML options for supplier select dropdown.
     *
     * @return string
     */
    public function getSupplierOptionsHtml(): string
    {
        $suppliers = $this->supplierRepository->getActiveSuppliers();
        $html = '';
        foreach ($suppliers as $supplier) {
            $html .= '<option value="' . $supplier->id . '">' . $supplier->name . ' (' . $supplier->phone_number . ')' . '</option>';
        }

        return $html;
    }
}
