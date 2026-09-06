<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
        $this->middleware('check_permission:department-index|department')->only('index');
        $this->middleware('check_permission:department-add')->only(['create', 'store']);
        $this->middleware('check_permission:department-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:department-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index()
    {
        $lims_department_all = $this->departmentService->getActiveDepartments();
        return view('backend.department.index', compact('lims_department_all'));
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
        $department_ids = $request['departmentIdArray'] ?? [];
        $this->departmentService->deleteMultipleDepartments($department_ids);

        return 'Department deleted successfully!';
    }

    public function destroy($id)
    {
        $this->departmentService->deleteDepartment($id);

        return redirect('departments')->with('message', 'Department deleted successfully');
    }
}
