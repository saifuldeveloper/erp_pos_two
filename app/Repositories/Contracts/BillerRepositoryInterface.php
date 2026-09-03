<?php

namespace App\Repositories\Contracts;

use App\Models\Biller;
use Illuminate\Database\Eloquent\Collection;

interface BillerRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active billers.
     *
     * @return Collection
     */
    public function getActiveBillers(): Collection;

    /**
     * Deactivate a biller.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool;

    /**
     * Deactivate multiple billers.
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
     * @return Biller
     */
    public function firstOrNew(array $attributes, array $values = []): Biller;
}
