<?php

namespace App\Repositories\Contracts;

use App\Models\Returns;
use Illuminate\Database\Eloquent\Collection;

interface ReturnRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get filtered sale returns for DataTables.
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
     * Count filtered sale returns for DataTables.
     *
     * @param int|null $warehouseId
     * @param string|null $startDate
     * @param string|null $endDate
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredReturnsForDataTable(?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null, ?string $searchValue = null): int;

    /**
     * Count total sale returns matching warehouse and date filters.
     *
     * @param int|null $warehouseId
     * @param string|null $startDate
     * @param string|null $endDate
     * @return int
     */
    public function countTotalReturns(?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null): int;

    /**
     * Get products and details for a return modal.
     *
     * @param int|string $returnId
     * @return array
     */
    public function getProductReturnDataByReturnId($returnId): array;
}
