<?php

namespace App\Services;

use App\Models\Biller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use App\Models\Warehouse;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Traits\TenantInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class EmployeeService
{
    use TenantInfo;

    protected EmployeeRepositoryInterface $employeeRepository;

    /**
     * EmployeeService constructor.
     *
     * @param EmployeeRepositoryInterface $employeeRepository
     */
    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Get all active employees.
     *
     * @return Collection
     */
    public function getActiveEmployees(): Collection
    {
        return $this->employeeRepository->getActiveEmployees();
    }

    /**
     * Get data required for employee index view.
     *
     * @return array
     */
    public function getIndexData(): array
    {
        $lims_employee_all = $this->employeeRepository->getActiveEmployees();
        $lims_department_list = Department::where('is_active', true)->get();
        $numberOfEmployee = $this->employeeRepository->countActiveEmployees();

        return compact('lims_employee_all', 'lims_department_list', 'numberOfEmployee');
    }

    /**
     * Get data required for create employee view.
     *
     * @return array
     */
    public function getCreateFormData(): array
    {
        $lims_role_list = Role::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_biller_list = Biller::where('is_active', true)->get();
        $lims_department_list = Department::where('is_active', true)->get();
        $numberOfEmployee = $this->employeeRepository->countActiveEmployees();
        $numberOfUserAccount = User::where('is_active', true)->count();

        return compact(
            'lims_role_list',
            'lims_warehouse_list',
            'lims_biller_list',
            'lims_department_list',
            'numberOfEmployee',
            'numberOfUserAccount'
        );
    }

    /**
     * Create employee and optional linked user account.
     *
     * @param array $requestData
     * @param UploadedFile|null $image
     * @return array
     */
    public function createEmployee(array $requestData, ?UploadedFile $image): array
    {
        $data = $requestData;
        $message = 'Employee created successfully';

        if (isset($data['user'])) {
            $data['is_active'] = true;
            $data['is_deleted'] = false;
            $data['password'] = bcrypt($data['password']);
            $data['phone'] = $data['phone_number'];

            $user = User::create($data);
            $data['user_id'] = $user->id;
            $message = 'Employee created successfully and added to user list';
        }

        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $imageName = $imageName . '.' . $ext;
                $image->move(public_path('images/employee'), $imageName);
            } else {
                $imageName = $this->getTenantId() . '_' . $imageName . '.' . $ext;
                $image->move(public_path('images/employee'), $imageName);
            }
            $data['image'] = $imageName;
        }

        $data['is_active'] = true;
        $employee = $this->employeeRepository->create($data);

        return ['employee' => $employee, 'message' => $message];
    }

    /**
     * Update employee.
     *
     * @param int|string $id
     * @param array $requestData
     * @param UploadedFile|null $image
     * @return Employee
     */
    public function updateEmployee($id, array $requestData, ?UploadedFile $image): Employee
    {
        $data = $requestData;
        $employee = $this->employeeRepository->findOrFail($id);

        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $imageName = $imageName . '.' . $ext;
                $image->move(public_path('images/employee'), $imageName);
            } else {
                $imageName = $this->getTenantId() . '_' . $imageName . '.' . $ext;
                $image->move(public_path('images/employee'), $imageName);
            }
            $data['image'] = $imageName;
        }

        $employee->update($data);

        return $employee;
    }

    /**
     * Deactivate an employee and linked user.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteEmployee($id): bool
    {
        $employee = $this->employeeRepository->findOrFail($id);
        $employee->is_active = false;
        $employee->save();

        if ($employee->user_id) {
            $user = User::find($employee->user_id);
            if ($user) {
                $user->is_deleted = true;
                $user->is_active = false;
                $user->save();
            }
        }

        return true;
    }

    /**
     * Deactivate multiple employees.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleEmployees(array $ids): bool
    {
        foreach ($ids as $id) {
            $this->deleteEmployee($id);
        }
        return true;
    }
}
