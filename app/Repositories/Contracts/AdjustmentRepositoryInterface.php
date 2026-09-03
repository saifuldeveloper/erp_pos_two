<?php

namespace App\Repositories\Contracts;

use App\Models\Adjustment;
use Illuminate\Database\Eloquent\Collection;

interface AdjustmentRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all adjustments with warehouses.
     *
     * @return Collection
     */
    public function getAllAdjustmentsWithWarehouse(): Collection;
}
