<?php

namespace App\Repositories\Contracts;

use App\Models\Table;
use Illuminate\Database\Eloquent\Collection;

interface TableRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active restaurant tables.
     *
     * @return Collection
     */
    public function getActiveTables(): Collection;
}
