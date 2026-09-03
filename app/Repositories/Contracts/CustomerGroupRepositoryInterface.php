<?php

namespace App\Repositories\Contracts;

use App\Models\CustomerGroup;
use Illuminate\Database\Eloquent\Collection;

interface CustomerGroupRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active customer groups.
     *
     * @return Collection
     */
    public function getActiveCustomerGroups(): Collection;

    /**
     * Deactivate a customer group.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool;

    /**
     * Deactivate multiple customer groups.
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
     * @return CustomerGroup
     */
    public function firstOrNew(array $attributes, array $values = []): CustomerGroup;
}
