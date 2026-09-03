<?php

namespace App\Repositories\Contracts;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;

interface CouponRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active coupons.
     *
     * @return Collection
     */
    public function getActiveCoupons(): Collection;
}
