<?php

namespace App\Repositories\Contracts;

use App\Models\Tax;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaxRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active taxes.
     *
     * @return Collection
     */
    public function getActiveTaxes(): Collection;

    /**
     * Search taxes by name with pagination.
     *
     * @param string $name
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchByNamePaginated(string $name, int $perPage = 5): LengthAwarePaginator;

    /**
     * Deactivate a tax (is_active = false).
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool;

    /**
     * Deactivate multiple taxes by IDs.
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
     * @return Tax
     */
    public function firstOrNew(array $attributes, array $values = []): Tax;
}
