<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class DepartmentController extends Controller
{
    protected DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('department-index') || $role->hasPermissionTo('department')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

            $lims_department_all = $this->departmentService->getActiveDepartments();
            return view('backend.department.index', compact('lims_department_all', 'all_permission'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(StoreDepartmentRequest $request)
    {
        $this->departmentService->createDepartment($request->all());

        return redirect('departments')->with('message', 'Department created successfully');
    }

    public function update(UpdateDepartmentRequest $request, $id)
    {
        $this->departmentService->updateDepartment($request->department_id, $request->all());

        return redirect('departments')->with('message', 'Department updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('department-delete')) {
            return 'Sorry! You are not allowed to delete department';
        }

        $department_ids = $request['departmentIdArray'] ?? [];
        $this->departmentService->deleteMultipleDepartments($department_ids);

        return 'Department deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('department-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete department');
        }

        $this->departmentService->deleteDepartment($id);

        return redirect('departments')->with('message', 'Department deleted successfully');
    }
}
