<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * ProductRepository constructor.
     *
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active standard products without variants.
     *
     * @return Collection
     */
    public function getProductsWithoutVariant(): Collection
    {
        return $this->model
            ->ActiveStandard()
            ->select('id', 'name', 'code')
            ->whereNull('is_variant')
            ->get();
    }

    /**
     * Get active standard products with variants.
     *
     * @return Collection
     */
    public function getProductsWithVariant(): Collection
    {
        return $this->model
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->ActiveStandard()
            ->whereNotNull('is_variant')
            ->select('products.id', 'products.name', 'product_variants.item_code')
            ->orderBy('position')
            ->get();
    }

    /**
     * Get all active standard products.
     *
     * @return Collection
     */
    public function getActiveStandardProducts(): Collection
    {
        return $this->model
            ->ActiveStandard()
            ->select('id', 'name', 'code')
            ->get();
    }

    /**
     * Find product by ID with eager loaded relations.
     *
     * @param int|string $id
     * @param array $relations
     * @return Product|null
     */
    public function findWithRelations($id, array $relations = []): ?Product
    {
        return $this->model->with($relations)->find($id);
    }

    /**
     * Count total active products.
     *
     * @return int
     */
    public function countTotalActiveProducts(): int
    {
        return $this->model->where('is_active', true)->count();
    }

    /**
     * Build base query for DataTables.
     *
     * @param array $filters
     * @param string|null $searchValue
     * @param array $fieldNames
     * @return Builder
     */
    protected function buildDataTableQuery(array $filters = [], ?string $searchValue = null, array $fieldNames = []): Builder
    {
        $query = $this->model
            ->with(['category.parent', 'brand', 'unit', 'productImages.color'])
            ->where('is_active', true);

        if (!empty($filters['name'])) {
            $query->where('name', 'LIKE', "%{$filters['name']}%");
        }

        if (!empty($filters['code'])) {
            $query->where('code', 'LIKE', "%{$filters['code']}%");
        }

        if (!empty($filters['brand'])) {
            $query->whereHas('brand', fn($q) => $q->where('title', $filters['brand']));
        }

        if (!empty($filters['category'])) {
            $query->whereHas('category', fn($q) => $q->where('name', $filters['category']));
        }

        if (!empty($filters['unit'])) {
            $query->whereHas('unit', fn($q) => $q->where('unit_name', $filters['unit']));
        }

        if (isset($filters['qty']) && $filters['qty'] !== null && $filters['qty'] !== '') {
            $query->where('qty', '=', $filters['qty']);
        }

        if (isset($filters['price']) && $filters['price'] !== null && $filters['price'] !== '') {
            $query->where('price', '=', $filters['price']);
        }

        if (isset($filters['cost']) && $filters['cost'] !== null && $filters['cost'] !== '') {
            $query->where('cost', '=', $filters['cost']);
        }

        if (!empty($filters['in_stock']) && $filters['in_stock'] == 1) {
            $query->where('qty', '>', 0);
        }

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue, $fieldNames) {
                $q->where('products.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('products.code', 'LIKE', "%{$searchValue}%")
                    ->orWhereHas('category', fn($sq) => $sq->where('name', 'LIKE', "%{$searchValue}%"))
                    ->orWhereHas('brand', fn($sq) => $sq->where('title', 'LIKE', "%{$searchValue}%"));

                foreach ($fieldNames as $fieldName) {
                    $q->orWhere('products.' . $fieldName, 'LIKE', "%{$searchValue}%");
                }
            });
        }

        return $query;
    }

    /**
     * Get filtered products for DataTables query.
     *
     * @param int $start
     * @param int $limit
     * @param string $order
     * @param string $dir
     * @param array $filters
     * @param string|null $searchValue
     * @param array $fieldNames
     * @return Collection
     */
    public function getFilteredProductsForDataTable(
        int $start,
        int $limit,
        string $order,
        string $dir,
        array $filters = [],
        ?string $searchValue = null,
        array $fieldNames = []
    ): Collection {
        $query = $this->buildDataTableQuery($filters, $searchValue, $fieldNames);

        return $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }

    /**
     * Count filtered products for DataTables.
     *
     * @param array $filters
     * @param string|null $searchValue
     * @param array $fieldNames
     * @return int
     */
    public function countFilteredProductsForDataTable(
        array $filters = [],
        ?string $searchValue = null,
        array $fieldNames = []
    ): int {
        $query = $this->buildDataTableQuery($filters, $searchValue, $fieldNames);

        return $query->count();
    }

    /**
     * Calculate total sums (qty, cost, price) for filtered products.
     *
     * @param array $filters
     * @param string|null $searchValue
     * @param array $fieldNames
     * @return object|null
     */
    public function getFilteredTotals(
        array $filters = [],
        ?string $searchValue = null,
        array $fieldNames = []
    ): ?object {
        $query = $this->buildDataTableQuery($filters, $searchValue, $fieldNames);

        return $query->selectRaw('
            COALESCE(SUM(qty), 0) as total_qty,
            COALESCE(SUM(qty * cost), 0) as total_cost,
            COALESCE(SUM(qty * price), 0) as total_price
        ')->first();
    }

    /**
     * Get product variant data by product ID (warehouse aware).
     *
     * @param int|string $productId
     * @param int|null $userRoleId
     * @param int|null $userWarehouseId
     * @return Collection
     */
    public function getVariantDataByProductId($productId, ?int $userRoleId = null, ?int $userWarehouseId = null): Collection
    {
        if ($userRoleId > 2 && $userRoleId != 3 && $userWarehouseId) {
            return ProductVariant::join('variants', 'product_variants.variant_id', '=', 'variants.id')
                ->join('product_warehouse', function ($join) {
                    $join->on('product_variants.product_id', '=', 'product_warehouse.product_id');
                    $join->on('product_variants.variant_id', '=', 'product_warehouse.variant_id');
                })
                ->select('variants.name', 'product_variants.item_code', 'product_variants.additional_cost', 'product_variants.additional_price', 'product_warehouse.qty')
                ->where([
                    ['product_warehouse.product_id', $productId],
                    ['product_warehouse.warehouse_id', $userWarehouseId]
                ])
                ->orderBy('product_variants.position')
                ->get();
        }

        return ProductVariant::join('variants', 'product_variants.variant_id', '=', 'variants.id')
            ->select('variants.name', 'product_variants.item_code', 'product_variants.additional_cost', 'product_variants.additional_price', 'product_variants.qty')
            ->orderBy('product_variants.position')
            ->where('product_id', $productId)
            ->get();
    }

    /**
     * Search products and variants by product codes for barcode printing.
     *
     * @param array $productCodes
     * @return array
     */
    public function getProductsAndVariantsByCodes(array $productCodes): array
    {
        $products = $this->model->whereIn('code', $productCodes)
            ->where('is_active', true)
            ->get();

        $variantProducts = $this->model->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->select('products.*', 'product_variants.item_code', 'product_variants.variant_id', 'product_variants.additional_price')
            ->whereIn('product_variants.item_code', $productCodes)
            ->get();

        return [$products, $variantProducts];
    }

    /**
     * Search products for POS / autocomplete.
     *
     * @param string $code
     * @return Collection
     */
    public function searchForPos(string $code): Collection
    {
        $product = $this->model->where([
            ['code', $code],
            ['is_active', true]
        ])->first();

        if ($product) {
            $variantData = $this->model->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->select('products.*', 'product_variants.item_code', 'product_variants.variant_id', 'product_variants.additional_price')
                ->where('product_variants.product_id', $product->id)
                ->get();

            if ($variantData->isEmpty()) {
                return $this->model->where('id', $product->id)->get();
            }

            return $variantData;
        }

        return $this->model->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->select('products.*', 'product_variants.item_code', 'product_variants.variant_id', 'product_variants.additional_price')
            ->where('product_variants.item_code', $code)
            ->get();
    }

    /**
     * Deactivate a product (is_active = false).
     *
     * @param int|string $id
     * @return Product|null
     */
    public function deactivateProduct($id): ?Product
    {
        $product = $this->find($id);
        if ($product) {
            $product->is_active = false;
            $product->save();
        }
        return $product;
    }

    /**
     * Deactivate multiple products by IDs.
     *
     * @param array $ids
     * @return array
     */
    public function deactivateMultipleProducts(array $ids): array
    {
        $products = [];
        foreach ($ids as $id) {
            $product = $this->deactivateProduct($id);
            if ($product) {
                $products[] = $product;
            }
        }
        return $products;
    }
}
