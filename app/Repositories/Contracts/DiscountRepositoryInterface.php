<?php

namespace App\Repositories\Contracts;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Collection;

interface DiscountRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all discounts with discount plans.
     *
     * @return Collection
     */
    public function getAllWithPlans(): Collection;
}
