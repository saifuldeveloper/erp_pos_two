<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomField\StoreCustomFieldRequest;
use App\Http\Requests\CustomField\UpdateCustomFieldRequest;
use App\Models\CustomField;
use App\Services\CustomFieldService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CustomFieldController extends Controller
{
    protected CustomFieldService $customFieldService;

    public function __construct(CustomFieldService $customFieldService)
    {
        $this->customFieldService = $customFieldService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('custom_field')) {
            $lims_custom_field_all = $this->customFieldService->getAllCustomFields();
            return view('backend.custom_field.index', compact('lims_custom_field_all'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('custom_field')) {
            return view('backend.custom_field.create');
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(StoreCustomFieldRequest $request)
    {
        $this->customFieldService->createCustomField($request->all());

        return redirect()->route('custom-fields.index')->with('message', 'Custom Field created successfully');
    }

    public function edit($id)
    {
        $lims_custom_field_data = CustomField::find($id);

        return view('backend.custom_field.edit', compact('lims_custom_field_data'));
    }

    public function update(UpdateCustomFieldRequest $request, $id)
    {
        $this->customFieldService->updateCustomField($id, $request->all());

        return redirect()->route('custom-fields.index')->with('message', 'Custom Field updated successfully');
    }

    public function destroy($id)
    {
        $this->customFieldService->deleteCustomField($id);

        return redirect()->route('custom-fields.index')->with('not_permitted', 'Custom Field deleted successfully');
    }
}
