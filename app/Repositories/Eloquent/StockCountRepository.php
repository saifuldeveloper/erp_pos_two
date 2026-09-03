<?php

namespace App\Repositories\Eloquent;

use App\Models\StockCount;
use App\Models\StockCountItem;
use App\Repositories\Contracts\StockCountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StockCountRepository extends BaseRepository implements StockCountRepositoryInterface
{
    /**
     * StockCountRepository constructor.
     *
     * @param StockCount $model
     */
    public function __construct(StockCount $model)
    {
        parent::__construct($model);
    }

    /**
     * Get uncompleted or unresolved stock count.
     *
     * @return StockCount|null
     */
    public function getActiveStockCount(): ?StockCount
    {
        return $this->model->where('is_completed', false)->orWhere('is_resolved', false)->first();
    }

    /**
     * Get stock count items by stock count id.
     *
     * @param int|string $stockCountId
     * @return Collection
     */
    public function getStockCountItems($stockCountId): Collection
    {
        return StockCountItem::where('stock_count_id', $stockCountId)->get();
    }
}
