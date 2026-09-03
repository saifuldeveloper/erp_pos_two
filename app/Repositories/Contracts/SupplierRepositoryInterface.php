<?php

namespace App\Repositories\Contracts;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;

interface SupplierRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active suppliers.
     *
     * @return Collection
     */
    public function getActiveSuppliers(): Collection;

    /**
     * Count total active suppliers.
     *
     * @return int
     */
    public function countTotalActiveSuppliers(): int;

    /**
     * Deactivate a supplier.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool;

    /**
     * Deactivate multiple suppliers.
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
     * @return Supplier
     */
    public function firstOrNew(array $attributes, array $values = []): Supplier;
}
