<?php

namespace App\Repositories\Contracts;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

interface DepartmentRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active departments.
     *
     * @return Collection
     */
    public function getActiveDepartments(): Collection;
}
