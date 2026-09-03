<?php

namespace App\Repositories\Contracts;

use App\Models\DiscountPlan;
use Illuminate\Database\Eloquent\Collection;

interface DiscountPlanRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all discount plans with customers.
     *
     * @return Collection
     */
    public function getAllWithCustomers(): Collection;

    /**
     * Get active discount plans.
     *
     * @return Collection
     */
    public function getActiveDiscountPlans(): Collection;
}
