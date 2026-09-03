<?php

namespace App\Repositories\Contracts;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Collection;

interface WarehouseRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active warehouses.
     *
     * @return Collection
     */
    public function getActiveWarehouses(): Collection;

    /**
     * Get warehouses filtered by user role and warehouse assignment.
     *
     * @param int|null $roleId
     * @param int|null $warehouseId
     * @return Collection
     */
    public function getWarehousesForUser(?int $roleId = null, ?int $warehouseId = null): Collection;

    /**
     * Deactivate a warehouse (is_active = false).
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool;

    /**
     * Deactivate multiple warehouses by IDs.
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
     * @return Warehouse
     */
    public function firstOrNew(array $attributes, array $values = []): Warehouse;
}
