<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Warehouse;
use App\Models\ProductVariant;
use App\Models\StockCount;
use App\Models\StockCountItem;
use App\Models\Warehouse;
use App\Repositories\Contracts\StockCountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockCountService
{
    protected StockCountRepositoryInterface $stockCountRepository;

    /**
     * StockCountService constructor.
     *
     * @param StockCountRepositoryInterface $stockCountRepository
     */
    public function __construct(StockCountRepositoryInterface $stockCountRepository)
    {
        $this->stockCountRepository = $stockCountRepository;
    }

    /**
     * Get active (uncompleted/unresolved) stock count.
     *
     * @return StockCount|null
     */
    public function getActiveStockCount(): ?StockCount
    {
        return $this->stockCountRepository->getActiveStockCount();
    }

    /**
     * Get products for active stock count.
     *
     * @return mixed
     */
    public function getActiveStockCountProducts()
    {
        $stockCount = $this->getActiveStockCount();
        if (!$stockCount) {
            return [];
        }

        $query = Product::ActiveStandard()
            ->join('product_warehouse', 'products.id', 'product_warehouse.product_id');

        if ($stockCount->warehouse_id) {
            $query->where('product_warehouse.warehouse_id', $stockCount->warehouse_id);
        }

        return $query->select('products.id', 'products.name', 'products.code')
            ->groupBy('products.id')
            ->get();
    }

    /**
     * Create a new stock count and generate items.
     *
     * @param array $requestData
     * @return StockCount
     */
    public function createStockCount(array $requestData): StockCount
    {
        $data = $requestData;
        $data['reference_no'] = 'scr-' . date("Ymd") . '-' . date("his");
        $data['user_id'] = Auth::id();
        $data['is_completed'] = false;
        $data['is_resolved'] = false;

        $stockCount = $this->stockCountRepository->create($data);

        $query = Product::ActiveStandard()
            ->leftJoin('product_warehouse', 'products.id', '=', 'product_warehouse.product_id');

        if ($stockCount->warehouse_id) {
            $query->where('product_warehouse.warehouse_id', $stockCount->warehouse_id);
        }

        if (!empty($data['category_id'])) {
            $query->whereIn('products.category_id', $data['category_id']);
        }
        if (!empty($data['brand_id'])) {
            $query->whereIn('products.brand_id', $data['brand_id']);
        }

        $products = $query->select(
            'products.id',
            'products.is_variant',
            'product_warehouse.variant_id',
            'product_warehouse.qty'
        )->get();

        foreach ($products as $product) {
            StockCountItem::create([
                'stock_count_id' => $stockCount->id,
                'product_id'     => $product->id,
                'variant_id'     => $product->variant_id,
                'expected'       => $product->qty ?? 0,
                'counted'        => 0,
                'cost'           => 0,
            ]);
        }

        return $stockCount;
    }

    /**
     * Update stock count item counts.
     *
     * @param int|string $id
     * @param array $requestData
     * @return StockCount
     */
    public function updateStockCount($id, array $requestData): StockCount
    {
        $stockCount = $this->stockCountRepository->findOrFail($id);
        $countedData = $requestData['counted'] ?? [];

        foreach ($countedData as $itemId => $countedQty) {
            $item = StockCountItem::find($itemId);
            if ($item && $item->stock_count_id == $id) {
                $item->counted = $countedQty;
                $item->save();
            }
        }

        if (!empty($requestData['is_completed'])) {
            $stockCount->is_completed = true;
            $stockCount->save();
        }

        return $stockCount;
    }

    /**
     * Finalize stock count.
     *
     * @param int|string $id
     * @return StockCount
     */
    public function finalizeStockCount($id): StockCount
    {
        $stockCount = $this->stockCountRepository->findOrFail($id);
        $stockCount->is_completed = true;
        $stockCount->is_resolved = true;
        $stockCount->save();

        return $stockCount;
    }

    /**
     * Delete a stock count.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteStockCount($id): bool
    {
        StockCountItem::where('stock_count_id', $id)->delete();
        return $this->stockCountRepository->delete($id);
    }
}
