<?php

namespace App\Repositories\Eloquent;

use App\Models\Coupon;
use App\Repositories\Contracts\CouponRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
    /**
     * CouponRepository constructor.
     *
     * @param Coupon $model
     */
    public function __construct(Coupon $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active coupons.
     *
     * @return Collection
     */
    public function getActiveCoupons(): Collection
    {
        return $this->model->where('is_active', true)->orderBy('id', 'desc')->get();
    }
}
