<?php

namespace App\Repositories\Eloquent;

use App\Models\Courier;
use App\Repositories\Contracts\CourierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CourierRepository extends BaseRepository implements CourierRepositoryInterface
{
    /**
     * CourierRepository constructor.
     *
     * @param Courier $model
     */
    public function __construct(Courier $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active couriers.
     *
     * @return Collection
     */
    public function getActiveCouriers(): Collection
    {
        return $this->model->where('is_active', true)->orderBy('id', 'desc')->get();
    }
}
