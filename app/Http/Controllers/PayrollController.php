<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payroll\StorePayrollRequest;
use App\Http\Requests\Payroll\UpdatePayrollRequest;
use App\Models\Payroll;
use App\Services\PayrollService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    protected PayrollService $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
        $this->middleware('check_permission:payroll-index|payroll')->only('index');
        $this->middleware('check_permission:payroll-add')->only(['create', 'store']);
        $this->middleware('check_permission:payroll-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:payroll-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index(Request $request)
    {
        $indexData = $this->payrollService->getIndexData($request);
        return view('backend.payroll.index', $indexData);
    }

    public function store(StorePayrollRequest $request)
    {
        $result = $this->payrollService->createPayroll($request->all());

        return redirect('payroll')->with('message', $result['message']);
    }

    public function edit($id)
    {
        return Payroll::find($id);
    }

    public function update(UpdatePayrollRequest $request, $id)
    {
        $this->payrollService->updatePayroll($request->payroll_id, $request->all());

        return redirect('payroll')->with('message', 'Payroll updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $payroll_ids = $request['payrollIdArray'] ?? [];
        $this->payrollService->deleteMultiplePayrolls($payroll_ids);

        return 'Payroll deleted successfully!';
    }

    public function destroy($id)
    {
        $this->payrollService->deletePayroll($id);

        return redirect('payroll')->with('not_permitted', 'Payroll deleted successfully');
    }
}
