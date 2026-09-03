<?php

namespace App\Repositories\Contracts;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Collection;

interface PurchaseRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get filtered purchases for DataTables.
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
    public function getFilteredPurchasesForDataTable(int $start, int $limit, string $order, string $dir, array $filters, ?string $searchValue = null, array $fieldNames = []): Collection;

    /**
     * Count filtered purchases for DataTables.
     *
     * @param array $filters
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredPurchasesForDataTable(array $filters, ?string $searchValue = null): int;

    /**
     * Count total purchases matching date & warehouse filters.
     *
     * @param array $filters
     * @return int
     */
    public function countTotalPurchases(array $filters): int;

    /**
     * Get products and product purchase details for a purchase.
     *
     * @param int|string $purchaseId
     * @return array
     */
    public function getProductPurchaseDataByPurchaseId($purchaseId): array;

    /**
     * Search products for purchase screen.
     *
     * @param string $productCode
     * @param int|null $brandId
     * @return array [products => Collection, variants => Collection]
     */
    public function searchProductsForPurchase(string $productCode, ?int $brandId = null): array;
}
