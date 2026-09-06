<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
        $this->middleware('check_permission:employees-index')->only('index');
        $this->middleware('check_permission:employees-add')->only(['create', 'store']);
        $this->middleware('check_permission:employees-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:employees-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index()
    {
        $indexData = $this->employeeService->getIndexData();
        return view('backend.employee.index', $indexData);
    }

    public function create()
    {
        $formData = $this->employeeService->getCreateFormData();
        return view('backend.employee.create', $formData);
    }

    public function store(StoreEmployeeRequest $request)
    {
        $result = $this->employeeService->createEmployee($request->all(), $request->file('image'));

        return redirect('employees')->with('message', $result['message']);
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        $this->employeeService->updateEmployee($request->employee_id, $request->all(), $request->file('image'));

        return redirect('employees')->with('message', 'Employee updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $employee_ids = $request['employeeIdArray'] ?? [];
        $this->employeeService->deleteMultipleEmployees($employee_ids);

        return 'Employee deleted successfully!';
    }

    public function destroy($id)
    {
        $this->employeeService->deleteEmployee($id);

        return redirect('employees')->with('not_permitted', 'Employee deleted successfully');
    }
}
