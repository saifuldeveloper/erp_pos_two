<?php

namespace App\Repositories\Eloquent;

use App\Models\DiscountPlan;
use App\Repositories\Contracts\DiscountPlanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DiscountPlanRepository extends BaseRepository implements DiscountPlanRepositoryInterface
{
    /**
     * DiscountPlanRepository constructor.
     *
     * @param DiscountPlan $model
     */
    public function __construct(DiscountPlan $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all discount plans with customers.
     *
     * @return Collection
     */
    public function getAllWithCustomers(): Collection
    {
        return $this->model->with('customers')->orderBy('id', 'desc')->get();
    }

    /**
     * Get active discount plans.
     *
     * @return Collection
     */
    public function getActiveDiscountPlans(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }
}
