<?php

namespace App\Repositories\Contracts;

use App\Models\ReturnPurchase;
use Illuminate\Database\Eloquent\Collection;

interface ReturnPurchaseRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get filtered return purchases for DataTables.
     *
     * @param int $start
     * @param int $limit
     * @param string $order
     * @param string $dir
     * @param int|null $warehouseId
     * @param string|null $startDate
     * @param string|null $endDate
     * @param string|null $searchValue
     * @return Collection
     */
    public function getFilteredReturnsForDataTable(int $start, int $limit, string $order, string $dir, ?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null, ?string $searchValue = null): Collection;

    /**
     * Count filtered return purchases for DataTables.
     *
     * @param int|null $warehouseId
     * @param string|null $startDate
     * @param string|null $endDate
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredReturnsForDataTable(?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null, ?string $searchValue = null): int;

    /**
     * Count total return purchases matching warehouse and date filters.
     *
     * @param int|null $warehouseId
     * @param string|null $startDate
     * @param string|null $endDate
     * @return int
     */
    public function countTotalReturns(?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null): int;

    /**
     * Get products and details for a return purchase.
     *
     * @param int|string $returnId
     * @return array
     */
    public function getProductReturnDataByReturnId($returnId): array;
}
