<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payroll\StorePayrollRequest;
use App\Http\Requests\Payroll\UpdatePayrollRequest;
use App\Models\Payroll;
use App\Services\PayrollService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class PayrollController extends Controller
{
    protected PayrollService $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('payroll-index') || $role->hasPermissionTo('payroll')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

            $indexData = $this->payrollService->getIndexData($request);
            $indexData['all_permission'] = $all_permission;

            return view('backend.payroll.index', $indexData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
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
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('payroll-delete')) {
            return 'Sorry! You are not allowed to delete payroll';
        }

        $payroll_ids = $request['payrollIdArray'] ?? [];
        $this->payrollService->deleteMultiplePayrolls($payroll_ids);

        return 'Payroll deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('payroll-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete payroll');
        }

        $this->payrollService->deletePayroll($id);

        return redirect('payroll')->with('not_permitted', 'Payroll deleted successfully');
    }
}
