<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Biller;
use App\Models\CashRegister;
use App\Models\Coupon;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\CustomField;
use App\Models\Delivery;
use App\Models\GiftCard;
use App\Models\Payment;
use App\Models\PaymentWithCheque;
use App\Models\PaymentWithCreditCard;
use App\Models\PaymentWithGiftCard;
use App\Models\PaymentWithPaypal;
use App\Models\PosSetting;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductVariant;
use App\Models\Product_Sale;
use App\Models\Product_Warehouse;
use App\Models\RewardPointSetting;
use App\Models\Sale;
use App\Models\Table;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Variant;
use App\Models\Warehouse;
use App\Repositories\Contracts\SaleRepositoryInterface;
use App\Traits\TenantInfo;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\SaleStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SaleService
{
    use TenantInfo;

    protected SaleRepositoryInterface $saleRepository;

    /**
     * SaleService constructor.
     *
     * @param SaleRepositoryInterface $saleRepository
     */
    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    /**
     * Get index form data for sale list.
     *
     * @param Request $request
     * @return array
     */
    public function getIndexFormData(Request $request): array
    {
        $warehouseId = $request->input('warehouse_id', 0);
        $saleStatus = $request->input('sale_status', 0);
        $paymentStatus = $request->input('payment_status', 0);
        $brandId = $request->input('brand_id', 0);
        $saleType = $request->input('sale_type', '');

        if ($request->input('starting_date')) {
            $startDate = $request->input('starting_date');
            $endDate = $request->input('ending_date');
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $startDate)) {
                $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', $startDate)->format('Y-m-d');
            }
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $endDate)) {
                $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', $endDate)->format('Y-m-d');
            }
        } else {
            $startDate = date("Y-m-d", strtotime('-1 year', strtotime(date('Y-m-d'))));
            $endDate = date("Y-m-d");
        }

        $warehouses = Warehouse::where('is_active', true)->get();
        $accounts = Account::where('is_active', true)->get();
        $posSetting = PosSetting::latest()->first();

        $customFields = CustomField::where([
            ['belongs_to', 'sale'],
            ['is_table', true]
        ])->pluck('name');

        $fieldNames = [];
        foreach ($customFields as $fieldName) {
            $fieldNames[] = str_replace(" ", "_", strtolower($fieldName));
        }

        return [
            'warehouse_id'          => $warehouseId,
            'sale_status'           => $saleStatus,
            'payment_status'        => $paymentStatus,
            'brand_id'              => $brandId,
            'sale_type'             => $saleType,
            'starting_date'         => $startDate,
            'ending_date'           => $endDate,
            'lims_pos_setting_data' => $posSetting,
            'lims_warehouse_list'   => $warehouses,
            'lims_account_list'     => $accounts,
            'custom_fields'         => $customFields,
            'field_name'            => $fieldNames,
        ];
    }

    /**
     * Process DataTables server-side response for sale list.
     *
     * @param Request $request
     * @param array $allPermissions
     * @return array
     */
    public function getSaleDataTable(Request $request, array $allPermissions): array
    {
        $columns = [
            1 => 'created_at',
            2 => 'reference_no',
            7 => 'grand_total',
            8 => 'paid_amount',
        ];

        $filters = [
            'starting_date'  => $request->input('starting_date'),
            'ending_date'    => $request->input('ending_date'),
            'warehouse_id'   => $request->input('warehouse_id'),
            'sale_status'    => $request->input('sale_status'),
            'payment_status' => $request->input('payment_status'),
            'sale_type'      => $request->input('sale_type'),
        ];

        $totalData = $this->saleRepository->countTotalSales($filters);
        $limit = ($request->input('length') != -1) ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $orderColumn = $request->input('order.0.column');
        $order = 'sales.' . ($columns[$orderColumn] ?? 'created_at');
        $dir = $request->input('order.0.dir') ?? 'desc';
        $searchValue = $request->input('search.value');

        $customFields = CustomField::where([
            ['belongs_to', 'sale'],
            ['is_table', true]
        ])->pluck('name');

        $fieldNames = [];
        foreach ($customFields as $fieldName) {
            $fieldNames[] = str_replace(" ", "_", strtolower($fieldName));
        }

        $sales = $this->saleRepository->getFilteredSalesForDataTable($start, $limit, $order, $dir, $filters, $searchValue, $fieldNames);
        $totalFiltered = $this->saleRepository->countFilteredSalesForDataTable($filters, $searchValue);

        $data = [];
        $dateFormat = config('date_format') ?: 'd-m-Y';

        foreach ($sales as $key => $sale) {
            $nestedData = [];
            $nestedData['id'] = $sale->id;
            $nestedData['key'] = $key;
            $nestedData['date'] = date($dateFormat, strtotime($sale->created_at));
            $nestedData['reference_no'] = $sale->reference_no;
            $nestedData['biller'] = $sale->biller ? ($sale->biller->name . ' (' . $sale->biller->company_name . ')') : 'N/A';
            $nestedData['customer'] = $sale->customer ? ($sale->customer->name . ' (' . $sale->customer->phone_number . ')') : 'N/A';

            $nestedData['sale_status'] = SaleStatus::tryFrom((int) $sale->sale_status)?->badge() ?? '';
            $nestedData['payment_status'] = PaymentStatus::tryFrom((int) $sale->payment_status)?->badge() ?? '';

            $nestedData['grand_total'] = number_format($sale->grand_total, (int) (config('decimal') ?: 2));
            $nestedData['paid_amount'] = number_format($sale->paid_amount, (int) (config('decimal') ?: 2));
            $nestedData['due'] = number_format($sale->grand_total - $sale->paid_amount, (int) (config('decimal') ?: 2));

            foreach ($fieldNames as $fieldName) {
                $nestedData[$fieldName] = $sale->$fieldName;
            }

            $options = '<div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . trans("file.action") . '
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            <li>
                                <a href="' . route('sale.invoice', $sale->id) . '" class="btn btn-link"><i class="fa fa-copy"></i> ' . trans('file.Generate Invoice') . '</a>
                            </li>
                            <li>
                                <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i> ' . trans('file.View') . '</button>
                            </li>';

            if (in_array("sales-edit", $allPermissions)) {
                if ($sale->sale_status == 3) {
                    $options .= '<li>
                        <a href="' . route('sale.draft', $sale->id) . '" class="btn btn-link"><i class="dripicons-document-edit"></i> ' . trans('file.edit') . '</a>
                        </li>';
                } else {
                    $options .= '<li>
                        <a href="' . route('sales.edit', $sale->id) . '" class="btn btn-link"><i class="dripicons-document-edit"></i> ' . trans('file.edit') . '</a>
                        </li>';
                }
            }
            if (in_array("sale-payment-index", $allPermissions)) {
                $options .= '<li>
                    <button type="button" id="view-payment" data-id="' . $sale->id . '" class="btn btn-link"><i class="fa fa-eye"></i> ' . trans('file.View Payment') . '</button>
                    </li>';
            }
            if (in_array("sale-payment-add", $allPermissions)) {
                $options .= '<li>
                    <button type="button" id="add-payment" data-id="' . $sale->id . '" class="btn btn-link" data-toggle="modal" data-target="#add-payment"><i class="fa fa-plus"></i> ' . trans('file.Add Payment') . '</button>
                    </li>';
            }
            if (in_array("delivery", $allPermissions)) {
                $options .= '<li>
                    <button type="button" id="add-delivery" data-id="' . $sale->id . '" class="btn btn-link"><i class="fa fa-truck"></i> ' . trans('file.Add Delivery') . '</button>
                    </li>';
            }
            if (in_array("sales-delete", $allPermissions)) {
                $options .= \Form::open(["route" => ["sales.destroy", $sale->id], "method" => "DELETE"]) . '
                        <li>
                          <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> ' . trans("file.delete") . '</button>
                        </li>' . \Form::close();
            }

            $options .= '</ul></div>';
            $nestedData['options'] = $options;

            $nestedData['sale'] = [
                '[ "' . date($dateFormat, strtotime($sale->created_at)) . '"',
                ' "' . $sale->reference_no . '"',
                ' "' . $sale->sale_status . '"',
                ' "' . ($sale->biller ? $sale->biller->name : 'N/A') . '"',
                ' "' . ($sale->biller ? $sale->biller->company_name : 'N/A') . '"',
                ' "' . ($sale->biller ? $sale->biller->email : 'N/A') . '"',
                ' "' . ($sale->biller ? $sale->biller->phone_number : 'N/A') . '"',
                ' "' . ($sale->biller ? $sale->biller->address : 'N/A') . '"',
                ' "' . ($sale->biller ? $sale->biller->city : 'N/A') . '"',
                ' "' . ($sale->customer ? $sale->customer->name : 'N/A') . '"',
                ' "' . ($sale->customer ? $sale->customer->phone_number : 'N/A') . '"',
                ' "' . ($sale->customer ? $sale->customer->address : 'N/A') . '"',
                ' "' . ($sale->customer ? $sale->customer->city : 'N/A') . '"',
                ' "' . $sale->id . '"',
                ' "' . $sale->total_tax . '"',
                ' "' . $sale->total_discount . '"',
                ' "' . $sale->total_price . '"',
                ' "' . $sale->order_tax . '"',
                ' "' . $sale->order_tax_rate . '"',
                ' "' . $sale->order_discount . '"',
                ' "' . $sale->shipping_cost . '"',
                ' "' . $sale->grand_total . '"',
                ' "' . $sale->paid_amount . '"',
                ' "' . preg_replace('/\s+/S', " ", (string) $sale->sale_note) . '"',
                ' "' . preg_replace('/\s+/S', " ", (string) $sale->staff_note) . '"',
                ' "' . ($sale->user ? $sale->user->name : 'N/A') . '"',
                ' "' . ($sale->user ? $sale->user->email : 'N/A') . '"',
                ' "' . $sale->warehouse_id . '"',
                ' "' . $sale->coupon_id . '"',
                ' "' . $sale->document . '" ]'
            ];

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
     * Main store function
     */
    public function store(array $data)
    {
        $rules = [
            'warehouse_id' => 'required',
        ];

        if (!isset($data['sale_type']) || $data['sale_type'] !== 'website') {
            $rules['biller_id'] = 'required';
            $rules['customer_id'] = 'required';
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return DB::transaction(function () use ($data) {
            if (isset($data['sale_type']) && $data['sale_type'] === 'website') {
                $customer = Customer::where('phone_number', $data['customer_info']['phone_number'])->first();
                if (!$customer) {
                    $customer = $this->createCustomer(
                        $data['customer_info']
                    );
                }
                $data['customer_id'] = $customer->id;
            }

            $data['user_id'] = Auth::id() ? Auth::id() : 1;

            // Cash Register
            $register = CashRegister::where([
                ['user_id', $data['user_id']],
                ['warehouse_id', $data['warehouse_id']],
                ['status', true]
            ])->first();

            if ($register) {
                $data['cash_register_id'] = $register->id;
            }

            // Date set
            $data['created_at'] = isset($data['created_at'])
                ? date("Y-m-d H:i:s", strtotime($data['created_at'] . ' ' . date('H:i:s')))
                : now();

            // Reference No
            if (!isset($data['reference_no'])) {
                $data['reference_no'] = !empty($data['pos'])
                    ? 'posr-' . date("Ymd") . '-' . date("his")
                    : 'sr-' . date("Ymd") . '-' . date("his");
            }

            if (isset($data['sale_type']) && $data['sale_type'] === 'website') {
                $data['sale_type'] = 'website';
            }

            // Payment Status
            if (!empty($data['pos'])) {
                $balance = $data['grand_total'] - $data['paid_amount'];
                $data['payment_status'] = ($balance == 0 ? PaymentStatus::PAID->value : PaymentStatus::DUE->value);

                if (!empty($data['draft'])) {
                    Sale::where('id', $data['sale_id'])->delete();
                    Product_Sale::where('sale_id', $data['sale_id'])->delete();
                }
            }

            if (!empty($data['coupon_active'])) {
                $coupon = Coupon::find($data['coupon_id']);
                if ($coupon) {
                    $coupon->increment('used');
                }
            }

            // Create Sale
            $sale = Sale::create($data);

            // Customer Reward Points
            $customer = Customer::find($data['customer_id']);
            $reward = RewardPointSetting::first();

            if ($reward && $reward->is_active && $customer && $data['grand_total'] >= $reward->minimum_amount) {
                $points = (int) ($data['grand_total'] / $reward->per_point_amount);
                $customer->increment('points', $points);
            }

            // Save Products & Update Inventory
            $mail_data = $this->saveProductsAndUpdateStock($data, $sale, $customer);

            // Payments
            if (!empty($data['paid_amount']) && $data['paid_amount'] > 0) {
                $this->storePayment($data, $sale->id, $register ?? null);
            }

            return [
                'sale'      => $sale,
                'mail_data' => $mail_data,
                'message'   => 'Sale created successfully'
            ];
        });
    }

    private function createCustomer($customer_info)
    {
        $customer = new Customer();
        $customer->name = $customer_info['name'];
        $customer->phone_number = $customer_info['phone_number'];
        $customer->address = $customer_info['address'];
        $customer->city = $customer_info['city'];
        $customer->customer_group_id = 1;
        $customer->is_active = true;
        $customer->save();

        return $customer;
    }

    private function saveProductsAndUpdateStock($data, $sale, $customer)
    {
        $mail_data = [
            'email'          => $customer ? $customer->email : '',
            'reference_no'   => $sale->reference_no,
            'sale_status'    => $sale->sale_status,
            'payment_status' => $sale->payment_status,
            'total_qty'      => $sale->total_qty,
            'total_price'    => $sale->total_price,
            'order_tax'      => $sale->order_tax,
            'order_tax_rate' => $sale->order_tax_rate,
            'order_discount' => $sale->order_discount,
            'shipping_cost'  => $sale->shipping_cost,
            'grand_total'    => $sale->grand_total,
            'paid_amount'    => $sale->paid_amount,
            'products'       => [],
            'file'           => [],
            'unit'           => [],
            'qty'            => [],
            'total'          => [],
        ];

        foreach ($data['product_id'] as $i => $product_id) {
            $product = Product::find($product_id);
            if (!$product) {
                continue;
            }

            $quantity = $data['qty'][$i];
            $sale_unit_id = $data['sale_unit_id'][$i] ?? 0;
            $unit = Unit::find($sale_unit_id);

            $units = Unit::where("base_unit", $product->unit_id)->orWhere('id', $product->unit_id)->get();
            $sale_unit = $units->firstWhere('id', $sale_unit_id);

            $converted_qty = $sale_unit
                ? ($sale_unit->operator === '*'
                    ? $quantity * $sale_unit->operation_value
                    : $quantity / $sale_unit->operation_value)
                : $quantity;

            $product_sale = [
                'sale_id'          => $sale->id,
                'product_id'       => $product_id,
                'product_batch_id' => $data['product_batch_id'][$i] ?? null,
                'variant_id'       => null,
            ];

            if ($product->is_variant) {
                $variant = ProductVariant::where('product_id', $product_id)
                    ->where('item_code', $data['product_code'][$i])
                    ->first();
                if ($variant) {
                    $product_sale['variant_id'] = $variant->variant_id;
                    $variant->decrement('qty', $converted_qty);
                }
            }

            if ($product->type === 'standard') {
                $product->decrement('qty', $converted_qty);
                $this->mergeProductWarehouseDuplicates($product_id, $product_sale['variant_id']);

                $pw_query = Product_Warehouse::where('warehouse_id', $data['warehouse_id'])
                    ->where('product_id', $product_id);

                if (!empty($data['product_batch_id'][$i])) {
                    $pw_query->where('product_batch_id', $data['product_batch_id'][$i]);
                }

                if (!empty($product_sale['variant_id'])) {
                    $pw_query->where('variant_id', $product_sale['variant_id']);
                }

                $product_warehouse = $pw_query->first();
                if ($product_warehouse) {
                    $product_warehouse->decrement('qty', $converted_qty);
                }
            }

            $mail_data['products'][$i] = $product_sale['variant_id']
                ? $product->name . ' [' . ($variant ? $variant->name : '') . ']'
                : $product->name;

            $mail_data['file'][$i] = $product->type === 'digital' ? url('/public/product/files') . '/' . $product->file : '';
            $mail_data['unit'][$i] = $sale_unit_id && $unit ? $unit->unit_code : '';
            $mail_data['qty'][$i] = $quantity;
            $mail_data['total'][$i] = $data['subtotal'][$i] ?? 0;

            $product_sale = array_merge($product_sale, [
                'qty'            => $quantity,
                'sale_unit_id'   => $sale_unit_id,
                'net_unit_price' => $data['unit_price'][$i] ?? 0,
                'discount'       => $data['product_discount'][$i] ?? 0,
                'tax_rate'       => $data['tax_rate'][$i] ?? 0,
                'tax'            => $data['tax'][$i] ?? 0,
                'total'          => $data['subtotal'][$i] ?? 0,
                'imei_number'    => $data['imei_number'][$i] ?? null,
            ]);

            Product_Sale::create($product_sale);
        }

        return $mail_data;
    }

    private function storePayment($data, $sale_id, $register)
    {
        $payment = new Payment();
        $payment->user_id = Auth::id() ? Auth::id() : 1;
        $payment->sale_id = $sale_id;
        $payment->cash_register_id = $register ? $register->id : null;

        $payment->amount = $data['paid_amount'];
        $payment->change = ($data['paying_amount'] ?? $data['paid_amount']) - $data['paid_amount'];
        $payment->payment_reference = 'spr-' . date("Ymd") . "-" . date("his");
        $payment->paying_method = $this->getPayMethod($data['paid_by_id'] ?? 1);
        $payment->payment_note = $data['payment_note'] ?? null;
        $payment->account_id = Account::where('is_default', true)->value('id') ?? 1;

        $payment->save();

        return $payment;
    }

    private function getPayMethod($id)
    {
        return PaymentMethod::tryFrom((int) $id)?->label() ?? 'Cash';
    }

    private function mergeProductWarehouseDuplicates(int $product_id, ?int $variant_id)
    {
        $query = DB::table('product_warehouse')
            ->select('warehouse_id', 'product_batch_id', DB::raw('COUNT(*) as count'))
            ->where('product_id', $product_id);

        if ($variant_id !== null) {
            $query = $query->where('variant_id', $variant_id);
        } else {
            $query = $query->whereNull('variant_id');
        }

        $duplicates = $query->groupBy('warehouse_id', 'product_batch_id')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $dup) {
            $rowsQuery = DB::table('product_warehouse')
                ->where('product_id', $product_id)
                ->where('warehouse_id', $dup->warehouse_id)
                ->where('product_batch_id', $dup->product_batch_id);

            if ($variant_id !== null) {
                $rowsQuery = $rowsQuery->where('variant_id', $variant_id);
            } else {
                $rowsQuery = $rowsQuery->whereNull('variant_id');
            }

            $rows = $rowsQuery->orderBy('id', 'asc')->get();

            $firstRow = $rows->first();
            $totalQty = $rows->sum('qty');

            DB::table('product_warehouse')
                ->where('id', $firstRow->id)
                ->update(['qty' => $totalQty]);

            $deleteIds = $rows->slice(1)->pluck('id')->toArray();
            DB::table('product_warehouse')
                ->whereIn('id', $deleteIds)
                ->delete();
        }
    }

    /**
     * Delete a sale and revert stock.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteSale($id): bool
    {
        $sale = Sale::findOrFail($id);
        $productSales = Product_Sale::where('sale_id', $id)->get();

        foreach ($productSales as $item) {
            $saleUnit = Unit::find($item->sale_unit_id);
            if ($saleUnit) {
                if ($saleUnit->operator == '*') {
                    $quantity = $item->qty * $saleUnit->operation_value;
                } else {
                    $quantity = $item->qty / $saleUnit->operation_value;
                }
            } else {
                $quantity = $item->qty;
            }

            $product = Product::find($item->product_id);
            if ($product && $sale->sale_status == 1) {
                $product->qty += $quantity;
                $product->save();

                $productWarehouse = Product_Warehouse::where([
                    ['product_id', $item->product_id],
                    ['warehouse_id', $sale->warehouse_id]
                ])->first();

                if ($productWarehouse) {
                    $productWarehouse->qty += $quantity;
                    $productWarehouse->save();
                }
            }

            if ($item->variant_id) {
                $productVariant = ProductVariant::where([
                    ['product_id', $item->product_id],
                    ['variant_id', $item->variant_id]
                ])->first();
                if ($productVariant) {
                    $productVariant->qty += $quantity;
                    $productVariant->save();
                }
            }

            if ($item->product_batch_id) {
                $batch = ProductBatch::find($item->product_batch_id);
                if ($batch) {
                    $batch->qty += $quantity;
                    $batch->save();
                }
            }

            $item->delete();
        }

        $payments = Payment::where('sale_id', $id)->get();
        foreach ($payments as $payment) {
            $account = Account::find($payment->account_id);
            if ($account) {
                $account->total_balance -= $payment->amount;
                $account->save();
            }
            if ($payment->paying_method == 'Cheque') {
                $cheque = PaymentWithCheque::where('payment_id', $payment->id)->first();
                if ($cheque) {
                    @unlink(public_path('documents/cheque/' . $cheque->cheque_file));
                    $cheque->delete();
                }
            }
            $payment->delete();
        }

        Delivery::where('sale_id', $id)->delete();

        if ($sale->document) {
            @unlink(public_path('documents/sale/' . $sale->document));
        }

        return $sale->delete();
    }

    /**
     * Delete multiple sales.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleSales(array $ids): bool
    {
        foreach ($ids as $id) {
            $this->deleteSale($id);
        }
        return true;
    }
}
