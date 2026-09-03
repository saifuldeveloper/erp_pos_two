<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\DiscountPlan;
use App\Models\DiscountPlanCustomer;
use App\Repositories\Contracts\DiscountPlanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DiscountPlanService
{
    protected DiscountPlanRepositoryInterface $discountPlanRepository;

    /**
     * DiscountPlanService constructor.
     *
     * @param DiscountPlanRepositoryInterface $discountPlanRepository
     */
    public function __construct(DiscountPlanRepositoryInterface $discountPlanRepository)
    {
        $this->discountPlanRepository = $discountPlanRepository;
    }

    /**
     * Get all discount plans with customer relation.
     *
     * @return Collection
     */
    public function getAllDiscountPlans(): Collection
    {
        return $this->discountPlanRepository->getAllWithCustomers();
    }

    /**
     * Get data for creating discount plan.
     *
     * @return Collection
     */
    public function getActiveCustomers(): Collection
    {
        return Customer::where('is_active', true)->get();
    }

    /**
     * Create discount plan with assigned customers.
     *
     * @param array $requestData
     * @return DiscountPlan
     */
    public function createDiscountPlan(array $requestData): DiscountPlan
    {
        $data = $requestData;
        if (!isset($data['is_active'])) {
            $data['is_active'] = 0;
        }

        $discountPlan = $this->discountPlanRepository->create($data);

        $customerIds = $data['customer_id'] ?? [];
        foreach ($customerIds as $customerId) {
            DiscountPlanCustomer::create([
                'discount_plan_id' => $discountPlan->id,
                'customer_id'      => $customerId,
            ]);
        }

        return $discountPlan;
    }

    /**
     * Get data for edit discount plan form.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $lims_discount_plan = $this->discountPlanRepository->findOrFail($id);
        $lims_customer_list = Customer::where('is_active', true)->get();
        $customer_ids = DiscountPlanCustomer::where('discount_plan_id', $id)->pluck('customer_id')->toArray();

        return compact('lims_discount_plan', 'lims_customer_list', 'customer_ids');
    }

    /**
     * Update discount plan and sync customer relations.
     *
     * @param int|string $id
     * @param array $requestData
     * @return DiscountPlan
     */
    public function updateDiscountPlan($id, array $requestData): DiscountPlan
    {
        $data = $requestData;
        $discountPlan = $this->discountPlanRepository->findOrFail($id);
        if (!isset($data['is_active'])) {
            $data['is_active'] = 0;
        }

        $preCustomerIds = DiscountPlanCustomer::where('discount_plan_id', $id)->pluck('customer_id')->toArray();
        $newCustomerIds = $data['customer_id'] ?? [];

        // Delete previous customer relations if removed
        foreach ($preCustomerIds as $customerId) {
            if (!in_array($customerId, $newCustomerIds)) {
                DiscountPlanCustomer::where([
                    ['discount_plan_id', $id],
                    ['customer_id', $customerId]
                ])->delete();
            }
        }

        // Insert new customer relations
        foreach ($newCustomerIds as $customerId) {
            if (!in_array($customerId, $preCustomerIds)) {
                DiscountPlanCustomer::create([
                    'discount_plan_id' => $id,
                    'customer_id'      => $customerId,
                ]);
            }
        }

        $discountPlan->update($data);

        return $discountPlan;
    }
}
