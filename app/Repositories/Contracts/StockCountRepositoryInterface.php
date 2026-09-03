<?php

namespace App\Repositories\Contracts;

use App\Models\StockCount;
use Illuminate\Database\Eloquent\Collection;

interface StockCountRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get uncompleted or unresolved stock count.
     *
     * @return StockCount|null
     */
    public function getActiveStockCount(): ?StockCount;

    /**
     * Get stock count items by stock count id.
     *
     * @param int|string $stockCountId
     * @return Collection
     */
    public function getStockCountItems($stockCountId): Collection;
}
