<?php

namespace App\Services;

use App\Enums\TransferStatus;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductTransfer;
use App\Models\ProductVariant;
use App\Models\Product_Warehouse;
use App\Models\Tax;
use App\Models\Transfer;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Repositories\Contracts\TransferRepositoryInterface;
use App\Repositories\Contracts\WarehouseRepositoryInterface;
use App\Repositories\Contracts\TaxRepositoryInterface;
use App\Repositories\Contracts\UnitRepositoryInterface;
use App\Traits\TenantInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferService
{
    use TenantInfo;

    protected TransferRepositoryInterface $transferRepository;
    protected WarehouseRepositoryInterface $warehouseRepository;
    protected TaxRepositoryInterface $taxRepository;
    protected UnitRepositoryInterface $unitRepository;

    /**
     * TransferService constructor.
     *
     * @param TransferRepositoryInterface $transferRepository
     * @param WarehouseRepositoryInterface $warehouseRepository
     * @param TaxRepositoryInterface $taxRepository
     * @param UnitRepositoryInterface $unitRepository
     */
    public function __construct(
        TransferRepositoryInterface $transferRepository,
        WarehouseRepositoryInterface $warehouseRepository,
        TaxRepositoryInterface $taxRepository,
        UnitRepositoryInterface $unitRepository
    ) {
        $this->transferRepository = $transferRepository;
        $this->warehouseRepository = $warehouseRepository;
        $this->taxRepository = $taxRepository;
        $this->unitRepository = $unitRepository;
    }

    /**
     * Process DataTables server-side response for transfer list.
     *
     * @param Request $request
     * @param array $allPermissions
     * @return array
     */
    public function getTransferDataTable(Request $request, array $allPermissions): array
    {
        $columns = [
            1 => 'created_at',
            2 => 'reference_no',
        ];

        $filters = [
            'starting_date'     => $request->input('starting_date'),
            'ending_date'       => $request->input('ending_date'),
            'from_warehouse_id' => $request->input('from_warehouse_id'),
            'to_warehouse_id'   => $request->input('to_warehouse_id'),
        ];

        $totalData = $this->transferRepository->countTotalTransfers($filters);
        $limit = ($request->input('length') != -1) ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $orderColumn = $request->input('order.0.column');
        $order = 'transfers.' . ($columns[$orderColumn] ?? 'created_at');
        $dir = $request->input('order.0.dir') ?? 'desc';
        $searchValue = $request->input('search.value');

        $transfers = $this->transferRepository->getFilteredTransfersForDataTable($start, $limit, $order, $dir, $filters, $searchValue);
        $totalFiltered = $this->transferRepository->countFilteredTransfersForDataTable($filters, $searchValue);

        $data = [];
        $dateFormat = config('date_format') ?: 'd-m-Y';

        foreach ($transfers as $key => $transfer) {
            $nestedData = [];
            $nestedData['id'] = $transfer->id;
            $nestedData['key'] = $key;
            $nestedData['date'] = date($dateFormat, strtotime($transfer->created_at));
            $nestedData['reference_no'] = $transfer->reference_no;
            $nestedData['from_warehouse'] = $transfer->fromWarehouse ? $transfer->fromWarehouse->name : 'N/A';
            $nestedData['to_warehouse'] = $transfer->toWarehouse ? $transfer->toWarehouse->name : 'N/A';
            $nestedData['total_qty'] = $transfer->total_qty;
            $nestedData['total_cost'] = number_format($transfer->total_cost, (int) (config('decimal') ?: 2));
            $nestedData['total_tax'] = number_format($transfer->total_tax, (int) (config('decimal') ?: 2));
            $nestedData['grand_total'] = number_format($transfer->grand_total, (int) (config('decimal') ?: 2));

            $nestedData['status'] = TransferStatus::tryFrom((int) $transfer->status)?->badge() ?? '';

            $options = '<div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . trans("file.action") . '
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                            <li>
                                <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i> ' . trans('file.View') . '</button>
                            </li>';

            if (in_array("transfers-edit", $allPermissions)) {
                $options .= '<li>
                    <a href="' . route('transfers.edit', $transfer->id) . '" class="btn btn-link"><i class="dripicons-document-edit"></i> ' . trans('file.edit') . '</a>
                    </li>';
            }
            if (in_array("transfers-delete", $allPermissions)) {
                $options .= \Form::open(["route" => ["transfers.destroy", $transfer->id], "method" => "DELETE"]) . '
                        <li>
                          <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> ' . trans("file.delete") . '</button>
                        </li>' . \Form::close();
            }

            $options .= '</ul></div>';
            $nestedData['options'] = $options;

            $nestedData['transfer'] = [
                '[ "' . date($dateFormat, strtotime($transfer->created_at)) . '"',
                ' "' . $transfer->reference_no . '"',
                ' "' . $transfer->status . '"',
                ' "' . $transfer->id . '"',
                ' "' . ($transfer->fromWarehouse ? $transfer->fromWarehouse->name : 'N/A') . '"',
                ' "' . ($transfer->fromWarehouse ? $transfer->fromWarehouse->phone : 'N/A') . '"',
                ' "' . preg_replace('/\s+/S', " ", (string) ($transfer->fromWarehouse ? $transfer->fromWarehouse->address : 'N/A')) . '"',
                ' "' . ($transfer->toWarehouse ? $transfer->toWarehouse->name : 'N/A') . '"',
                ' "' . ($transfer->toWarehouse ? $transfer->toWarehouse->phone : 'N/A') . '"',
                ' "' . preg_replace('/\s+/S', " ", (string) ($transfer->toWarehouse ? $transfer->toWarehouse->address : 'N/A')) . '"',
                ' "' . $transfer->total_tax . '"',
                ' "' . $transfer->total_cost . '"',
                ' "' . $transfer->shipping_cost . '"',
                ' "' . $transfer->grand_total . '"',
                ' "' . preg_replace('/[\n\r]/', "<br>", (string) $transfer->note) . '"',
                ' "' . ($transfer->user ? $transfer->user->name : 'N/A') . '"',
                ' "' . ($transfer->user ? $transfer->user->email : 'N/A') . '"',
                ' "' . $transfer->document . '" ]'
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
     * Get data required for create transfer form.
     *
     * @return array
     */
    public function getCreateFormData(): array
    {
        $lims_warehouse_list = $this->warehouseRepository->getActiveWarehouses();
        return compact('lims_warehouse_list');
    }

    /**
     * Create a new stock transfer transaction.
     *
     * @param array $requestData
     * @param UploadedFile|null $document
     * @return Transfer
     */
    public function createTransfer(array $requestData, ?UploadedFile $document): Transfer
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
                $document->move(public_path('documents/transfer'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move(public_path('documents/transfer'), $documentName);
            }
            $data['document'] = $documentName;
        }

        if (!isset($data['item'])) {
            $data['item'] = isset($data['product_id']) ? count($data['product_id']) : 0;
        }

        if (!isset($data['reference_no'])) {
            $data['reference_no'] = 'tr-' . date("Ymd") . '-' . date("his");
        }

        return DB::transaction(function () use ($data) {
            $transfer = $this->transferRepository->create($data);

            $productIds = $data['product_id'] ?? [];
            $productCodes = $data['product_code'] ?? [];
            $qtys = $data['qty'] ?? [];
            $purchaseUnitIds = $data['purchase_unit_id'] ?? [];
            $netUnitCosts = $data['net_unit_cost'] ?? [];
            $taxRates = $data['tax_rate'] ?? [];
            $taxes = $data['tax'] ?? [];
            $subtotals = $data['subtotal'] ?? [];
            $batchNos = $data['batch_no'] ?? [];

            foreach ($productIds as $i => $id) {
                $purchaseUnit = null;
                if (!empty($purchaseUnitIds[$i])) {
                    $purchaseUnit = Unit::find($purchaseUnitIds[$i]);
                } elseif (!empty($data['purchase_unit'][$i])) {
                    $purchaseUnit = Unit::where('unit_name', $data['purchase_unit'][$i])->first();
                }

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
                        $productVariantId = $productVariant->variant_id;
                    }
                }

                if ($data['status'] == 1) {
                    // Completed: deduct from from_warehouse, add to to_warehouse
                    $fromWarehouse = $this->findProductWarehouse($id, $data['from_warehouse_id'], $productVariantId, $productBatchId);

                    if ($fromWarehouse) {
                        $fromWarehouse->qty -= $quantity;
                        $fromWarehouse->save();
                    }

                    $toWarehouse = $this->findProductWarehouse($id, $data['to_warehouse_id'], $productVariantId, $productBatchId);

                    if ($toWarehouse) {
                        $toWarehouse->qty += $quantity;
                        $toWarehouse->save();
                    } else {
                        Product_Warehouse::create([
                            'product_id'       => $id,
                            'warehouse_id'     => $data['to_warehouse_id'],
                            'qty'              => $quantity,
                            'product_batch_id' => $productBatchId,
                            'variant_id'       => $productVariantId,
                        ]);
                    }
                } elseif ($data['status'] == 3) {
                    // Sent: deduct from from_warehouse only
                    $fromWarehouse = $this->findProductWarehouse($id, $data['from_warehouse_id'], $productVariantId, $productBatchId);

                    if ($fromWarehouse) {
                        $fromWarehouse->qty -= $quantity;
                        $fromWarehouse->save();
                    }
                }

                ProductTransfer::create([
                    'transfer_id'      => $transfer->id,
                    'product_id'       => $id,
                    'product_batch_id' => $productBatchId,
                    'variant_id'       => $productVariantId,
                    'imei_number'      => $data['imei_number'][$i] ?? null,
                    'qty'              => $qty,
                    'purchase_unit_id' => $purchaseUnit ? $purchaseUnit->id : ($purchaseUnitIds[$i] ?? null),
                    'net_unit_cost'    => $netUnitCosts[$i] ?? 0,
                    'tax_rate'         => $taxRates[$i] ?? 0,
                    'tax'              => $taxes[$i] ?? 0,
                    'total'            => $subtotals[$i] ?? ($data['total'][$i] ?? 0),
                ]);
            }

            return $transfer;
        });
    }

    /**
     * Get data required for edit transfer form.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $lims_warehouse_list = $this->warehouseRepository->getActiveWarehouses();
        $lims_transfer_data = $this->transferRepository->find($id);
        $lims_product_transfer_data = ProductTransfer::with(['product.productVariants', 'unit', 'variant', 'productBatch'])->where('transfer_id', $id)->get();
        $all_units = $this->unitRepository->getActiveUnits();
        $all_taxes = $this->taxRepository->getActiveTaxes();
        $product_ids = $lims_product_transfer_data->pluck('product_id')->unique()->toArray();
        $product_warehouses = Product_Warehouse::where('warehouse_id', $lims_transfer_data->from_warehouse_id)
            ->whereIn('product_id', $product_ids)
            ->get();

        return compact('lims_warehouse_list', 'lims_transfer_data', 'lims_product_transfer_data', 'all_units', 'all_taxes', 'product_warehouses');
    }

    /**
     * Update an existing stock transfer.
     *
     * @param int|string $id
     * @param array $requestData
     * @param UploadedFile|null $document
     * @return Transfer
     */
    public function updateTransfer($id, array $requestData, ?UploadedFile $document): Transfer
    {
        $transfer = $this->transferRepository->findOrFail($id);
        $data = $requestData;

        if (isset($data['created_at'])) {
            $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
        }

        if ($document) {
            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $document->move(public_path('documents/transfer'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move(public_path('documents/transfer'), $documentName);
            }
            $data['document'] = $documentName;
        }

        if (!isset($data['item']) && isset($data['product_id'])) {
            $data['item'] = count($data['product_id']);
        }

        return DB::transaction(function () use ($id, $transfer, $data) {
            // Revert previous transfer quantities
            $oldTransfers = ProductTransfer::where('transfer_id', $id)->get();
            foreach ($oldTransfers as $oldItem) {
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

                if ($transfer->status == 1) {
                    $fromWarehouse = $this->findProductWarehouse($oldItem->product_id, $transfer->from_warehouse_id, $oldItem->variant_id, $oldItem->product_batch_id);
                    if ($fromWarehouse) {
                        $fromWarehouse->qty += $oldQty;
                        $fromWarehouse->save();
                    }

                    $toWarehouse = $this->findProductWarehouse($oldItem->product_id, $transfer->to_warehouse_id, $oldItem->variant_id, $oldItem->product_batch_id);
                    if ($toWarehouse) {
                        $toWarehouse->qty -= $oldQty;
                        $toWarehouse->save();
                    }
                } elseif ($transfer->status == 3) {
                    $fromWarehouse = $this->findProductWarehouse($oldItem->product_id, $transfer->from_warehouse_id, $oldItem->variant_id, $oldItem->product_batch_id);
                    if ($fromWarehouse) {
                        $fromWarehouse->qty += $oldQty;
                        $fromWarehouse->save();
                    }
                }

                $oldItem->delete();
            }

            $transfer->update($data);

            // Apply new transfer quantities
            $productIds = $data['product_id'] ?? [];
            $productCodes = $data['product_code'] ?? [];
            $qtys = $data['qty'] ?? [];
            $purchaseUnitIds = $data['purchase_unit_id'] ?? [];
            $netUnitCosts = $data['net_unit_cost'] ?? [];
            $taxRates = $data['tax_rate'] ?? [];
            $taxes = $data['tax'] ?? [];
            $subtotals = $data['subtotal'] ?? [];
            $batchNos = $data['batch_no'] ?? [];

            foreach ($productIds as $i => $id) {
                $purchaseUnit = null;
                if (!empty($purchaseUnitIds[$i])) {
                    $purchaseUnit = Unit::find($purchaseUnitIds[$i]);
                } elseif (!empty($data['purchase_unit'][$i])) {
                    $purchaseUnit = Unit::where('unit_name', $data['purchase_unit'][$i])->first();
                }

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
                        $productVariantId = $productVariant->variant_id;
                    }
                }

                if ($data['status'] == 1) {
                    $fromWarehouse = $this->findProductWarehouse($id, $data['from_warehouse_id'], $productVariantId, $productBatchId);
                    if ($fromWarehouse) {
                        $fromWarehouse->qty -= $quantity;
                        $fromWarehouse->save();
                    }

                    $toWarehouse = $this->findProductWarehouse($id, $data['to_warehouse_id'], $productVariantId, $productBatchId);
                    if ($toWarehouse) {
                        $toWarehouse->qty += $quantity;
                        $toWarehouse->save();
                    } else {
                        Product_Warehouse::create([
                            'product_id'       => $id,
                            'warehouse_id'     => $data['to_warehouse_id'],
                            'qty'              => $quantity,
                            'product_batch_id' => $productBatchId,
                            'variant_id'       => $productVariantId,
                        ]);
                    }
                } elseif ($data['status'] == 3) {
                    $fromWarehouse = $this->findProductWarehouse($id, $data['from_warehouse_id'], $productVariantId, $productBatchId);
                    if ($fromWarehouse) {
                        $fromWarehouse->qty -= $quantity;
                        $fromWarehouse->save();
                    }
                }

                ProductTransfer::create([
                    'transfer_id'      => $transfer->id,
                    'product_id'       => $id,
                    'product_batch_id' => $productBatchId,
                    'variant_id'       => $productVariantId,
                    'imei_number'      => $data['imei_number'][$i] ?? null,
                    'qty'              => $qty,
                    'purchase_unit_id' => $purchaseUnit ? $purchaseUnit->id : ($purchaseUnitIds[$i] ?? null),
                    'net_unit_cost'    => $netUnitCosts[$i] ?? 0,
                    'tax_rate'         => $taxRates[$i] ?? 0,
                    'tax'              => $taxes[$i] ?? 0,
                    'total'            => $subtotals[$i] ?? ($data['total'][$i] ?? 0),
                ]);
            }

            return $transfer;
        });
    }

    /**
     * Delete a transfer and revert quantities.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteTransfer($id): bool
    {
        return DB::transaction(function () use ($id) {
            $transfer = Transfer::findOrFail($id);
            $productTransfers = ProductTransfer::where('transfer_id', $id)->get();

            foreach ($productTransfers as $item) {
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

                if ($transfer->status == 1) {
                    $fromWarehouse = $this->findProductWarehouse($item->product_id, $transfer->from_warehouse_id, $item->variant_id, $item->product_batch_id);
                    if ($fromWarehouse) {
                        $fromWarehouse->qty += $quantity;
                        $fromWarehouse->save();
                    }

                    $toWarehouse = $this->findProductWarehouse($item->product_id, $transfer->to_warehouse_id, $item->variant_id, $item->product_batch_id);
                    if ($toWarehouse) {
                        $toWarehouse->qty -= $quantity;
                        $toWarehouse->save();
                    }
                } elseif ($transfer->status == 3) {
                    $fromWarehouse = $this->findProductWarehouse($item->product_id, $transfer->from_warehouse_id, $item->variant_id, $item->product_batch_id);
                    if ($fromWarehouse) {
                        $fromWarehouse->qty += $quantity;
                        $fromWarehouse->save();
                    }
                }

                $item->delete();
            }

            if ($transfer->document) {
                @unlink(public_path('documents/transfer/' . $transfer->document));
            }

            return (bool) $transfer->delete();
        });
    }

    /**
     * Helper to find Product_Warehouse matching variant and batch accurately.
     */
    protected function findProductWarehouse($productId, $warehouseId, $variantId = null, $batchId = null)
    {
        return Product_Warehouse::where([
            ['product_id', $productId],
            ['warehouse_id', $warehouseId]
        ])
        ->when($variantId, fn($q) => $q->where('variant_id', $variantId), fn($q) => $q->whereNull('variant_id'))
        ->when($batchId, fn($q) => $q->where('product_batch_id', $batchId), fn($q) => $q->whereNull('product_batch_id'))
        ->first();
    }

    /**
     * Delete multiple transfers.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleTransfers(array $ids): bool
    {
        return DB::transaction(function () use ($ids) {
            foreach ($ids as $id) {
                $this->deleteTransfer($id);
            }
            return true;
        });
    }
}
