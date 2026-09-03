<?php

namespace App\Repositories\Contracts;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BrandRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active brands.
     *
     * @return Collection
     */
    public function getActiveBrands(): Collection;

    /**
     * Get brands by an array of IDs.
     *
     * @param array $ids
     * @return Collection
     */
    public function getByIds(array $ids): Collection;

    /**
     * Deactivate a brand by setting is_active = false.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool;

    /**
     * Deactivate multiple brands by IDs.
     *
     * @param array $ids
     * @return bool
     */
    public function deactivateMultiple(array $ids): bool;

    /**
     * Get the first record matching attributes or create it.
     *
     * @param array $attributes
     * @param array $values
     * @return Model
     */
    public function firstOrCreate(array $attributes, array $values = []): Model;
}
