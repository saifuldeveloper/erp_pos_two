<?php

namespace App\Services;

use App\Models\PayrollType;
use App\Repositories\Contracts\PayrollTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class PayrollTypeService
{
    protected PayrollTypeRepositoryInterface $payrollTypeRepository;

    /**
     * PayrollTypeService constructor.
     *
     * @param PayrollTypeRepositoryInterface $payrollTypeRepository
     */
    public function __construct(PayrollTypeRepositoryInterface $payrollTypeRepository)
    {
        $this->payrollTypeRepository = $payrollTypeRepository;
    }

    /**
     * Get all payroll types.
     *
     * @return Collection
     */
    public function getAllPayrollTypes(): Collection
    {
        return $this->payrollTypeRepository->all();
    }

    /**
     * Get active payroll types.
     *
     * @return Collection
     */
    public function getActivePayrollTypes(): Collection
    {
        return $this->payrollTypeRepository->getActivePayrollTypes();
    }

    /**
     * Create a payroll type.
     *
     * @param array $requestData
     * @return PayrollType
     */
    public function createPayrollType(array $requestData): PayrollType
    {
        $data = $requestData;
        $data['slug'] = Str::slug($data['name']);

        return $this->payrollTypeRepository->create($data);
    }

    /**
     * Update a payroll type.
     *
     * @param int|string $id
     * @param array $requestData
     * @return PayrollType
     */
    public function updatePayrollType($id, array $requestData): PayrollType
    {
        $payrollType = $this->payrollTypeRepository->findOrFail($id);
        $data = $requestData;
        $data['slug'] = Str::slug($data['name']);
        $payrollType->update($data);

        return $payrollType;
    }

    /**
     * Delete a payroll type.
     *
     * @param int|string $id
     * @return bool
     */
    public function deletePayrollType($id): bool
    {
        return $this->payrollTypeRepository->delete($id);
    }
}
