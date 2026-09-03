<?php

namespace App\Repositories\Contracts;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UnitRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active units.
     *
     * @return Collection
     */
    public function getActiveUnits(): Collection;

    /**
     * Find a unit by unit_code.
     *
     * @param string $unitCode
     * @return Unit|null
     */
    public function findByUnitCode(string $unitCode): ?Unit;

    /**
     * Search units by unit name with pagination.
     *
     * @param string $name
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchByNamePaginated(string $name, int $perPage = 5): LengthAwarePaginator;

    /**
     * Deactivate a unit (is_active = false).
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool;

    /**
     * Deactivate multiple units by IDs.
     *
     * @param array $ids
     * @return bool
     */
    public function deactivateMultiple(array $ids): bool;

    /**
     * Get first record matching attributes or instantiate new model.
     *
     * @param array $attributes
     * @param array $values
     * @return Unit
     */
    public function firstOrNew(array $attributes, array $values = []): Unit;
}
