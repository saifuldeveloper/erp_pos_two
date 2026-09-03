<?php

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    /**
     * CustomerRepository constructor.
     *
     * @param Customer $model
     */
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active customers.
     *
     * @return Collection
     */
    public function getActiveCustomers(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Count total active customers.
     *
     * @return int
     */
    public function countTotalActiveCustomers(): int
    {
        return $this->model->where('is_active', true)->count();
    }

    /**
     * Get filtered customers for DataTables.
     *
     * @param int $start
     * @param int $limit
     * @param string $order
     * @param string $dir
     * @param string|null $searchValue
     * @return Collection
     */
    public function getFilteredCustomersForDataTable(int $start, int $limit, string $order, string $dir, ?string $searchValue = null): Collection
    {
        $q = $this->model->with('customerGroup', 'discountPlans')
            ->where('is_active', true);

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue) {
                $query->where('name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('company_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('email', 'LIKE', "%{$searchValue}%")
                    ->orWhere('phone_number', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }

    /**
     * Count filtered customers for DataTables.
     *
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredCustomersForDataTable(?string $searchValue = null): int
    {
        $q = $this->model->where('is_active', true);

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue) {
                $query->where('name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('company_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('email', 'LIKE', "%{$searchValue}%")
                    ->orWhere('phone_number', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->count();
    }

    /**
     * Deactivate a customer.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool
    {
        $customer = $this->find($id);
        if ($customer) {
            $customer->is_active = false;
            return (bool) $customer->save();
        }
        return false;
    }

    /**
     * Deactivate multiple customers.
     *
     * @param array $ids
     * @return bool
     */
    public function deactivateMultiple(array $ids): bool
    {
        return (bool) $this->model->whereIn('id', $ids)->update(['is_active' => false]);
    }

    /**
     * Get the first record matching attributes or instantiate it.
     *
     * @param array $attributes
     * @param array $values
     * @return Customer
     */
    public function firstOrNew(array $attributes, array $values = []): Customer
    {
        return $this->model->firstOrNew($attributes, $values);
    }
}
