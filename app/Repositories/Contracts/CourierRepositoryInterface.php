<?php

namespace App\Repositories\Contracts;

use App\Models\Courier;
use Illuminate\Database\Eloquent\Collection;

interface CourierRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active couriers.
     *
     * @return Collection
     */
    public function getActiveCouriers(): Collection;
}
