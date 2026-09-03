<?php

namespace App\Repositories\Contracts;

use App\Models\Quotation;
use Illuminate\Database\Eloquent\Collection;

interface QuotationRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get filtered quotations for DataTables.
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
    public function getFilteredQuotationsForDataTable(int $start, int $limit, string $order, string $dir, ?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null, ?string $searchValue = null): Collection;

    /**
     * Count filtered quotations for DataTables.
     *
     * @param int|null $warehouseId
     * @param string|null $startDate
     * @param string|null $endDate
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredQuotationsForDataTable(?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null, ?string $searchValue = null): int;

    /**
     * Count total quotations matching warehouse and date filters.
     *
     * @param int|null $warehouseId
     * @param string|null $startDate
     * @param string|null $endDate
     * @return int
     */
    public function countTotalQuotations(?int $warehouseId = null, ?string $startDate = null, ?string $endDate = null): int;

    /**
     * Get products and details for a quotation modal.
     *
     * @param int|string $quotationId
     * @return array
     */
    public function getProductQuotationDataByQuotationId($quotationId): array;
}
