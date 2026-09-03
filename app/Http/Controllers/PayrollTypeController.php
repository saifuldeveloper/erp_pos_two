<?php

namespace App\Http\Controllers;

use App\Models\PayrollType;
use App\Services\PayrollTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class PayrollTypeController extends Controller
{
    protected PayrollTypeService $payrollTypeService;

    public function __construct(PayrollTypeService $payrollTypeService)
    {
        $this->payrollTypeService = $payrollTypeService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('payroll-type-index') || $role->hasPermissionTo('payroll')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

            $payrollTypes = $this->payrollTypeService->getAllPayrollTypes();
            return view('backend.payroll-type.index', compact('payrollTypes', 'all_permission'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $request->merge([
            'slug' => Str::slug($request->name),
        ]);
        $request->validate([
            'name'   => 'required|string|max:255|unique:payroll_types,name',
            'slug'   => 'required|string|max:255|unique:payroll_types,slug',
            'status' => 'required|in:Active,Inactive',
        ]);

        $this->payrollTypeService->createPayrollType($request->all());

        return redirect()->route('payroll-types.index')->with('success', 'Payroll Type created successfully.');
    }

    public function update(Request $request, string $id)
    {
        $payrollType = PayrollType::findOrFail($id);
        $request->merge([
            'slug' => Str::slug($request->name),
        ]);
        $request->validate([
            'name'   => 'required|string|max:255|unique:payroll_types,name,' . $payrollType->id,
            'slug'   => 'required|string|max:255|unique:payroll_types,slug,' . $payrollType->id,
            'status' => 'required|in:Active,Inactive',
        ]);

        $this->payrollTypeService->updatePayrollType($id, $request->all());

        return redirect()->route('payroll-types.index')->with('success', 'Payroll Type updated successfully.');
    }

    public function destroy(string $id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('payroll-type-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete payroll type');
        }

        $this->payrollTypeService->deletePayrollType($id);

        return redirect()->route('payroll-types.index')->with('success', 'Payroll Type deleted successfully.');
    }
}
