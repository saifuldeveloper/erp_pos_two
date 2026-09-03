<?php

namespace App\Repositories\Contracts;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active employees.
     *
     * @return Collection
     */
    public function getActiveEmployees(): Collection;

    /**
     * Count total active employees.
     *
     * @return int
     */
    public function countActiveEmployees(): int;
}
