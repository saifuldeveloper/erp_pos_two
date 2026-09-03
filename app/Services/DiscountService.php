<?php

namespace App\Services;

use App\Models\Discount;
use App\Models\DiscountPlan;
use App\Models\DiscountPlanDiscount;
use App\Models\Product;
use App\Repositories\Contracts\DiscountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DiscountService
{
    protected DiscountRepositoryInterface $discountRepository;

    /**
     * DiscountService constructor.
     *
     * @param DiscountRepositoryInterface $discountRepository
     */
    public function __construct(DiscountRepositoryInterface $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    /**
     * Get all discounts with plans.
     *
     * @return Collection
     */
    public function getAllDiscounts(): Collection
    {
        return $this->discountRepository->getAllWithPlans();
    }

    /**
     * Get active discount plans for form dropdown.
     *
     * @return Collection
     */
    public function getActiveDiscountPlans(): Collection
    {
        return DiscountPlan::where('is_active', true)->get();
    }

    /**
     * Search active product by code.
     *
     * @param string $code
     * @return array
     */
    public function searchProductByCode(string $code): array
    {
        $lims_product_data = Product::where([
            ['code', $code],
            ['is_active', true]
        ])->select('id', 'name', 'code')->first();

        if (!$lims_product_data) {
            return [];
        }

        return [$lims_product_data->id, $lims_product_data->name, $lims_product_data->code];
    }

    /**
     * Create a new discount.
     *
     * @param array $requestData
     * @return Discount
     */
    public function createDiscount(array $requestData): Discount
    {
        $data = $requestData;
        $data['valid_from'] = date('Y-m-d', strtotime(str_replace("/", "-", $data['valid_from'])));
        $data['valid_till'] = date('Y-m-d', strtotime(str_replace("/", "-", $data['valid_till'])));

        if (isset($data['product_list']) && is_array($data['product_list'])) {
            $data['product_list'] = implode(",", $data['product_list']);
        }
        if (isset($data['days']) && is_array($data['days'])) {
            $data['days'] = implode(",", $data['days']);
        }

        $discount = $this->discountRepository->create($data);

        $discountPlanIds = $data['discount_plan_id'] ?? [];
        foreach ($discountPlanIds as $discountPlanId) {
            DiscountPlanDiscount::create([
                'discount_id'      => $discount->id,
                'discount_plan_id' => $discountPlanId
            ]);
        }

        return $discount;
    }

    /**
     * Get data for edit discount form.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $lims_discount_data = $this->discountRepository->findOrFail($id);
        $discount_plan_ids = DiscountPlanDiscount::where('discount_id', $id)->pluck('discount_plan_id')->toArray();
        $lims_discount_plan_list = DiscountPlan::where('is_active', true)->get();

        return compact('lims_discount_data', 'discount_plan_ids', 'lims_discount_plan_list');
    }

    /**
     * Update an existing discount.
     *
     * @param int|string $id
     * @param array $requestData
     * @return Discount
     */
    public function updateDiscount($id, array $requestData): Discount
    {
        $data = $requestData;
        $discount = $this->discountRepository->findOrFail($id);

        $data['valid_from'] = date('Y-m-d', strtotime(str_replace("/", "-", $data['valid_from'])));
        $data['valid_till'] = date('Y-m-d', strtotime(str_replace("/", "-", $data['valid_till'])));

        if (!isset($data['is_active'])) {
            $data['is_active'] = 0;
        }

        if (($data['applicable_for'] ?? '') == 'All') {
            $data['product_list'] = '';
        } elseif (isset($data['product_list']) && is_array($data['product_list'])) {
            $data['product_list'] = implode(",", $data['product_list']);
        }

        if (isset($data['days']) && is_array($data['days'])) {
            $data['days'] = implode(",", $data['days']);
        }

        $preDiscountPlanIds = DiscountPlanDiscount::where('discount_id', $id)->pluck('discount_plan_id')->toArray();
        $newDiscountPlanIds = $data['discount_plan_id'] ?? [];

        foreach ($preDiscountPlanIds as $discountPlanId) {
            if (!in_array($discountPlanId, $newDiscountPlanIds)) {
                DiscountPlanDiscount::where([
                    ['discount_plan_id', $discountPlanId],
                    ['discount_id', $id]
                ])->delete();
            }
        }

        foreach ($newDiscountPlanIds as $discountPlanId) {
            if (!in_array($discountPlanId, $preDiscountPlanIds)) {
                DiscountPlanDiscount::create([
                    'discount_id'      => $id,
                    'discount_plan_id' => $discountPlanId
                ]);
            }
        }

        $discount->update($data);

        return $discount;
    }
}
