<?php

namespace App\Repositories\Contracts;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active customers.
     *
     * @return Collection
     */
    public function getActiveCustomers(): Collection;

    /**
     * Count total active customers.
     *
     * @return int
     */
    public function countTotalActiveCustomers(): int;

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
    public function getFilteredCustomersForDataTable(int $start, int $limit, string $order, string $dir, ?string $searchValue = null): Collection;

    /**
     * Count filtered customers for DataTables.
     *
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredCustomersForDataTable(?string $searchValue = null): int;

    /**
     * Deactivate a customer.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool;

    /**
     * Deactivate multiple customers.
     *
     * @param array $ids
     * @return bool
     */
    public function deactivateMultiple(array $ids): bool;

    /**
     * Get the first record matching attributes or instantiate it.
     *
     * @param array $attributes
     * @param array $values
     * @return Customer
     */
    public function firstOrNew(array $attributes, array $values = []): Customer;
}
