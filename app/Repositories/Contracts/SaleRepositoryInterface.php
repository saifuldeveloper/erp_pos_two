<?php

namespace App\Repositories\Contracts;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

interface SaleRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get filtered sales for DataTables.
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
    public function getFilteredSalesForDataTable(int $start, int $limit, string $order, string $dir, array $filters, ?string $searchValue = null, array $fieldNames = []): Collection;

    /**
     * Count filtered sales for DataTables.
     *
     * @param array $filters
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredSalesForDataTable(array $filters, ?string $searchValue = null): int;

    /**
     * Count total sales matching filters.
     *
     * @param array $filters
     * @return int
     */
    public function countTotalSales(array $filters): int;

    /**
     * Get product sale details for a sale modal.
     *
     * @param int|string $saleId
     * @return array
     */
    public function getProductSaleDataBySaleId($saleId): array;

    /**
     * Get payments by sale id.
     *
     * @param int|string $saleId
     * @return array
     */
    public function getPaymentsBySaleId($saleId): array;
}
