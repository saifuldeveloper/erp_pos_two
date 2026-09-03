<?php

namespace App\Repositories\Eloquent;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    /**
     * DepartmentRepository constructor.
     *
     * @param Department $model
     */
    public function __construct(Department $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active departments.
     *
     * @return Collection
     */
    public function getActiveDepartments(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }
}
