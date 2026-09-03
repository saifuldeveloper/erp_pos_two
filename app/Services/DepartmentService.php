<?php

namespace App\Services;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DepartmentService
{
    protected DepartmentRepositoryInterface $departmentRepository;

    /**
     * DepartmentService constructor.
     *
     * @param DepartmentRepositoryInterface $departmentRepository
     */
    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * Get all active departments.
     *
     * @return Collection
     */
    public function getActiveDepartments(): Collection
    {
        return $this->departmentRepository->getActiveDepartments();
    }

    /**
     * Create a new department.
     *
     * @param array $requestData
     * @return Department
     */
    public function createDepartment(array $requestData): Department
    {
        $data = $requestData;
        $data['is_active'] = true;

        return $this->departmentRepository->create($data);
    }

    /**
     * Update an existing department.
     *
     * @param int|string $id
     * @param array $requestData
     * @return Department
     */
    public function updateDepartment($id, array $requestData): Department
    {
        $department = $this->departmentRepository->findOrFail($id);
        $department->update($requestData);

        return $department;
    }

    /**
     * Deactivate a department.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteDepartment($id): bool
    {
        $department = $this->departmentRepository->findOrFail($id);
        $department->is_active = false;

        return (bool) $department->save();
    }

    /**
     * Deactivate multiple departments.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleDepartments(array $ids): bool
    {
        foreach ($ids as $id) {
            $department = $this->departmentRepository->find($id);
            if ($department) {
                $department->is_active = false;
                $department->save();
            }
        }
        return true;
    }
}
