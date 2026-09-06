<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayrollType\StorePayrollTypeRequest;
use App\Http\Requests\PayrollType\UpdatePayrollTypeRequest;
use App\Services\PayrollTypeService;
use Illuminate\Http\Request;

class PayrollTypeController extends Controller
{
    protected PayrollTypeService $payrollTypeService;

    public function __construct(PayrollTypeService $payrollTypeService)
    {
        $this->payrollTypeService = $payrollTypeService;
        $this->middleware('check_permission:payroll-type-index|payroll')->only('index');
        $this->middleware('check_permission:payroll-type-add|payroll')->only(['create', 'store']);
        $this->middleware('check_permission:payroll-type-edit|payroll')->only(['edit', 'update']);
        $this->middleware('check_permission:payroll-type-delete|payroll')->only('destroy');
    }

    public function index()
    {
        $payrollTypes = $this->payrollTypeService->getAllPayrollTypes();
        return view('backend.payroll-type.index', compact('payrollTypes'));
    }

    public function store(StorePayrollTypeRequest $request)
    {
        $this->payrollTypeService->createPayrollType($request->all());

        return redirect()->route('payroll-types.index')->with('success', 'Payroll Type created successfully.');
    }

    public function update(UpdatePayrollTypeRequest $request, string $id)
    {
        $this->payrollTypeService->updatePayrollType($id, $request->all());

        return redirect()->route('payroll-types.index')->with('success', 'Payroll Type updated successfully.');
    }

    public function destroy(string $id)
    {
        $this->payrollTypeService->deletePayrollType($id);

        return redirect()->route('payroll-types.index')->with('success', 'Payroll Type deleted successfully.');
    }
}
