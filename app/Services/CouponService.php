<?php

namespace App\Services;

use App\Models\Coupon;
use App\Repositories\Contracts\CouponRepositoryInterface;
use App\Traits\CacheForget;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Keygen\Keygen;

class CouponService
{
    use CacheForget;

    protected CouponRepositoryInterface $couponRepository;

    /**
     * CouponService constructor.
     *
     * @param CouponRepositoryInterface $couponRepository
     */
    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    /**
     * Get all active coupons.
     *
     * @return Collection
     */
    public function getActiveCoupons(): Collection
    {
        return $this->couponRepository->getActiveCoupons();
    }

    /**
     * Generate unique alphanumeric code.
     *
     * @return string
     */
    public function generateCode(): string
    {
        return Keygen::alphanum(10)->generate();
    }

    /**
     * Create a new coupon.
     *
     * @param array $requestData
     * @return Coupon
     */
    public function createCoupon(array $requestData): Coupon
    {
        $data = $requestData;
        $data['used'] = 0;
        $data['user_id'] = Auth::id();
        $data['is_active'] = true;

        $coupon = $this->couponRepository->create($data);
        $this->cacheForget('coupon_list');

        return $coupon;
    }

    /**
     * Update an existing coupon.
     *
     * @param int|string $id
     * @param array $requestData
     * @return Coupon
     */
    public function updateCoupon($id, array $requestData): Coupon
    {
        $data = $requestData;
        if (($data['type'] ?? '') == 'percentage') {
            $data['minimum_amount'] = 0;
        }

        $coupon = $this->couponRepository->findOrFail($id);
        $coupon->update($data);
        $this->cacheForget('coupon_list');

        return $coupon;
    }

    /**
     * Delete multiple coupons.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleCoupons(array $ids): bool
    {
        foreach ($ids as $id) {
            $coupon = $this->couponRepository->find($id);
            if ($coupon) {
                $coupon->is_active = false;
                $coupon->save();
            }
        }
        $this->cacheForget('coupon_list');

        return true;
    }
}
