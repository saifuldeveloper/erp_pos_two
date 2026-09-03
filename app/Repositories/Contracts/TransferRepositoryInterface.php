<?php

namespace App\Repositories\Contracts;

use App\Models\Transfer;
use Illuminate\Database\Eloquent\Collection;

interface TransferRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get filtered transfers for DataTables.
     *
     * @param int $start
     * @param int $limit
     * @param string $order
     * @param string $dir
     * @param array $filters
     * @param string|null $searchValue
     * @return Collection
     */
    public function getFilteredTransfersForDataTable(int $start, int $limit, string $order, string $dir, array $filters, ?string $searchValue = null): Collection;

    /**
     * Count filtered transfers for DataTables.
     *
     * @param array $filters
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredTransfersForDataTable(array $filters, ?string $searchValue = null): int;

    /**
     * Count total transfers matching filters.
     *
     * @param array $filters
     * @return int
     */
    public function countTotalTransfers(array $filters): int;

    /**
     * Get products and details for a transfer modal.
     *
     * @param int|string $transferId
     * @return array
     */
    public function getProductTransferDataByTransferId($transferId): array;

    /**
     * Search products for transfer screen.
     *
     * @param string $productCode
     * @param int $warehouseId
     * @return array
     */
    public function searchProductsForTransfer(string $productCode, int $warehouseId): array;
}
