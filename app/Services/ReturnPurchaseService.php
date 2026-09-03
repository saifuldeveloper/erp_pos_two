<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductVariant;
use App\Models\Product_Warehouse;
use App\Models\PurchaseProductReturn;
use App\Models\ReturnPurchase;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Repositories\Contracts\ReturnPurchaseRepositoryInterface;
use App\Traits\TenantInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturnPurchaseService
{
    use TenantInfo;

    protected ReturnPurchaseRepositoryInterface $returnPurchaseRepository;

    /**
     * ReturnPurchaseService constructor.
     *
     * @param ReturnPurchaseRepositoryInterface $returnPurchaseRepository
     */
    public function __construct(ReturnPurchaseRepositoryInterface $returnPurchaseRepository)
    {
        $this->returnPurchaseRepository = $returnPurchaseRepository;
    }

    /**
     * Process DataTables server-side response for purchase return list.
     *
     * @param Request $request
     * @param array $allPermissions
     * @return array
     */
    public function getReturnDataTable(Request $request, array $allPermissions): array
    {
        $columns = [
            1 => 'created_at',
            2 => 'reference_no',
        ];

        $warehouseId = $request->input('warehouse_id');
        $startDate = $request->input('starting_date');
        $endDate = $request->input('ending_date');
        $searchValue = $request->input('search.value');

        $totalData = $this->returnPurchaseRepository->countTotalReturns($warehouseId, $startDate, $endDate);
        $limit = ($request->input('length') != -1) ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $orderColumn = $request->input('order.0.column');
        $order = 'return_purchases.' . ($columns[$orderColumn] ?? 'created_at');
        $dir = $request->input('order.0.dir') ?? 'desc';

        $returns = $this->returnPurchaseRepository->getFilteredReturnsForDataTable($start, $limit, $order, $dir, $warehouseId, $startDate, $endDate, $searchValue);
        $totalFiltered = $this->returnPurchaseRepository->countFilteredReturnsForDataTable($warehouseId, $startDate, $endDate, $searchValue);

        $data = [];
        foreach ($returns as $key => $return) {
            $nestedData = [];
            $nestedData['id'] = $return->id;
            $nestedData['key'] = $key;
            $dateFormat = config('date_format') ?: 'd-m-Y';
            $nestedData['date'] = date($dateFormat, strtotime($return->created_at));
            $nestedData['reference_no'] = $return->reference_no;
            $nestedData['warehouse'] = $return->warehouse ? $return->warehouse->name : 'N/A';

            if ($return->supplier_id) {
                $supplier = $return->supplier;
                $nestedData['supplier'] = $supplier ? ($supplier->name . ' (' . $supplier->company_name . ')') : 'N/A';
            } else {
                $nestedData['supplier'] = 'N/A';
            }

            $nestedData['grand_total'] = number_format($return->grand_total, (int) (config('decimal') ?: 2));

            $options = '<div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . trans("file.action") . '
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            <li>
                                <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i> ' . trans('file.View') . '</button>
                            </li>';

            if (in_array("returns-edit", $allPermissions)) {
                $options .= '<li>
                    <a href="' . route('return-purchase.edit', $return->id) . '" class="btn btn-link"><i class="dripicons-document-edit"></i> ' . trans('file.edit') . '</a>
                    </li>';
            }
            if (in_array("returns-delete", $allPermissions)) {
                $options .= \Form::open(["route" => ["return-purchase.destroy", $return->id], "method" => "DELETE"]) . '
                        <li>
                          <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> ' . trans("file.delete") . '</button>
                        </li>' . \Form::close();
            }

            $options .= '</ul></div>';
            $nestedData['options'] = $options;

            $account = Account::find($return->account_id);
            $nestedData['return'] = [
                '[ "' . date($dateFormat, strtotime($return->created_at)) . '"',
                ' "' . $return->reference_no . '"',
                ' "' . ($return->warehouse ? $return->warehouse->name : 'N/A') . '"',
                ' "' . ($return->supplier ? $return->supplier->name : 'N/A') . '"',
                ' "' . ($return->supplier ? $return->supplier->company_name : 'N/A') . '"',
                ' "' . ($return->supplier ? $return->supplier->email : 'N/A') . '"',
                ' "' . ($return->supplier ? $return->supplier->phone_number : 'N/A') . '"',
                ' "' . ($return->supplier ? $return->supplier->address : 'N/A') . '"',
                ' "' . ($return->supplier ? $return->supplier->city : 'N/A') . '"',
                ' "' . $return->id . '"',
                ' "' . $return->total_tax . '"',
                ' "' . $return->total_discount . '"',
                ' "' . $return->total_cost . '"',
                ' "' . $return->order_tax . '"',
                ' "' . $return->order_tax_rate . '"',
                ' "' . $return->order_discount . '"',
                ' "' . $return->shipping_cost . '"',
                ' "' . $return->grand_total . '"',
                ' "' . preg_replace('/\s+/S', " ", (string) $return->return_note) . '"',
                ' "' . preg_replace('/\s+/S', " ", (string) $return->staff_note) . '"',
                ' "' . ($return->user ? $return->user->name : 'N/A') . '"',
                ' "' . ($return->user ? $return->user->email : 'N/A') . '"',
                ' "' . $return->document . '"',
                ' "' . ($account ? $account->name : 'N/A') . '" ]'
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
     * Get data required for create return purchase form.
     *
     * @return array
     */
    public function getCreateFormData(): array
    {
        $lims_supplier_list = Supplier::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_account_list = Account::where('is_active', true)->get();

        return compact('lims_supplier_list', 'lims_warehouse_list', 'lims_tax_list', 'lims_account_list');
    }

    /**
     * Create a new purchase return transaction.
     *
     * @param array $requestData
     * @param UploadedFile|null $document
     * @return ReturnPurchase
     */
    public function createReturnPurchase(array $requestData, ?UploadedFile $document): ReturnPurchase
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
                $document->move(public_path('documents/purchase_return'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move(public_path('documents/purchase_return'), $documentName);
            }
            $data['document'] = $documentName;
        }

        if (!isset($data['reference_no'])) {
            $data['reference_no'] = 'rr-' . date("Ymd") . '-' . date("his");
        }

        $returnPurchase = $this->returnPurchaseRepository->create($data);

        $account = Account::find($data['account_id']);
        if ($account) {
            $account->total_balance += $data['grand_total'];
            $account->save();
        }

        $productIds = $data['product_id'] ?? [];
        $imeiNumbers = $data['imei_number'] ?? [];
        $productCodes = $data['product_code'] ?? [];
        $qtys = $data['qty'] ?? [];
        $purchaseUnitIds = $data['purchase_unit_id'] ?? [];
        $netUnitCosts = $data['net_unit_cost'] ?? [];
        $discounts = $data['discount'] ?? [];
        $taxRates = $data['tax_rate'] ?? [];
        $taxes = $data['tax'] ?? [];
        $totals = $data['subtotal'] ?? [];
        $batchNos = $data['batch_no'] ?? [];

        foreach ($productIds as $i => $id) {
            $purchaseUnit = Unit::find($purchaseUnitIds[$i] ?? 0);
            $qty = $qtys[$i] ?? 0;

            if ($purchaseUnit) {
                if ($purchaseUnit->operator == '*') {
                    $quantity = $qty * $purchaseUnit->operation_value;
                } elseif ($purchaseUnit->operator == '/') {
                    $quantity = $qty / $purchaseUnit->operation_value;
                }
            } else {
                $quantity = $qty;
            }

            $product = Product::find($id);
            if (!$product) {
                continue;
            }

            $productBatchId = null;
            if ($product->is_batch && !empty($batchNos[$i])) {
                $productBatch = ProductBatch::where([
                    ['product_id', $id],
                    ['batch_no', $batchNos[$i]]
                ])->first();
                if ($productBatch) {
                    $productBatch->qty -= $quantity;
                    $productBatch->save();
                    $productBatchId = $productBatch->id;
                }
            }

            $productVariantId = null;
            if ($product->is_variant) {
                $productVariant = ProductVariant::where([
                    ['product_id', $id],
                    ['item_code', $productCodes[$i]]
                ])->first();
                if ($productVariant) {
                    $productVariant->qty -= $quantity;
                    $productVariant->save();
                    $productVariantId = $productVariant->variant_id;
                }
            }

            $product->qty -= $quantity;
            $product->save();

            $productWarehouse = Product_Warehouse::where([
                ['product_id', $id],
                ['warehouse_id', $data['warehouse_id']]
            ])->first();

            if ($productWarehouse) {
                $productWarehouse->qty -= $quantity;
                $productWarehouse->save();
            }

            PurchaseProductReturn::create([
                'return_id'        => $returnPurchase->id,
                'product_id'       => $id,
                'product_batch_id' => $productBatchId,
                'variant_id'       => $productVariantId,
                'imei_number'      => $imeiNumbers[$i] ?? null,
                'qty'              => $qty,
                'purchase_unit_id' => $purchaseUnitIds[$i] ?? null,
                'net_unit_cost'    => $netUnitCosts[$i] ?? 0,
                'discount'         => $discounts[$i] ?? 0,
                'tax_rate'         => $taxRates[$i] ?? 0,
                'tax'              => $taxes[$i] ?? 0,
                'total'            => $totals[$i] ?? 0,
            ]);
        }

        return $returnPurchase;
    }

    /**
     * Get data required for edit return purchase form.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $lims_supplier_list = Supplier::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_account_list = Account::where('is_active', true)->get();
        $lims_return_data = ReturnPurchase::find($id);
        $lims_product_return_data = PurchaseProductReturn::where('return_id', $id)->get();

        return compact(
            'lims_supplier_list',
            'lims_warehouse_list',
            'lims_tax_list',
            'lims_account_list',
            'lims_return_data',
            'lims_product_return_data'
        );
    }

    /**
     * Update an existing purchase return transaction.
     *
     * @param int|string $id
     * @param array $requestData
     * @param UploadedFile|null $document
     * @return ReturnPurchase
     */
    public function updateReturnPurchase($id, array $requestData, ?UploadedFile $document): ReturnPurchase
    {
        $returnPurchase = $this->returnPurchaseRepository->findOrFail($id);
        $data = $requestData;

        if (isset($data['created_at'])) {
            $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
        }

        if ($document) {
            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $document->move(public_path('documents/purchase_return'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move(public_path('documents/purchase_return'), $documentName);
            }
            $data['document'] = $documentName;
        }

        // Revert previous returned quantities back to stock
        $oldReturns = PurchaseProductReturn::where('return_id', $id)->get();
        foreach ($oldReturns as $oldItem) {
            $purchaseUnit = Unit::find($oldItem->purchase_unit_id);
            if ($purchaseUnit) {
                if ($purchaseUnit->operator == '*') {
                    $oldQty = $oldItem->qty * $purchaseUnit->operation_value;
                } else {
                    $oldQty = $oldItem->qty / $purchaseUnit->operation_value;
                }
            } else {
                $oldQty = $oldItem->qty;
            }

            $product = Product::find($oldItem->product_id);
            if ($product) {
                $product->qty += $oldQty;
                $product->save();

                $productWarehouse = Product_Warehouse::where([
                    ['product_id', $oldItem->product_id],
                    ['warehouse_id', $returnPurchase->warehouse_id]
                ])->first();

                if ($productWarehouse) {
                    $productWarehouse->qty += $oldQty;
                    $productWarehouse->save();
                }
            }

            if ($oldItem->variant_id) {
                $productVariant = ProductVariant::where([
                    ['product_id', $oldItem->product_id],
                    ['variant_id', $oldItem->variant_id]
                ])->first();
                if ($productVariant) {
                    $productVariant->qty += $oldQty;
                    $productVariant->save();
                }
            }

            if ($oldItem->product_batch_id) {
                $batch = ProductBatch::find($oldItem->product_batch_id);
                if ($batch) {
                    $batch->qty += $oldQty;
                    $batch->save();
                }
            }

            $oldItem->delete();
        }

        // Adjust old account balance
        $oldAccount = Account::find($returnPurchase->account_id);
        if ($oldAccount) {
            $oldAccount->total_balance -= $returnPurchase->grand_total;
            $oldAccount->save();
        }

        $returnPurchase->update($data);

        // Adjust new account balance
        $newAccount = Account::find($data['account_id']);
        if ($newAccount) {
            $newAccount->total_balance += $data['grand_total'];
            $newAccount->save();
        }

        // Insert new returned quantities
        $productIds = $data['product_id'] ?? [];
        $imeiNumbers = $data['imei_number'] ?? [];
        $productCodes = $data['product_code'] ?? [];
        $qtys = $data['qty'] ?? [];
        $purchaseUnitIds = $data['purchase_unit_id'] ?? [];
        $netUnitCosts = $data['net_unit_cost'] ?? [];
        $discounts = $data['discount'] ?? [];
        $taxRates = $data['tax_rate'] ?? [];
        $taxes = $data['tax'] ?? [];
        $totals = $data['subtotal'] ?? [];
        $batchNos = $data['batch_no'] ?? [];

        foreach ($productIds as $i => $id) {
            $purchaseUnit = Unit::find($purchaseUnitIds[$i] ?? 0);
            $qty = $qtys[$i] ?? 0;

            if ($purchaseUnit) {
                if ($purchaseUnit->operator == '*') {
                    $quantity = $qty * $purchaseUnit->operation_value;
                } else {
                    $quantity = $qty / $purchaseUnit->operation_value;
                }
            } else {
                $quantity = $qty;
            }

            $product = Product::find($id);
            if (!$product) {
                continue;
            }

            $productBatchId = null;
            if ($product->is_batch && !empty($batchNos[$i])) {
                $productBatch = ProductBatch::where([
                    ['product_id', $id],
                    ['batch_no', $batchNos[$i]]
                ])->first();
                if ($productBatch) {
                    $productBatch->qty -= $quantity;
                    $productBatch->save();
                    $productBatchId = $productBatch->id;
                }
            }

            $productVariantId = null;
            if ($product->is_variant) {
                $productVariant = ProductVariant::where([
                    ['product_id', $id],
                    ['item_code', $productCodes[$i]]
                ])->first();
                if ($productVariant) {
                    $productVariant->qty -= $quantity;
                    $productVariant->save();
                    $productVariantId = $productVariant->variant_id;
                }
            }

            $product->qty -= $quantity;
            $product->save();

            $productWarehouse = Product_Warehouse::where([
                ['product_id', $id],
                ['warehouse_id', $data['warehouse_id']]
            ])->first();

            if ($productWarehouse) {
                $productWarehouse->qty -= $quantity;
                $productWarehouse->save();
            }

            PurchaseProductReturn::create([
                'return_id'        => $returnPurchase->id,
                'product_id'       => $id,
                'product_batch_id' => $productBatchId,
                'variant_id'       => $productVariantId,
                'imei_number'      => $imeiNumbers[$i] ?? null,
                'qty'              => $qty,
                'purchase_unit_id' => $purchaseUnitIds[$i] ?? null,
                'net_unit_cost'    => $netUnitCosts[$i] ?? 0,
                'discount'         => $discounts[$i] ?? 0,
                'tax_rate'         => $taxRates[$i] ?? 0,
                'tax'              => $taxes[$i] ?? 0,
                'total'            => $totals[$i] ?? 0,
            ]);
        }

        return $returnPurchase;
    }

    /**
     * Delete a return purchase and revert stock.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteReturnPurchase($id): bool
    {
        $returnPurchase = ReturnPurchase::findOrFail($id);
        $productReturns = PurchaseProductReturn::where('return_id', $id)->get();

        foreach ($productReturns as $item) {
            $purchaseUnit = Unit::find($item->purchase_unit_id);
            if ($purchaseUnit) {
                if ($purchaseUnit->operator == '*') {
                    $quantity = $item->qty * $purchaseUnit->operation_value;
                } else {
                    $quantity = $item->qty / $purchaseUnit->operation_value;
                }
            } else {
                $quantity = $item->qty;
            }

            $product = Product::find($item->product_id);
            if ($product) {
                $product->qty += $quantity;
                $product->save();

                $productWarehouse = Product_Warehouse::where([
                    ['product_id', $item->product_id],
                    ['warehouse_id', $returnPurchase->warehouse_id]
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

        $account = Account::find($returnPurchase->account_id);
        if ($account) {
            $account->total_balance -= $returnPurchase->grand_total;
            $account->save();
        }

        if ($returnPurchase->document) {
            @unlink(public_path('documents/purchase_return/' . $returnPurchase->document));
        }

        return $returnPurchase->delete();
    }

    /**
     * Delete multiple purchase returns.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleReturnPurchases(array $ids): bool
    {
        foreach ($ids as $id) {
            $this->deleteReturnPurchase($id);
        }
        return true;
    }
}
