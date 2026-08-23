<?php

namespace App\Http\Controllers;

use App\Models\PayrollType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Auth;

class PayrollTypeController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('payroll-type-index') || $role->hasPermissionTo('payroll')) {
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $payrollTypes = PayrollType::all();
            return view('backend.payroll-type.index', compact('payrollTypes', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $request->merge([
            'slug' => Str::slug($request->name),
        ]);
        $request->validate([
            'name' => 'required|string|max:255|unique:payroll_types,name',
            'slug' => 'required|string|max:255|unique:payroll_types,slug',
            'status' => 'required|in:Active,Inactive',
        ]);

        PayrollType::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
        ]);

        return redirect()->route('payroll-types.index')->with('success', 'Payroll Type created successfully.');
    }

    public function update(Request $request, string $id)
    {
        $payrollType = PayrollType::findOrFail($id);
        $request->merge([
            'slug' => Str::slug($request->name),
        ]);
        $request->validate([
            'name' => 'required|string|max:255|unique:payroll_types,name,' . $payrollType->id,
            'slug' => 'required|string|max:255|unique:payroll_types,slug,' . $payrollType->id,
            'status' => 'required|in:Active,Inactive',
        ]);

        $payrollType->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
        ]);

        return redirect()->route('payroll-types.index')->with('success', 'Payroll Type updated successfully.');
    }

    public function destroy(string $id)
    {
        $role = Role::find(Auth::user()->role_id);
        if(!$role->hasPermissionTo('payroll-type-delete'))
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete payroll type');

        $payrollType = PayrollType::findOrFail($id);
        $payrollType->delete();

        return redirect()->route('payroll-types.index')->with('success', 'Payroll Type deleted successfully.');
    }
}
