<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ColorRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Delete multiple colors by IDs.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultiple(array $ids): bool;

    /**
     * Update product variant values, product variants item code, and variant names when color name changes.
     *
     * @param Model $color
     * @param string $newColorName
     * @return void
     */
    public function updateColorRelations(Model $color, string $newColorName): void;
}
