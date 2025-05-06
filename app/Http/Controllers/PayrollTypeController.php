<?php

namespace App\Http\Controllers;

use App\Models\PayrollType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PayrollTypeController extends Controller
{
    public function index()
    {
        $payrollTypes = PayrollType::all();
        return view('backend.payroll-type.index', compact('payrollTypes'));
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
        $payrollType = PayrollType::findOrFail($id);
        $payrollType->delete();

        return redirect()->route('payroll-types.index')->with('success', 'Payroll Type deleted successfully.');
    }
}
