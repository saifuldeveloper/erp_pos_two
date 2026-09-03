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

    /**
     * TransferService constructor.
     *
     * @param TransferRepositoryInterface $transferRepository
     */
    public function __construct(TransferRepositoryInterface $transferRepository)
    {
        $this->transferRepository = $transferRepository;
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
                ' "' . ($transfer->fromWarehouse ? $transfer->fromWarehouse->name : 'N/A') . '"',
                ' "' . ($transfer->fromWarehouse ? $transfer->fromWarehouse->phone : 'N/A') . '"',
                ' "' . ($transfer->fromWarehouse ? $transfer->fromWarehouse->address : 'N/A') . '"',
                ' "' . ($transfer->toWarehouse ? $transfer->toWarehouse->name : 'N/A') . '"',
                ' "' . ($transfer->toWarehouse ? $transfer->toWarehouse->phone : 'N/A') . '"',
                ' "' . ($transfer->toWarehouse ? $transfer->toWarehouse->address : 'N/A') . '"',
                ' "' . $transfer->id . '"',
                ' "' . $transfer->total_tax . '"',
                ' "' . $transfer->total_cost . '"',
                ' "' . $transfer->shipping_cost . '"',
                ' "' . $transfer->grand_total . '"',
                ' "' . preg_replace('/\s+/S', " ", (string) $transfer->note) . '"',
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
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
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

        if (!isset($data['reference_no'])) {
            $data['reference_no'] = 'tr-' . date("Ymd") . '-' . date("his");
        }

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
                $fromWarehouse = Product_Warehouse::where([
                    ['product_id', $id],
                    ['warehouse_id', $data['from_warehouse_id']]
                ])->first();

                if ($fromWarehouse) {
                    $fromWarehouse->qty -= $quantity;
                    $fromWarehouse->save();
                }

                $toWarehouse = Product_Warehouse::where([
                    ['product_id', $id],
                    ['warehouse_id', $data['to_warehouse_id']]
                ])->first();

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
                $fromWarehouse = Product_Warehouse::where([
                    ['product_id', $id],
                    ['warehouse_id', $data['from_warehouse_id']]
                ])->first();

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
                'qty'              => $qty,
                'purchase_unit_id' => $purchaseUnitIds[$i] ?? null,
                'net_unit_cost'    => $netUnitCosts[$i] ?? 0,
                'tax_rate'         => $taxRates[$i] ?? 0,
                'tax'              => $taxes[$i] ?? 0,
                'subtotal'         => $subtotals[$i] ?? 0,
            ]);
        }

        return $transfer;
    }

    /**
     * Get data required for edit transfer form.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_transfer_data = Transfer::find($id);
        $lims_product_transfer_data = ProductTransfer::where('transfer_id', $id)->get();

        return compact('lims_warehouse_list', 'lims_transfer_data', 'lims_product_transfer_data');
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
                $fromWarehouse = Product_Warehouse::where([
                    ['product_id', $oldItem->product_id],
                    ['warehouse_id', $transfer->from_warehouse_id]
                ])->first();
                if ($fromWarehouse) {
                    $fromWarehouse->qty += $oldQty;
                    $fromWarehouse->save();
                }

                $toWarehouse = Product_Warehouse::where([
                    ['product_id', $oldItem->product_id],
                    ['warehouse_id', $transfer->to_warehouse_id]
                ])->first();
                if ($toWarehouse) {
                    $toWarehouse->qty -= $oldQty;
                    $toWarehouse->save();
                }
            } elseif ($transfer->status == 3) {
                $fromWarehouse = Product_Warehouse::where([
                    ['product_id', $oldItem->product_id],
                    ['warehouse_id', $transfer->from_warehouse_id]
                ])->first();
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
                $fromWarehouse = Product_Warehouse::where([
                    ['product_id', $id],
                    ['warehouse_id', $data['from_warehouse_id']]
                ])->first();
                if ($fromWarehouse) {
                    $fromWarehouse->qty -= $quantity;
                    $fromWarehouse->save();
                }

                $toWarehouse = Product_Warehouse::where([
                    ['product_id', $id],
                    ['warehouse_id', $data['to_warehouse_id']]
                ])->first();
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
                $fromWarehouse = Product_Warehouse::where([
                    ['product_id', $id],
                    ['warehouse_id', $data['from_warehouse_id']]
                ])->first();
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
                'qty'              => $qty,
                'purchase_unit_id' => $purchaseUnitIds[$i] ?? null,
                'net_unit_cost'    => $netUnitCosts[$i] ?? 0,
                'tax_rate'         => $taxRates[$i] ?? 0,
                'tax'              => $taxes[$i] ?? 0,
                'subtotal'         => $subtotals[$i] ?? 0,
            ]);
        }

        return $transfer;
    }

    /**
     * Delete a transfer and revert quantities.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteTransfer($id): bool
    {
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
                $fromWarehouse = Product_Warehouse::where([
                    ['product_id', $item->product_id],
                    ['warehouse_id', $transfer->from_warehouse_id]
                ])->first();
                if ($fromWarehouse) {
                    $fromWarehouse->qty += $quantity;
                    $fromWarehouse->save();
                }

                $toWarehouse = Product_Warehouse::where([
                    ['product_id', $item->product_id],
                    ['warehouse_id', $transfer->to_warehouse_id]
                ])->first();
                if ($toWarehouse) {
                    $toWarehouse->qty -= $quantity;
                    $toWarehouse->save();
                }
            } elseif ($transfer->status == 3) {
                $fromWarehouse = Product_Warehouse::where([
                    ['product_id', $item->product_id],
                    ['warehouse_id', $transfer->from_warehouse_id]
                ])->first();
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

        return $transfer->delete();
    }

    /**
     * Delete multiple transfers.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleTransfers(array $ids): bool
    {
        foreach ($ids as $id) {
            $this->deleteTransfer($id);
        }
        return true;
    }
}
