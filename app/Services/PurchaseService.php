<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Brand;
use App\Models\Currency;
use App\Models\CustomField;
use App\Models\Payment;
use App\Models\PaymentWithCheque;
use App\Models\PaymentWithCreditCard;
use App\Models\PosSetting;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductPurchase;
use App\Models\ProductVariant;
use App\Models\Product_Warehouse;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Variant;
use App\Models\Warehouse;
use App\Repositories\Contracts\PurchaseRepositoryInterface;
use App\Traits\TenantInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;
use Stripe\Stripe;

class PurchaseService
{
    use TenantInfo;

    protected PurchaseRepositoryInterface $purchaseRepository;

    /**
     * PurchaseService constructor.
     *
     * @param PurchaseRepositoryInterface $purchaseRepository
     */
    public function __construct(PurchaseRepositoryInterface $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    /**
     * Get summary data for purchase index.
     *
     * @param Request $request
     * @return array
     */
    public function getIndexFormData(Request $request): array
    {
        $warehouseId = $request->input('warehouse_id', 0);
        $purchaseStatus = $request->input('purchase_status', 0);
        $paymentStatus = $request->input('payment_status', 0);
        $brandId = $request->input('brand_id', 0);

        if ($request->input('starting_date')) {
            $startDate = $request->input('starting_date');
            $endDate = $request->input('ending_date');
        } else {
            $startDate = date("Y-m-d", strtotime('-1 year', strtotime(date('Y-m-d'))));
            $endDate = date("Y-m-d");
        }

        $posSetting = PosSetting::select('stripe_public_key')->latest()->first();
        $warehouses = Warehouse::where('is_active', true)->get();
        $accounts = Account::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();

        $customFields = CustomField::where([
            ['belongs_to', 'purchase'],
            ['is_table', true]
        ])->pluck('name');

        $fieldNames = [];
        foreach ($customFields as $fieldName) {
            $fieldNames[] = str_replace(" ", "_", strtolower($fieldName));
        }

        return [
            'warehouse_id'          => $warehouseId,
            'purchase_status'       => $purchaseStatus,
            'payment_status'        => $paymentStatus,
            'brand_id'              => $brandId,
            'starting_date'         => $startDate,
            'ending_date'           => $endDate,
            'lims_pos_setting_data' => $posSetting,
            'lims_warehouse_list'   => $warehouses,
            'lims_account_list'     => $accounts,
            'lims_brand_list'       => $brands,
            'custom_fields'         => $customFields,
            'field_name'            => $fieldNames,
        ];
    }

    /**
     * Process DataTables server-side response for purchase list.
     *
     * @param Request $request
     * @param array $allPermissions
     * @return array
     */
    public function getPurchaseDataTable(Request $request, array $allPermissions): array
    {
        $columns = [
            1 => 'created_at',
            2 => 'reference_no',
            5 => 'grand_total',
            6 => 'paid_amount',
        ];

        $filters = [
            'starting_date'   => $request->input('starting_date'),
            'ending_date'     => $request->input('ending_date'),
            'warehouse_id'    => $request->input('warehouse_id'),
            'purchase_status' => $request->input('purchase_status'),
            'payment_status'  => $request->input('payment_status'),
        ];

        $totalData = $this->purchaseRepository->countTotalPurchases($filters);
        $limit = ($request->input('length') != -1) ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $orderColumn = $request->input('order.0.column');
        $order = $columns[$orderColumn] ?? 'created_at';
        $dir = $request->input('order.0.dir') ?? 'desc';
        $searchValue = $request->input('search.value');

        $customFields = CustomField::where([
            ['belongs_to', 'purchase'],
            ['is_table', true]
        ])->pluck('name');

        $fieldNames = [];
        foreach ($customFields as $fieldName) {
            $fieldNames[] = str_replace(" ", "_", strtolower($fieldName));
        }

        $purchases = $this->purchaseRepository->getFilteredPurchasesForDataTable($start, $limit, $order, $dir, $filters, $searchValue, $fieldNames);
        $totalFiltered = $this->purchaseRepository->countFilteredPurchasesForDataTable($filters, $searchValue);

        $data = [];
        foreach ($purchases as $key => $purchase) {
            $nestedData = [];
            $nestedData['id'] = $purchase->id;
            $nestedData['key'] = $key;
            $dateFormat = config('date_format') ?: 'd-m-Y';
            $nestedData['date'] = date($dateFormat, strtotime($purchase->created_at));
            $nestedData['reference_no'] = $purchase->reference_no;

            if ($purchase->supplier_id) {
                $supplier = $purchase->supplier;
                $nestedData['supplier'] = $supplier ? ($supplier->name . ' (' . $supplier->company_name . ')') : 'N/A';
            } else {
                $nestedData['supplier'] = 'N/A';
            }

            if ($purchase->status == 1) {
                $nestedData['purchase_status'] = '<div class="badge badge-success">' . trans('file.Received') . '</div>';
            } elseif ($purchase->status == 2) {
                $nestedData['purchase_status'] = '<div class="badge badge-warning">' . trans('file.Partial') . '</div>';
            } elseif ($purchase->status == 3) {
                $nestedData['purchase_status'] = '<div class="badge badge-danger">' . trans('file.Pending') . '</div>';
            } else {
                $nestedData['purchase_status'] = '<div class="badge badge-danger">' . trans('file.Ordered') . '</div>';
            }

            if ($purchase->payment_status == 1) {
                $nestedData['payment_status'] = '<div class="badge badge-danger">' . trans('file.Due') . '</div>';
            } else {
                $nestedData['payment_status'] = '<div class="badge badge-success">' . trans('file.Paid') . '</div>';
            }

            $nestedData['grand_total'] = number_format($purchase->grand_total, (int) (config('decimal') ?: 2));
            $nestedData['paid_amount'] = number_format($purchase->paid_amount, (int) (config('decimal') ?: 2));
            $nestedData['due'] = number_format($purchase->grand_total - $purchase->paid_amount, (int) (config('decimal') ?: 2));

            foreach ($fieldNames as $fieldName) {
                $nestedData[$fieldName] = $purchase->$fieldName;
            }

            $options = '<div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . trans("file.action") . '
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            <li>
                                <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i> ' . trans('file.View') . '</button>
                            </li>';

            if (in_array("purchases-edit", $allPermissions)) {
                $options .= '<li>
                    <a href="' . route('purchases.edit', $purchase->id) . '" class="btn btn-link"><i class="dripicons-document-edit"></i> ' . trans('file.edit') . '</a>
                    </li>';
            }
            if (in_array("purchase-payment-index", $allPermissions)) {
                $options .= '<li>
                    <button type="button" id="view-payment" data-id="' . $purchase->id . '" class="btn btn-link"><i class="fa fa-eye"></i> ' . trans('file.View Payment') . '</button>
                    </li>';
            }
            if (in_array("purchase-payment-add", $allPermissions)) {
                $options .= '<li>
                    <button type="button" id="add-payment" data-id="' . $purchase->id . '" class="btn btn-link" data-toggle="modal" data-target="#add-payment"><i class="fa fa-plus"></i> ' . trans('file.Add Payment') . '</button>
                    </li>';
            }
            if (in_array("purchases-delete", $allPermissions)) {
                $options .= \Form::open(["route" => ["purchases.destroy", $purchase->id], "method" => "DELETE"]) . '
                        <li>
                          <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> ' . trans("file.delete") . '</button>
                        </li>' . \Form::close();
            }

            $options .= '</ul></div>';
            $nestedData['options'] = $options;

            $nestedData['purchase'] = [
                '[ "' . date($dateFormat, strtotime($purchase->created_at)) . '"',
                ' "' . $purchase->reference_no . '"',
                ' "' . $purchase->status . '"',
                ' "' . ($purchase->supplier ? $purchase->supplier->name : 'N/A') . '"',
                ' "' . ($purchase->supplier ? $purchase->supplier->company_name : 'N/A') . '"',
                ' "' . ($purchase->supplier ? $purchase->supplier->email : 'N/A') . '"',
                ' "' . ($purchase->supplier ? $purchase->supplier->phone_number : 'N/A') . '"',
                ' "' . ($purchase->supplier ? $purchase->supplier->address : 'N/A') . '"',
                ' "' . ($purchase->supplier ? $purchase->supplier->city : 'N/A') . '"',
                ' "' . $purchase->id . '"',
                ' "' . $purchase->total_tax . '"',
                ' "' . $purchase->total_discount . '"',
                ' "' . $purchase->total_cost . '"',
                ' "' . $purchase->order_tax . '"',
                ' "' . $purchase->order_tax_rate . '"',
                ' "' . $purchase->order_discount . '"',
                ' "' . $purchase->shipping_cost . '"',
                ' "' . $purchase->grand_total . '"',
                ' "' . $purchase->paid_amount . '"',
                ' "' . preg_replace('/\s+/S', " ", (string) $purchase->note) . '"',
                ' "' . ($purchase->user ? $purchase->user->name : 'N/A') . '"',
                ' "' . ($purchase->user ? $purchase->user->email : 'N/A') . '"',
                ' "' . $purchase->document . '" ]'
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
     * Get data required for create purchase form.
     *
     * @return array
     */
    public function getCreateFormData(): array
    {
        $lims_supplier_list = Supplier::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $custom_fields = CustomField::where('belongs_to', 'purchase')->get();

        return compact('lims_supplier_list', 'lims_warehouse_list', 'lims_tax_list', 'custom_fields');
    }

    /**
     * Create a new purchase transaction.
     *
     * @param array $requestData
     * @param UploadedFile|null $document
     * @return Purchase
     */
    public function createPurchase(array $requestData, ?UploadedFile $document): Purchase
    {
        $data = $requestData;
        $data['user_id'] = Auth::id();

        if (isset($data['created_at'])) {
            $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
        } else {
            $data['created_at'] = date("Y-m-d H:i:s");
        }

        if ($document) {
            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $document->move(public_path('documents/purchase'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move(public_path('documents/purchase'), $documentName);
            }
            $data['document'] = $documentName;
        }

        if (!isset($data['reference_no'])) {
            $data['reference_no'] = 'pr-' . date("Ymd") . '-' . date("his");
        }

        $purchase = $this->purchaseRepository->create($data);

        // Custom fields
        $customFieldData = [];
        $customFields = CustomField::where('belongs_to', 'purchase')->select('name', 'type')->get();
        foreach ($customFields as $customField) {
            $fieldName = str_replace(' ', '_', strtolower($customField->name));
            if (isset($data[$fieldName])) {
                if ($customField->type == 'checkbox' || $customField->type == 'multi_select') {
                    $customFieldData[$fieldName] = implode(",", $data[$fieldName]);
                } else {
                    $customFieldData[$fieldName] = $data[$fieldName];
                }
            }
        }
        if (count($customFieldData)) {
            DB::table('purchases')->where('id', $purchase->id)->update($customFieldData);
        }

        $productIds = $data['product_id'] ?? [];
        $isPack = $data['is_pack'] ?? [];
        $imeiNumbers = $data['imei_number'] ?? [];
        $productCodes = $data['product_code'] ?? [];
        $qtys = $data['qty'] ?? [];
        $recieveds = $data['recieved'] ?? [];
        $purchaseUnitIds = $data['purchase_unit_id'] ?? [];
        $netUnitCosts = $data['net_unit_cost'] ?? [];
        $discounts = $data['discount'] ?? [];
        $taxRates = $data['tax_rate'] ?? [];
        $taxes = $data['tax'] ?? [];
        $totals = $data['subtotal'] ?? [];
        $batchNos = $data['batch_no'] ?? [];
        $expiredDates = $data['expired_date'] ?? [];
        $sellingPrices = $data['selling_price'] ?? [];

        foreach ($productIds as $i => $id) {
            $purchaseUnit = Unit::find($purchaseUnitIds[$i] ?? 0);
            $qty = $qtys[$i] ?? 0;
            $recieved = $recieveds[$i] ?? 0;

            if ($purchaseUnit) {
                if ($purchaseUnit->operator == '*') {
                    $quantity = $recieved * $purchaseUnit->operation_value;
                } elseif ($purchaseUnit->operator == '/') {
                    $quantity = $recieved / $purchaseUnit->operation_value;
                }
            } else {
                $quantity = $recieved;
            }

            $product = Product::find($id);
            if (!$product) {
                continue;
            }

            if (($sellingPrices[$i] ?? 0) > 0) {
                $product->price = $sellingPrices[$i];
                $product->save();
            }

            $productBatchId = null;
            if ($product->is_batch && !empty($batchNos[$i])) {
                $productBatch = ProductBatch::firstOrNew([
                    'product_id' => $id,
                    'batch_no'   => $batchNos[$i]
                ]);
                $productBatch->expired_date = $expiredDates[$i] ?? null;
                $productBatch->qty += $quantity;
                $productBatch->save();
                $productBatchId = $productBatch->id;
            }

            $productVariantId = null;
            if ($product->is_variant) {
                $productVariant = ProductVariant::where([
                    ['product_id', $id],
                    ['item_code', $productCodes[$i]]
                ])->first();
                if ($productVariant) {
                    $productVariant->qty += $quantity;
                    $productVariant->save();
                    $productVariantId = $productVariant->variant_id;
                }
            }

            if ($product->is_diffPrice && isset($data['warehouse_id'])) {
                $productWarehouse = Product_Warehouse::where([
                    ['product_id', $id],
                    ['warehouse_id', $data['warehouse_id']]
                ])->first();
                if ($productWarehouse && ($sellingPrices[$i] ?? 0) > 0) {
                    $productWarehouse->price = $sellingPrices[$i];
                    $productWarehouse->save();
                }
            }

            if ($data['status'] == 1) {
                $product->qty += $quantity;
                $product->save();

                $productWarehouse = Product_Warehouse::where([
                    ['product_id', $id],
                    ['warehouse_id', $data['warehouse_id']]
                ])->first();

                if ($productWarehouse) {
                    $productWarehouse->qty += $quantity;
                } else {
                    $productWarehouse = new Product_Warehouse();
                    $productWarehouse->product_id = $id;
                    $productWarehouse->warehouse_id = $data['warehouse_id'];
                    $productWarehouse->qty = $quantity;
                }

                if ($productBatchId) {
                    $productWarehouse->product_batch_id = $productBatchId;
                }
                if ($productVariantId) {
                    $productWarehouse->variant_id = $productVariantId;
                }
                if (!empty($imeiNumbers[$i])) {
                    $productWarehouse->imei_number = $imeiNumbers[$i];
                }
                $productWarehouse->save();
            }

            ProductPurchase::create([
                'purchase_id'      => $purchase->id,
                'product_id'       => $id,
                'product_batch_id' => $productBatchId,
                'variant_id'       => $productVariantId,
                'imei_number'      => $imeiNumbers[$i] ?? null,
                'qty'              => $qty,
                'recieved'         => $recieved,
                'purchase_unit_id' => $purchaseUnitIds[$i] ?? null,
                'net_unit_cost'    => $netUnitCosts[$i] ?? 0,
                'discount'         => $discounts[$i] ?? 0,
                'tax_rate'         => $taxRates[$i] ?? 0,
                'tax'              => $taxes[$i] ?? 0,
                'total'            => $totals[$i] ?? 0,
                'is_pack'          => $isPack[$i] ?? 0,
                'selling_price'    => $sellingPrices[$i] ?? 0,
            ]);
        }

        return $purchase;
    }

    /**
     * Get data required for edit purchase form.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $lims_supplier_list = Supplier::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_product_purchase_data = ProductPurchase::where('purchase_id', $id)->get();
        $lims_purchase_data = Purchase::find($id);
        $custom_fields = CustomField::where('belongs_to', 'purchase')->get();

        return compact(
            'lims_supplier_list',
            'lims_warehouse_list',
            'lims_tax_list',
            'lims_product_purchase_data',
            'lims_purchase_data',
            'custom_fields'
        );
    }

    /**
     * Update an existing purchase transaction.
     *
     * @param int|string $id
     * @param array $requestData
     * @param UploadedFile|null $document
     * @return Purchase
     */
    public function updatePurchase($id, array $requestData, ?UploadedFile $document): Purchase
    {
        $purchase = $this->purchaseRepository->findOrFail($id);
        $data = $requestData;

        if (isset($data['created_at'])) {
            $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
        }

        if ($document) {
            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $document->move(public_path('documents/purchase'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move(public_path('documents/purchase'), $documentName);
            }
            $data['document'] = $documentName;
        }

        // Reverse previous received items from stock
        $oldProductPurchases = ProductPurchase::where('purchase_id', $id)->get();
        foreach ($oldProductPurchases as $oldItem) {
            $purchaseUnit = Unit::find($oldItem->purchase_unit_id);
            if ($purchaseUnit) {
                if ($purchaseUnit->operator == '*') {
                    $oldQty = $oldItem->recieved * $purchaseUnit->operation_value;
                } else {
                    $oldQty = $oldItem->recieved / $purchaseUnit->operation_value;
                }
            } else {
                $oldQty = $oldItem->recieved;
            }

            $product = Product::find($oldItem->product_id);
            if ($product && $purchase->status == 1) {
                $product->qty -= $oldQty;
                $product->save();

                $productWarehouse = Product_Warehouse::where([
                    ['product_id', $oldItem->product_id],
                    ['warehouse_id', $purchase->warehouse_id]
                ])->first();

                if ($productWarehouse) {
                    $productWarehouse->qty -= $oldQty;
                    $productWarehouse->save();
                }
            }

            if ($oldItem->variant_id) {
                $productVariant = ProductVariant::where([
                    ['product_id', $oldItem->product_id],
                    ['variant_id', $oldItem->variant_id]
                ])->first();
                if ($productVariant) {
                    $productVariant->qty -= $oldQty;
                    $productVariant->save();
                }
            }

            if ($oldItem->product_batch_id) {
                $batch = ProductBatch::find($oldItem->product_batch_id);
                if ($batch) {
                    $batch->qty -= $oldQty;
                    $batch->save();
                }
            }

            $oldItem->delete();
        }

        $purchase->update($data);

        // Custom fields
        $customFieldData = [];
        $customFields = CustomField::where('belongs_to', 'purchase')->select('name', 'type')->get();
        foreach ($customFields as $customField) {
            $fieldName = str_replace(' ', '_', strtolower($customField->name));
            if (isset($data[$fieldName])) {
                if ($customField->type == 'checkbox' || $customField->type == 'multi_select') {
                    $customFieldData[$fieldName] = implode(",", $data[$fieldName]);
                } else {
                    $customFieldData[$fieldName] = $data[$fieldName];
                }
            }
        }
        if (count($customFieldData)) {
            DB::table('purchases')->where('id', $purchase->id)->update($customFieldData);
        }

        // Insert new product purchases
        $productIds = $data['product_id'] ?? [];
        $isPack = $data['is_pack'] ?? [];
        $imeiNumbers = $data['imei_number'] ?? [];
        $productCodes = $data['product_code'] ?? [];
        $qtys = $data['qty'] ?? [];
        $recieveds = $data['recieved'] ?? [];
        $purchaseUnitIds = $data['purchase_unit_id'] ?? [];
        $netUnitCosts = $data['net_unit_cost'] ?? [];
        $discounts = $data['discount'] ?? [];
        $taxRates = $data['tax_rate'] ?? [];
        $taxes = $data['tax'] ?? [];
        $totals = $data['subtotal'] ?? [];
        $batchNos = $data['batch_no'] ?? [];
        $expiredDates = $data['expired_date'] ?? [];
        $sellingPrices = $data['selling_price'] ?? [];

        foreach ($productIds as $i => $id) {
            $purchaseUnit = Unit::find($purchaseUnitIds[$i] ?? 0);
            $qty = $qtys[$i] ?? 0;
            $recieved = $recieveds[$i] ?? 0;

            if ($purchaseUnit) {
                if ($purchaseUnit->operator == '*') {
                    $quantity = $recieved * $purchaseUnit->operation_value;
                } else {
                    $quantity = $recieved / $purchaseUnit->operation_value;
                }
            } else {
                $quantity = $recieved;
            }

            $product = Product::find($id);
            if (!$product) {
                continue;
            }

            if (($sellingPrices[$i] ?? 0) > 0) {
                $product->price = $sellingPrices[$i];
                $product->save();
            }

            $productBatchId = null;
            if ($product->is_batch && !empty($batchNos[$i])) {
                $productBatch = ProductBatch::firstOrNew([
                    'product_id' => $id,
                    'batch_no'   => $batchNos[$i]
                ]);
                $productBatch->expired_date = $expiredDates[$i] ?? null;
                $productBatch->qty += $quantity;
                $productBatch->save();
                $productBatchId = $productBatch->id;
            }

            $productVariantId = null;
            if ($product->is_variant) {
                $productVariant = ProductVariant::where([
                    ['product_id', $id],
                    ['item_code', $productCodes[$i]]
                ])->first();
                if ($productVariant) {
                    $productVariant->qty += $quantity;
                    $productVariant->save();
                    $productVariantId = $productVariant->variant_id;
                }
            }

            if ($data['status'] == 1) {
                $product->qty += $quantity;
                $product->save();

                $productWarehouse = Product_Warehouse::where([
                    ['product_id', $id],
                    ['warehouse_id', $data['warehouse_id']]
                ])->first();

                if ($productWarehouse) {
                    $productWarehouse->qty += $quantity;
                } else {
                    $productWarehouse = new Product_Warehouse();
                    $productWarehouse->product_id = $id;
                    $productWarehouse->warehouse_id = $data['warehouse_id'];
                    $productWarehouse->qty = $quantity;
                }

                if ($productBatchId) {
                    $productWarehouse->product_batch_id = $productBatchId;
                }
                if ($productVariantId) {
                    $productWarehouse->variant_id = $productVariantId;
                }
                if (!empty($imeiNumbers[$i])) {
                    $productWarehouse->imei_number = $imeiNumbers[$i];
                }
                $productWarehouse->save();
            }

            ProductPurchase::create([
                'purchase_id'      => $purchase->id,
                'product_id'       => $id,
                'product_batch_id' => $productBatchId,
                'variant_id'       => $productVariantId,
                'imei_number'      => $imeiNumbers[$i] ?? null,
                'qty'              => $qty,
                'recieved'         => $recieved,
                'purchase_unit_id' => $purchaseUnitIds[$i] ?? null,
                'net_unit_cost'    => $netUnitCosts[$i] ?? 0,
                'discount'         => $discounts[$i] ?? 0,
                'tax_rate'         => $taxRates[$i] ?? 0,
                'tax'              => $taxes[$i] ?? 0,
                'total'            => $totals[$i] ?? 0,
                'is_pack'          => $isPack[$i] ?? 0,
                'selling_price'    => $sellingPrices[$i] ?? 0,
            ]);
        }

        return $purchase;
    }

    /**
     * Add payment for a purchase.
     *
     * @param array $requestData
     * @param UploadedFile|null $chequeFile
     * @return Payment
     */
    public function addPayment(array $requestData, ?UploadedFile $chequeFile): Payment
    {
        $data = $requestData;
        $purchase = Purchase::findOrFail($data['purchase_id']);
        $purchase->paid_amount += $data['amount'];

        $balance = $purchase->grand_total - $purchase->paid_amount;
        if ($balance > 0 || $balance < 0) {
            $purchase->payment_status = 1;
        } elseif ($balance == 0) {
            $purchase->payment_status = 2;
        }
        $purchase->save();

        if (empty($data['payment_reference'])) {
            $data['payment_reference'] = 'ppr-' . date("Ymd") . '-' . date("his");
        }

        $data['user_id'] = Auth::id();
        $data['change'] = $data['paying_amount'] - $data['amount'];
        $payment = Payment::create($data);

        $account = Account::find($data['account_id']);
        if ($account) {
            $account->total_balance -= $data['amount'];
            $account->save();
        }

        if ($data['paid_by_id'] == 2) {
            // Credit Card
            Stripe::setApiKey(config('stripe.secret_key'));
            $token = $data['stripeToken'];
            $amount = $data['amount'];

            $charge = Charge::create([
                'amount'   => $amount * 100,
                'currency' => config('currency'),
                'source'   => $token,
            ]);

            PaymentWithCreditCard::create([
                'payment_id'      => $payment->id,
                'customer_id'     => $purchase->supplier_id,
                'customer_stripe_id' => $charge->customer ?? null,
                'charge_id'       => $charge->id,
            ]);
        } elseif ($data['paid_by_id'] == 4 && $chequeFile) {
            // Cheque
            $ext = pathinfo($chequeFile->getClientOriginalName(), PATHINFO_EXTENSION);
            $chequeName = date("Ymdhis") . '.' . $ext;
            $chequeFile->move(public_path('documents/cheque'), $chequeName);

            PaymentWithCheque::create([
                'payment_id'    => $payment->id,
                'cheque_no'     => $data['cheque_no'],
                'cheque_file'   => $chequeName,
            ]);
        }

        return $payment;
    }

    /**
     * Get payments for a purchase.
     *
     * @param int|string $purchaseId
     * @return array
     */
    public function getPaymentsByPurchaseId($purchaseId): array
    {
        $payments = Payment::where('purchase_id', $purchaseId)->get();
        $paymentDate = [];
        $paymentReference = [];
        $paidAmount = [];
        $payingMethod = [];
        $paymentId = [];
        $paymentNote = [];
        $chequeNo = [];
        $change = [];
        $payingAmount = [];
        $accountId = [];

        foreach ($payments as $payment) {
            $paymentDate[] = date(config('date_format'), strtotime($payment->created_at));
            $paymentReference[] = $payment->payment_reference;
            $paidAmount[] = $payment->amount;
            $change[] = $payment->change;
            $payingMethod[] = $payment->paying_method;
            $payingAmount[] = $payment->amount + $payment->change;
            $paymentId[] = $payment->id;
            $paymentNote[] = $payment->payment_note;
            $accountId[] = $payment->account_id;

            if ($payment->paying_method == 'Cheque') {
                $cheque = PaymentWithCheque::where('payment_id', $payment->id)->first();
                $chequeNo[] = $cheque ? $cheque->cheque_no : '';
            } else {
                $chequeNo[] = '';
            }
        }

        return [
            $paymentDate,
            $paymentReference,
            $paidAmount,
            $payingMethod,
            $paymentId,
            $paymentNote,
            $chequeNo,
            $change,
            $payingAmount,
            $accountId
        ];
    }

    /**
     * Update an existing payment.
     *
     * @param array $requestData
     * @param UploadedFile|null $chequeFile
     * @return Payment
     */
    public function updatePayment(array $requestData, ?UploadedFile $chequeFile): Payment
    {
        $data = $requestData;
        $payment = Payment::findOrFail($data['payment_id']);
        $purchase = Purchase::findOrFail($payment->purchase_id);

        $purchase->paid_amount -= $payment->amount;
        $purchase->paid_amount += $data['edit_amount'];

        $balance = $purchase->grand_total - $purchase->paid_amount;
        if ($balance > 0 || $balance < 0) {
            $purchase->payment_status = 1;
        } elseif ($balance == 0) {
            $purchase->payment_status = 2;
        }
        $purchase->save();

        $account = Account::find($payment->account_id);
        if ($account) {
            $account->total_balance += $payment->amount;
            $account->save();
        }

        $payment->account_id = $data['edit_account_id'];
        $payment->amount = $data['edit_amount'];
        $payment->change = $data['edit_paying_amount'] - $data['edit_amount'];
        $payment->payment_note = $data['edit_payment_note'] ?? null;

        if ($data['edit_paid_by_id'] == 1) {
            $payment->paying_method = 'Cash';
        } elseif ($data['edit_paid_by_id'] == 2) {
            $payment->paying_method = 'Credit Card';
        } elseif ($data['edit_paid_by_id'] == 4) {
            $payment->paying_method = 'Cheque';
            if ($chequeFile) {
                $ext = pathinfo($chequeFile->getClientOriginalName(), PATHINFO_EXTENSION);
                $chequeName = date("Ymdhis") . '.' . $ext;
                $chequeFile->move(public_path('documents/cheque'), $chequeName);

                $cheque = PaymentWithCheque::where('payment_id', $payment->id)->first();
                if ($cheque) {
                    $cheque->cheque_no = $data['edit_cheque_no'];
                    $cheque->cheque_file = $chequeName;
                    $cheque->save();
                } else {
                    PaymentWithCheque::create([
                        'payment_id'  => $payment->id,
                        'cheque_no'   => $data['edit_cheque_no'],
                        'cheque_file' => $chequeName,
                    ]);
                }
            }
        }

        $payment->save();

        $newAccount = Account::find($data['edit_account_id']);
        if ($newAccount) {
            $newAccount->total_balance -= $data['edit_amount'];
            $newAccount->save();
        }

        return $payment;
    }

    /**
     * Delete a payment.
     *
     * @param int|string $paymentId
     * @return bool
     */
    public function deletePayment($paymentId): bool
    {
        $payment = Payment::findOrFail($paymentId);
        $purchase = Purchase::findOrFail($payment->purchase_id);
        $purchase->paid_amount -= $payment->amount;

        $balance = $purchase->grand_total - $purchase->paid_amount;
        if ($balance > 0 || $balance < 0) {
            $purchase->payment_status = 1;
        } elseif ($balance == 0) {
            $purchase->payment_status = 2;
        }
        $purchase->save();

        $account = Account::find($payment->account_id);
        if ($account) {
            $account->total_balance += $payment->amount;
            $account->save();
        }

        if ($payment->paying_method == 'Cheque') {
            $cheque = PaymentWithCheque::where('payment_id', $paymentId)->first();
            if ($cheque) {
                @unlink(public_path('documents/cheque/' . $cheque->cheque_file));
                $cheque->delete();
            }
        }

        return $payment->delete();
    }

    /**
     * Delete a purchase and revert stock.
     *
     * @param int|string $id
     * @return bool
     */
    public function deletePurchase($id): bool
    {
        $purchase = Purchase::findOrFail($id);
        $productPurchases = ProductPurchase::where('purchase_id', $id)->get();

        foreach ($productPurchases as $item) {
            $purchaseUnit = Unit::find($item->purchase_unit_id);
            if ($purchaseUnit) {
                if ($purchaseUnit->operator == '*') {
                    $quantity = $item->recieved * $purchaseUnit->operation_value;
                } else {
                    $quantity = $item->recieved / $purchaseUnit->operation_value;
                }
            } else {
                $quantity = $item->recieved;
            }

            $product = Product::find($item->product_id);
            if ($product && $purchase->status == 1) {
                $product->qty -= $quantity;
                $product->save();

                $productWarehouse = Product_Warehouse::where([
                    ['product_id', $item->product_id],
                    ['warehouse_id', $purchase->warehouse_id]
                ])->first();

                if ($productWarehouse) {
                    $productWarehouse->qty -= $quantity;
                    $productWarehouse->save();
                }
            }

            if ($item->variant_id) {
                $productVariant = ProductVariant::where([
                    ['product_id', $item->product_id],
                    ['variant_id', $item->variant_id]
                ])->first();
                if ($productVariant) {
                    $productVariant->qty -= $quantity;
                    $productVariant->save();
                }
            }

            if ($item->product_batch_id) {
                $batch = ProductBatch::find($item->product_batch_id);
                if ($batch) {
                    $batch->qty -= $quantity;
                    $batch->save();
                }
            }

            $item->delete();
        }

        $payments = Payment::where('purchase_id', $id)->get();
        foreach ($payments as $payment) {
            $account = Account::find($payment->account_id);
            if ($account) {
                $account->total_balance += $payment->amount;
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

        if ($purchase->document) {
            @unlink(public_path('documents/purchase/' . $purchase->document));
        }

        return $purchase->delete();
    }

    /**
     * Delete multiple purchases by IDs.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultiplePurchases(array $ids): bool
    {
        foreach ($ids as $id) {
            $this->deletePurchase($id);
        }
        return true;
    }
}
