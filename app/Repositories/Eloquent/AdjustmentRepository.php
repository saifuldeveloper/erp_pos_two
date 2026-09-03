<?php

namespace App\Repositories\Eloquent;

use App\Models\Adjustment;
use App\Repositories\Contracts\AdjustmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AdjustmentRepository extends BaseRepository implements AdjustmentRepositoryInterface
{
    /**
     * AdjustmentRepository constructor.
     *
     * @param Adjustment $model
     */
    public function __construct(Adjustment $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all adjustments with warehouses.
     *
     * @return Collection
     */
    public function getAllAdjustmentsWithWarehouse(): Collection
    {
        return $this->model->with('warehouse')->orderBy('id', 'desc')->get();
    }
}
