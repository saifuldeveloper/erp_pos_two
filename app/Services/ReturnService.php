<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Biller;
use App\Models\CashRegister;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductReturn;
use App\Models\ProductVariant;
use App\Models\Product_Warehouse;
use App\Models\Returns;
use App\Models\RewardPointSetting;
use App\Models\Sale;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Repositories\Contracts\ReturnRepositoryInterface;
use App\Traits\TenantInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturnService
{
    use TenantInfo;

    protected ReturnRepositoryInterface $returnRepository;

    /**
     * ReturnService constructor.
     *
     * @param ReturnRepositoryInterface $returnRepository
     */
    public function __construct(ReturnRepositoryInterface $returnRepository)
    {
        $this->returnRepository = $returnRepository;
    }

    /**
     * Process DataTables server-side response for sale return list.
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

        $totalData = $this->returnRepository->countTotalReturns($warehouseId, $startDate, $endDate);
        $limit = ($request->input('length') != -1) ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $orderColumn = $request->input('order.0.column');
        $order = 'returns.' . ($columns[$orderColumn] ?? 'created_at');
        $dir = $request->input('order.0.dir') ?? 'desc';

        $returns = $this->returnRepository->getFilteredReturnsForDataTable($start, $limit, $order, $dir, $warehouseId, $startDate, $endDate, $searchValue);
        $totalFiltered = $this->returnRepository->countFilteredReturnsForDataTable($warehouseId, $startDate, $endDate, $searchValue);

        $returnIds = $returns->pluck('id')->toArray();
        $saleIds = $returns->pluck('sale_id')->filter()->unique()->toArray();
        $sales = Sale::whereIn('id', $saleIds)->pluck('reference_no', 'id');

        $purchaseTotals = DB::table('product_returns as pr')
            ->leftJoin(
                DB::raw('(SELECT product_id, variant_id, AVG(net_unit_cost) as net_unit_cost FROM product_purchases GROUP BY product_id, variant_id) as pp'),
                function ($join) {
                    $join->on('pr.product_id', '=', 'pp.product_id')
                        ->on(function ($q) {
                            $q->on('pr.variant_id', '=', 'pp.variant_id')
                                ->orWhere(function ($q) {
                                    $q->whereNull('pr.variant_id')
                                        ->whereNull('pp.variant_id');
                                });
                        });
                }
            )
            ->whereIn('pr.return_id', $returnIds)
            ->selectRaw('pr.return_id, SUM(pr.qty * COALESCE(pp.net_unit_cost, 0)) as total')
            ->groupBy('pr.return_id')
            ->pluck('total', 'pr.return_id');

        $returnQties = DB::table('product_returns')
            ->whereIn('return_id', $returnIds)
            ->groupBy('return_id')
            ->pluck(DB::raw('SUM(qty)'), 'return_id');

        $decimal = (int) (config('decimal') ?: 2);
        $data = [];
        $dateFormat = config('date_format') ?: 'd-m-Y';

        foreach ($returns as $key => $return) {
            $purchaseTotal = $purchaseTotals[$return->id] ?? 0;
            $qty = $returnQties[$return->id] ?? 0;
            $saleReference = $return->sale_id ? ($sales[$return->sale_id] ?? 'N/A') : 'N/A';

            $nestedData = [];
            $nestedData['id'] = $return->id;
            $nestedData['key'] = $key;
            $nestedData['date'] = date($dateFormat, strtotime($return->created_at));
            $nestedData['reference_no'] = $return->reference_no;
            $nestedData['sale_reference'] = $saleReference;
            $nestedData['warehouse'] = $return->warehouse ? $return->warehouse->name : 'N/A';
            $nestedData['biller'] = $return->biller ? ($return->biller->name . ' (' . $return->biller->company_name . ')') : 'N/A';
            $nestedData['customer'] = $return->customer ? ($return->customer->name . ' (' . $return->customer->phone_number . ')') : 'N/A';
            $nestedData['qty'] = number_format((float) $qty, $decimal);
            $nestedData['purchase_total'] = number_format((float) $purchaseTotal, $decimal);
            $nestedData['grand_total'] = number_format((float) $return->grand_total, $decimal);

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
                    <a href="' . route('return-sale.edit', $return->id) . '" class="btn btn-link"><i class="dripicons-document-edit"></i> ' . trans('file.edit') . '</a>
                    </li>';
            }
            if (in_array("returns-delete", $allPermissions)) {
                $options .= \Form::open(["route" => ["return-sale.destroy", $return->id], "method" => "DELETE"]) . '
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
                ' "' . ($return->biller ? $return->biller->name : 'N/A') . '"',
                ' "' . ($return->biller ? $return->biller->company_name : 'N/A') . '"',
                ' "' . ($return->biller ? $return->biller->email : 'N/A') . '"',
                ' "' . ($return->biller ? $return->biller->phone_number : 'N/A') . '"',
                ' "' . ($return->biller ? $return->biller->address : 'N/A') . '"',
                ' "' . ($return->biller ? $return->biller->city : 'N/A') . '"',
                ' "' . ($return->customer ? $return->customer->name : 'N/A') . '"',
                ' "' . ($return->customer ? $return->customer->phone_number : 'N/A') . '"',
                ' "' . ($return->customer ? $return->customer->address : 'N/A') . '"',
                ' "' . ($return->customer ? $return->customer->city : 'N/A') . '"',
                ' "' . $return->id . '"',
                ' "' . $return->total_tax . '"',
                ' "' . $return->total_discount . '"',
                ' "' . $return->total_price . '"',
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
     * Get data required for create return form.
     *
     * @return array
     */
    public function getCreateFormData(): array
    {
        $lims_customer_list = Customer::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_biller_list = Biller::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_account_list = Account::where('is_active', true)->get();

        return compact(
            'lims_customer_list',
            'lims_warehouse_list',
            'lims_biller_list',
            'lims_tax_list',
            'lims_account_list'
        );
    }

    /**
     * Create a new sale return transaction.
     *
     * @param array $requestData
     * @param UploadedFile|null $document
     * @return Returns
     */
    public function createReturn(array $requestData, ?UploadedFile $document): Returns
    {
        $data = $requestData;
        $data['user_id'] = Auth::id();

        $cashRegister = CashRegister::where([
            ['user_id', $data['user_id']],
            ['warehouse_id', $data['warehouse_id']],
            ['status', true]
        ])->first();

        if ($cashRegister) {
            $data['cash_register_id'] = $cashRegister->id;
        }

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
                $document->move(public_path('documents/sale_return'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move(public_path('documents/sale_return'), $documentName);
            }
            $data['document'] = $documentName;
        }

        if (!isset($data['reference_no'])) {
            $data['reference_no'] = 'rr-' . date("Ymd") . '-' . date("his");
        }

        $return = $this->returnRepository->create($data);

        $account = Account::find($data['account_id']);
        if ($account) {
            $account->total_balance -= $data['grand_total'];
            $account->save();
        }

        $customer = Customer::find($data['customer_id']);
        $rewardSetting = RewardPointSetting::latest()->first();
        if ($rewardSetting && $rewardSetting->is_active && $customer && $data['grand_total'] >= $rewardSetting->minimum_amount) {
            $point = (int) ($data['grand_total'] / $rewardSetting->per_point_amount);
            $customer->points -= $point;
            $customer->save();
        }

        $productIds = $data['product_id'] ?? [];
        $imeiNumbers = $data['imei_number'] ?? [];
        $productCodes = $data['product_code'] ?? [];
        $qtys = $data['qty'] ?? [];
        $saleUnitIds = $data['sale_unit_id'] ?? [];
        $netUnitPrices = $data['net_unit_price'] ?? [];
        $discounts = $data['discount'] ?? [];
        $taxRates = $data['tax_rate'] ?? [];
        $taxes = $data['tax'] ?? [];
        $totals = $data['subtotal'] ?? [];
        $batchNos = $data['batch_no'] ?? [];

        foreach ($productIds as $i => $id) {
            $saleUnit = Unit::find($saleUnitIds[$i] ?? 0);
            $qty = $qtys[$i] ?? 0;

            if ($saleUnit) {
                if ($saleUnit->operator == '*') {
                    $quantity = $qty * $saleUnit->operation_value;
                } elseif ($saleUnit->operator == '/') {
                    $quantity = $qty / $saleUnit->operation_value;
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
                    $productBatch->qty += $quantity;
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
                    $productVariant->qty += $quantity;
                    $productVariant->save();
                    $productVariantId = $productVariant->variant_id;
                }
            }

            $product->qty += $quantity;
            $product->save();

            $productWarehouse = Product_Warehouse::where([
                ['product_id', $id],
                ['warehouse_id', $data['warehouse_id']]
            ])->first();

            if ($productWarehouse) {
                $productWarehouse->qty += $quantity;
                $productWarehouse->save();
            } else {
                Product_Warehouse::create([
                    'product_id'   => $id,
                    'warehouse_id' => $data['warehouse_id'],
                    'qty'          => $quantity,
                ]);
            }

            ProductReturn::create([
                'return_id'        => $return->id,
                'product_id'       => $id,
                'product_batch_id' => $productBatchId,
                'variant_id'       => $productVariantId,
                'imei_number'      => $imeiNumbers[$i] ?? null,
                'qty'              => $qty,
                'sale_unit_id'     => $saleUnitIds[$i] ?? null,
                'net_unit_price'   => $netUnitPrices[$i] ?? 0,
                'discount'         => $discounts[$i] ?? 0,
                'tax_rate'         => $taxRates[$i] ?? 0,
                'tax'              => $taxes[$i] ?? 0,
                'total'            => $totals[$i] ?? 0,
            ]);
        }

        return $return;
    }

    /**
     * Get data required for edit return form.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $lims_customer_list = Customer::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_biller_list = Biller::where('is_active', true)->get();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_account_list = Account::where('is_active', true)->get();
        $lims_return_data = Returns::find($id);
        $lims_product_return_data = ProductReturn::where('return_id', $id)->get();

        return compact(
            'lims_customer_list',
            'lims_warehouse_list',
            'lims_biller_list',
            'lims_tax_list',
            'lims_account_list',
            'lims_return_data',
            'lims_product_return_data'
        );
    }

    /**
     * Update an existing sale return transaction.
     *
     * @param int|string $id
     * @param array $requestData
     * @param UploadedFile|null $document
     * @return Returns
     */
    public function updateReturn($id, array $requestData, ?UploadedFile $document): Returns
    {
        $return = $this->returnRepository->findOrFail($id);
        $data = $requestData;

        if (isset($data['created_at'])) {
            $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
        }

        if ($document) {
            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $document->move(public_path('documents/sale_return'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move(public_path('documents/sale_return'), $documentName);
            }
            $data['document'] = $documentName;
        }

        // Reverse previous returned quantities from stock
        $oldReturns = ProductReturn::where('return_id', $id)->get();
        foreach ($oldReturns as $oldItem) {
            $saleUnit = Unit::find($oldItem->sale_unit_id);
            if ($saleUnit) {
                if ($saleUnit->operator == '*') {
                    $oldQty = $oldItem->qty * $saleUnit->operation_value;
                } else {
                    $oldQty = $oldItem->qty / $saleUnit->operation_value;
                }
            } else {
                $oldQty = $oldItem->qty;
            }

            $product = Product::find($oldItem->product_id);
            if ($product) {
                $product->qty -= $oldQty;
                $product->save();

                $productWarehouse = Product_Warehouse::where([
                    ['product_id', $oldItem->product_id],
                    ['warehouse_id', $return->warehouse_id]
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

        // Adjust old account balance
        $oldAccount = Account::find($return->account_id);
        if ($oldAccount) {
            $oldAccount->total_balance += $return->grand_total;
            $oldAccount->save();
        }

        $return->update($data);

        // Adjust new account balance
        $newAccount = Account::find($data['account_id']);
        if ($newAccount) {
            $newAccount->total_balance -= $data['grand_total'];
            $newAccount->save();
        }

        // Apply new returned quantities
        $productIds = $data['product_id'] ?? [];
        $imeiNumbers = $data['imei_number'] ?? [];
        $productCodes = $data['product_code'] ?? [];
        $qtys = $data['qty'] ?? [];
        $saleUnitIds = $data['sale_unit_id'] ?? [];
        $netUnitPrices = $data['net_unit_price'] ?? [];
        $discounts = $data['discount'] ?? [];
        $taxRates = $data['tax_rate'] ?? [];
        $taxes = $data['tax'] ?? [];
        $totals = $data['subtotal'] ?? [];
        $batchNos = $data['batch_no'] ?? [];

        foreach ($productIds as $i => $id) {
            $saleUnit = Unit::find($saleUnitIds[$i] ?? 0);
            $qty = $qtys[$i] ?? 0;

            if ($saleUnit) {
                if ($saleUnit->operator == '*') {
                    $quantity = $qty * $saleUnit->operation_value;
                } else {
                    $quantity = $qty / $saleUnit->operation_value;
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
                    $productBatch->qty += $quantity;
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
                    $productVariant->qty += $quantity;
                    $productVariant->save();
                    $productVariantId = $productVariant->variant_id;
                }
            }

            $product->qty += $quantity;
            $product->save();

            $productWarehouse = Product_Warehouse::where([
                ['product_id', $id],
                ['warehouse_id', $data['warehouse_id']]
            ])->first();

            if ($productWarehouse) {
                $productWarehouse->qty += $quantity;
                $productWarehouse->save();
            } else {
                Product_Warehouse::create([
                    'product_id'   => $id,
                    'warehouse_id' => $data['warehouse_id'],
                    'qty'          => $quantity,
                ]);
            }

            ProductReturn::create([
                'return_id'        => $return->id,
                'product_id'       => $id,
                'product_batch_id' => $productBatchId,
                'variant_id'       => $productVariantId,
                'imei_number'      => $imeiNumbers[$i] ?? null,
                'qty'              => $qty,
                'sale_unit_id'     => $saleUnitIds[$i] ?? null,
                'net_unit_price'   => $netUnitPrices[$i] ?? 0,
                'discount'         => $discounts[$i] ?? 0,
                'tax_rate'         => $taxRates[$i] ?? 0,
                'tax'              => $taxes[$i] ?? 0,
                'total'            => $totals[$i] ?? 0,
            ]);
        }

        return $return;
    }

    /**
     * Delete a sale return and revert quantities.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteReturn($id): bool
    {
        $return = $this->returnRepository->findOrFail($id);
        $productReturns = ProductReturn::where('return_id', $id)->get();

        foreach ($productReturns as $item) {
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
            if ($product) {
                $product->qty -= $quantity;
                $product->save();

                $productWarehouse = Product_Warehouse::where([
                    ['product_id', $item->product_id],
                    ['warehouse_id', $return->warehouse_id]
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

        $account = Account::find($return->account_id);
        if ($account) {
            $account->total_balance += $return->grand_total;
            $account->save();
        }

        if ($return->document) {
            @unlink(public_path('documents/sale_return/' . $return->document));
        }

        return $return->delete();
    }

    /**
     * Delete multiple returns.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleReturns(array $ids): bool
    {
        foreach ($ids as $id) {
            $this->deleteReturn($id);
        }
        return true;
    }
}
