<?php

namespace App\Repositories\Contracts;

use App\Models\CustomField;
use Illuminate\Database\Eloquent\Collection;

interface CustomFieldRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all custom fields ordered by ID descending.
     *
     * @return Collection
     */
    public function getAllOrdered(): Collection;
}
