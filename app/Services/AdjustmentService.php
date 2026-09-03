<?php

namespace App\Services;

use App\Models\Adjustment;
use App\Models\Product;
use App\Models\ProductAdjustment;
use App\Models\ProductBatch;
use App\Models\ProductVariant;
use App\Models\Product_Warehouse;
use App\Models\StockCount;
use App\Models\Warehouse;
use App\Repositories\Contracts\AdjustmentRepositoryInterface;
use App\Traits\TenantInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class AdjustmentService
{
    use TenantInfo;

    protected AdjustmentRepositoryInterface $adjustmentRepository;

    /**
     * AdjustmentService constructor.
     *
     * @param AdjustmentRepositoryInterface $adjustmentRepository
     */
    public function __construct(AdjustmentRepositoryInterface $adjustmentRepository)
    {
        $this->adjustmentRepository = $adjustmentRepository;
    }

    /**
     * Get all adjustments with warehouse relations.
     *
     * @return Collection
     */
    public function getAllAdjustments(): Collection
    {
        return $this->adjustmentRepository->getAllAdjustmentsWithWarehouse();
    }

    /**
     * Get data required for create adjustment form.
     *
     * @return array
     */
    public function getCreateFormData(): array
    {
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        return compact('lims_warehouse_list');
    }

    /**
     * Get product data by warehouse for adjustment screen.
     *
     * @param int|string $warehouseId
     * @return array
     */
    public function getWarehouseProductData($warehouseId): array
    {
        $lims_product_warehouse_data = DB::table('products')
            ->join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
            ->whereNull('products.is_variant')
            ->where([
                ['products.is_active', true],
                ['product_warehouse.warehouse_id', $warehouseId]
            ])
            ->select('product_warehouse.qty', 'products.code', 'products.name')
            ->get();

        $lims_product_withVariant_warehouse_data = DB::table('products')
            ->join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
            ->whereNotNull('products.is_variant')
            ->where([
                ['products.is_active', true],
                ['product_warehouse.warehouse_id', $warehouseId]
            ])
            ->select('products.name', 'product_warehouse.qty', 'product_warehouse.product_id', 'product_warehouse.variant_id')
            ->get();

        $product_code = [];
        $product_name = [];
        $product_qty = [];

        foreach ($lims_product_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $product_code[] = $product_warehouse->code;
            $product_name[] = $product_warehouse->name;
        }

        foreach ($lims_product_withVariant_warehouse_data as $product_warehouse) {
            $product_variant = ProductVariant::select('item_code')->FindExactProduct($product_warehouse->product_id, $product_warehouse->variant_id)->first();
            if ($product_variant) {
                $product_qty[] = $product_warehouse->qty;
                $product_code[] = $product_variant->item_code;
                $product_name[] = $product_warehouse->name;
            }
        }

        return [
            $product_code,
            $product_name,
            $product_qty
        ];
    }

    /**
     * Create a new stock adjustment.
     *
     * @param array $requestData
     * @param UploadedFile|null $document
     * @return Adjustment
     */
    public function createAdjustment(array $requestData, ?UploadedFile $document): Adjustment
    {
        $data = $requestData;
        $data['reference_no'] = 'adr-' . date("Ymd") . '-' . date("his");

        if ($document) {
            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $document->move(public_path('documents/adjustment'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move(public_path('documents/adjustment'), $documentName);
            }
            $data['document'] = $documentName;
        }

        $adjustment = $this->adjustmentRepository->create($data);

        $productIds = $data['product_id'] ?? [];
        $productCodes = $data['product_code'] ?? [];
        $qtys = $data['qty'] ?? [];
        $actions = $data['action'] ?? [];
        $units = $data['unit'] ?? [];

        foreach ($productIds as $key => $pro_id) {
            $product = Product::find($pro_id);
            if (!$product) {
                continue;
            }

            $productVariantId = null;
            if ($product->is_variant) {
                $productVariant = ProductVariant::where([
                    ['product_id', $pro_id],
                    ['item_code', $productCodes[$key]]
                ])->first();
                if ($productVariant) {
                    $productVariantId = $productVariant->variant_id;
                }
            }

            $productWarehouse = Product_Warehouse::where([
                ['product_id', $pro_id],
                ['warehouse_id', $data['warehouse_id']]
            ]);

            if ($productVariantId) {
                $productWarehouse->where('variant_id', $productVariantId);
            }
            $lims_product_warehouse_data = $productWarehouse->first();

            if ($actions[$key] == '-') {
                $product->qty -= $qtys[$key];
                if ($lims_product_warehouse_data) {
                    $lims_product_warehouse_data->qty -= $qtys[$key];
                    $lims_product_warehouse_data->save();
                }
                if ($productVariantId) {
                    $productVariant = ProductVariant::where([
                        ['product_id', $pro_id],
                        ['variant_id', $productVariantId]
                    ])->first();
                    if ($productVariant) {
                        $productVariant->qty -= $qtys[$key];
                        $productVariant->save();
                    }
                }
            } elseif ($actions[$key] == '+') {
                $product->qty += $qtys[$key];
                if ($lims_product_warehouse_data) {
                    $lims_product_warehouse_data->qty += $qtys[$key];
                    $lims_product_warehouse_data->save();
                } else {
                    Product_Warehouse::create([
                        'product_id'   => $pro_id,
                        'warehouse_id' => $data['warehouse_id'],
                        'qty'          => $qtys[$key],
                        'variant_id'   => $productVariantId
                    ]);
                }
                if ($productVariantId) {
                    $productVariant = ProductVariant::where([
                        ['product_id', $pro_id],
                        ['variant_id', $productVariantId]
                    ])->first();
                    if ($productVariant) {
                        $productVariant->qty += $qtys[$key];
                        $productVariant->save();
                    }
                }
            }

            $product->save();

            ProductAdjustment::create([
                'adjustment_id' => $adjustment->id,
                'product_id'    => $pro_id,
                'variant_id'    => $productVariantId,
                'unit'          => $units[$key] ?? '',
                'qty'           => $qtys[$key],
                'action'        => $actions[$key]
            ]);
        }

        if (isset($data['stock_count_id'])) {
            $stockCount = StockCount::find($data['stock_count_id']);
            if ($stockCount) {
                $stockCount->is_adjusted = true;
                $stockCount->save();
            }
        }

        return $adjustment;
    }

    /**
     * Get data required for edit adjustment form.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $lims_adjustment_data = Adjustment::find($id);
        $lims_product_adjustment_data = ProductAdjustment::where('adjustment_id', $id)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();

        return compact('lims_adjustment_data', 'lims_product_adjustment_data', 'lims_warehouse_list');
    }

    /**
     * Update an existing stock adjustment.
     *
     * @param int|string $id
     * @param array $requestData
     * @param UploadedFile|null $document
     * @return Adjustment
     */
    public function updateAdjustment($id, array $requestData, ?UploadedFile $document): Adjustment
    {
        $adjustment = $this->adjustmentRepository->findOrFail($id);
        $data = $requestData;

        if ($document) {
            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $documentName = $documentName . '.' . $ext;
                $document->move(public_path('documents/adjustment'), $documentName);
            } else {
                $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
                $document->move(public_path('documents/adjustment'), $documentName);
            }
            $data['document'] = $documentName;
        }

        // Revert previous adjustments
        $oldAdjustments = ProductAdjustment::where('adjustment_id', $id)->get();
        foreach ($oldAdjustments as $oldItem) {
            $product = Product::find($oldItem->product_id);
            if (!$product) {
                continue;
            }

            $productWarehouse = Product_Warehouse::where([
                ['product_id', $oldItem->product_id],
                ['warehouse_id', $adjustment->warehouse_id]
            ]);

            if ($oldItem->variant_id) {
                $productWarehouse->where('variant_id', $oldItem->variant_id);
            }
            $lims_product_warehouse_data = $productWarehouse->first();

            if ($oldItem->action == '-') {
                $product->qty += $oldItem->qty;
                if ($lims_product_warehouse_data) {
                    $lims_product_warehouse_data->qty += $oldItem->qty;
                    $lims_product_warehouse_data->save();
                }
                if ($oldItem->variant_id) {
                    $productVariant = ProductVariant::where([
                        ['product_id', $oldItem->product_id],
                        ['variant_id', $oldItem->variant_id]
                    ])->first();
                    if ($productVariant) {
                        $productVariant->qty += $oldItem->qty;
                        $productVariant->save();
                    }
                }
            } elseif ($oldItem->action == '+') {
                $product->qty -= $oldItem->qty;
                if ($lims_product_warehouse_data) {
                    $lims_product_warehouse_data->qty -= $oldItem->qty;
                    $lims_product_warehouse_data->save();
                }
                if ($oldItem->variant_id) {
                    $productVariant = ProductVariant::where([
                        ['product_id', $oldItem->product_id],
                        ['variant_id', $oldItem->variant_id]
                    ])->first();
                    if ($productVariant) {
                        $productVariant->qty -= $oldItem->qty;
                        $productVariant->save();
                    }
                }
            }
            $product->save();
            $oldItem->delete();
        }

        $adjustment->update($data);

        // Apply new adjustments
        $productIds = $data['product_id'] ?? [];
        $productCodes = $data['product_code'] ?? [];
        $qtys = $data['qty'] ?? [];
        $actions = $data['action'] ?? [];
        $units = $data['unit'] ?? [];

        foreach ($productIds as $key => $pro_id) {
            $product = Product::find($pro_id);
            if (!$product) {
                continue;
            }

            $productVariantId = null;
            if ($product->is_variant) {
                $productVariant = ProductVariant::where([
                    ['product_id', $pro_id],
                    ['item_code', $productCodes[$key]]
                ])->first();
                if ($productVariant) {
                    $productVariantId = $productVariant->variant_id;
                }
            }

            $productWarehouse = Product_Warehouse::where([
                ['product_id', $pro_id],
                ['warehouse_id', $data['warehouse_id']]
            ]);

            if ($productVariantId) {
                $productWarehouse->where('variant_id', $productVariantId);
            }
            $lims_product_warehouse_data = $productWarehouse->first();

            if ($actions[$key] == '-') {
                $product->qty -= $qtys[$key];
                if ($lims_product_warehouse_data) {
                    $lims_product_warehouse_data->qty -= $qtys[$key];
                    $lims_product_warehouse_data->save();
                }
                if ($productVariantId) {
                    $productVariant = ProductVariant::where([
                        ['product_id', $pro_id],
                        ['variant_id', $productVariantId]
                    ])->first();
                    if ($productVariant) {
                        $productVariant->qty -= $qtys[$key];
                        $productVariant->save();
                    }
                }
            } elseif ($actions[$key] == '+') {
                $product->qty += $qtys[$key];
                if ($lims_product_warehouse_data) {
                    $lims_product_warehouse_data->qty += $qtys[$key];
                    $lims_product_warehouse_data->save();
                } else {
                    Product_Warehouse::create([
                        'product_id'   => $pro_id,
                        'warehouse_id' => $data['warehouse_id'],
                        'qty'          => $qtys[$key],
                        'variant_id'   => $productVariantId
                    ]);
                }
                if ($productVariantId) {
                    $productVariant = ProductVariant::where([
                        ['product_id', $pro_id],
                        ['variant_id', $productVariantId]
                    ])->first();
                    if ($productVariant) {
                        $productVariant->qty += $qtys[$key];
                        $productVariant->save();
                    }
                }
            }

            $product->save();

            ProductAdjustment::create([
                'adjustment_id' => $adjustment->id,
                'product_id'    => $pro_id,
                'variant_id'    => $productVariantId,
                'unit'          => $units[$key] ?? '',
                'qty'           => $qtys[$key],
                'action'        => $actions[$key]
            ]);
        }

        return $adjustment;
    }

    /**
     * Delete an adjustment and revert quantities.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteAdjustment($id): bool
    {
        $adjustment = $this->adjustmentRepository->findOrFail($id);
        $productAdjustments = ProductAdjustment::where('adjustment_id', $id)->get();

        foreach ($productAdjustments as $item) {
            $product = Product::find($item->product_id);
            if (!$product) {
                continue;
            }

            $productWarehouse = Product_Warehouse::where([
                ['product_id', $item->product_id],
                ['warehouse_id', $adjustment->warehouse_id]
            ]);

            if ($item->variant_id) {
                $productWarehouse->where('variant_id', $item->variant_id);
            }
            $lims_product_warehouse_data = $productWarehouse->first();

            if ($item->action == '-') {
                $product->qty += $item->qty;
                if ($lims_product_warehouse_data) {
                    $lims_product_warehouse_data->qty += $item->qty;
                    $lims_product_warehouse_data->save();
                }
                if ($item->variant_id) {
                    $productVariant = ProductVariant::where([
                        ['product_id', $item->product_id],
                        ['variant_id', $item->variant_id]
                    ])->first();
                    if ($productVariant) {
                        $productVariant->qty += $item->qty;
                        $productVariant->save();
                    }
                }
            } elseif ($item->action == '+') {
                $product->qty -= $item->qty;
                if ($lims_product_warehouse_data) {
                    $lims_product_warehouse_data->qty -= $item->qty;
                    $lims_product_warehouse_data->save();
                }
                if ($item->variant_id) {
                    $productVariant = ProductVariant::where([
                        ['product_id', $item->product_id],
                        ['variant_id', $item->variant_id]
                    ])->first();
                    if ($productVariant) {
                        $productVariant->qty -= $item->qty;
                        $productVariant->save();
                    }
                }
            }
            $product->save();
            $item->delete();
        }

        if ($adjustment->document) {
            @unlink(public_path('documents/adjustment/' . $adjustment->document));
        }

        return $adjustment->delete();
    }

    /**
     * Delete multiple adjustments.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleAdjustments(array $ids): bool
    {
        foreach ($ids as $id) {
            $this->deleteAdjustment($id);
        }
        return true;
    }
}
