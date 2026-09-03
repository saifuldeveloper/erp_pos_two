<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get active standard products without variants.
     *
     * @return Collection
     */
    public function getProductsWithoutVariant(): Collection;

    /**
     * Get active standard products with variants.
     *
     * @return Collection
     */
    public function getProductsWithVariant(): Collection;

    /**
     * Get all active standard products.
     *
     * @return Collection
     */
    public function getActiveStandardProducts(): Collection;

    /**
     * Find product by ID with eager loaded relations.
     *
     * @param int|string $id
     * @param array $relations
     * @return Product|null
     */
    public function findWithRelations($id, array $relations = []): ?Product;

    /**
     * Count total active products.
     *
     * @return int
     */
    public function countTotalActiveProducts(): int;

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
    ): Collection;

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
    ): int;

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
    ): ?object;

    /**
     * Get product variant data by product ID (warehouse aware).
     *
     * @param int|string $productId
     * @param int|null $userRoleId
     * @param int|null $userWarehouseId
     * @return Collection
     */
    public function getVariantDataByProductId($productId, ?int $userRoleId = null, ?int $userWarehouseId = null): Collection;

    /**
     * Search products and variants by product codes for barcode printing.
     *
     * @param array $productCodes
     * @return array
     */
    public function getProductsAndVariantsByCodes(array $productCodes): array;

    /**
     * Search products for POS / autocomplete.
     *
     * @param string $code
     * @return Collection
     */
    public function searchForPos(string $code): Collection;

    /**
     * Deactivate a product (is_active = false).
     *
     * @param int|string $id
     * @return Product|null
     */
    public function deactivateProduct($id): ?Product;

    /**
     * Deactivate multiple products by IDs.
     *
     * @param array $ids
     * @return array
     */
    public function deactivateMultipleProducts(array $ids): array;
}
