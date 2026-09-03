<?php

namespace App\Repositories\Eloquent;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    /**
     * EmployeeRepository constructor.
     *
     * @param Employee $model
     */
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active employees.
     *
     * @return Collection
     */
    public function getActiveEmployees(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Count total active employees.
     *
     * @return int
     */
    public function countActiveEmployees(): int
    {
        return $this->model->where('is_active', true)->count();
    }
}
