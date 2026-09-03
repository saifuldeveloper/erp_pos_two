<?php

namespace App\Http\Controllers;

use App\Models\Biller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use App\Models\Warehouse;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    protected EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('employees-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

            $indexData = $this->employeeService->getIndexData();
            $lims_employee_all = $indexData['lims_employee_all'];
            $lims_department_list = $indexData['lims_department_list'];
            $numberOfEmployee = $indexData['numberOfEmployee'];

            return view('backend.employee.index', compact('lims_employee_all', 'lims_department_list', 'all_permission', 'numberOfEmployee'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('employees-add')) {
            $formData = $this->employeeService->getCreateFormData();
            return view('backend.employee.create', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $data = $request->except('image');
        if (isset($data['user'])) {
            $this->validate($request, [
                'name' => [
                    'max:255',
                    Rule::unique('users')->where(function ($query) {
                        return $query->where('is_deleted', false);
                    }),
                ],
                'email' => [
                    'email',
                    'max:255',
                    Rule::unique('users')->where(function ($query) {
                        return $query->where('is_deleted', false);
                    }),
                ],
            ]);
        }

        $this->validate($request, [
            'email' => [
                'max:255',
                Rule::unique('employees')->where(function ($query) {
                    return $query->where('is_active', true);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

        $result = $this->employeeService->createEmployee($request->all(), $request->file('image'));

        return redirect('employees')->with('message', $result['message']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => [
                'email',
                'max:255',
                Rule::unique('employees')->ignore($request->employee_id)->where(function ($query) {
                    return $query->where('is_active', true);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

        $this->employeeService->updateEmployee($request->employee_id, $request->all(), $request->file('image'));

        return redirect('employees')->with('message', 'Employee updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('employees-delete')) {
            return 'Sorry! You are not allowed to delete employee';
        }

        $employee_ids = $request['employeeIdArray'] ?? [];
        $this->employeeService->deleteMultipleEmployees($employee_ids);

        return 'Employee deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('employees-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete employee');
        }

        $this->employeeService->deleteEmployee($id);

        return redirect('employees')->with('not_permitted', 'Employee deleted successfully');
    }
}
