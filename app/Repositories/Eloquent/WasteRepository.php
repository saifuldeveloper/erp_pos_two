<?php

namespace App\Repositories\Eloquent;

use App\Models\Waste;
use App\Repositories\Contracts\WasteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WasteRepository extends BaseRepository implements WasteRepositoryInterface
{
    /**
     * WasteRepository constructor.
     *
     * @param Waste $model
     */
    public function __construct(Waste $model)
    {
        parent::__construct($model);
    }

    /**
     * Get wastes filtered by date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function getWastesByDateRange(string $startDate, string $endDate): Collection
    {
        return $this->model->with('items.product')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('id', 'desc')
            ->get();
    }
}
