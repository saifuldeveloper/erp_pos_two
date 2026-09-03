<?php

namespace App\Http\Controllers;

use App\Services\CustomerGroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class CustomerGroupController extends Controller
{
    protected CustomerGroupService $customerGroupService;

    public function __construct(CustomerGroupService $customerGroupService)
    {
        $this->customerGroupService = $customerGroupService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('customer_group')) {
            $lims_customer_group_all = $this->customerGroupService->getActiveCustomerGroups();
            return view('backend.customer_group.create', compact('lims_customer_group_all'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('customer_groups')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $this->customerGroupService->createCustomerGroup($request->all());

        return redirect('customer_group')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        return $this->customerGroupService->getCustomerGroupById($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('customer_groups')->ignore($request->customer_group_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $this->customerGroupService->updateCustomerGroup($request->customer_group_id, $request->all());

        return redirect('customer_group')->with('message', 'Data updated successfully');
    }

    public function importCustomerGroup(Request $request)
    {
        $upload = $request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        }

        $this->customerGroupService->importCustomerGroups($upload);

        return redirect('customer_group')->with('message', 'Customer Group imported successfully');
    }

    public function exportCustomerGroup(Request $request)
    {
        $customerGroupArray = $request['customer_groupArray'] ?? [];
        return $this->customerGroupService->exportCustomerGroups($customerGroupArray);
    }

    public function deleteBySelection(Request $request)
    {
        $customer_group_id = $request['customer_groupIdArray'] ?? [];
        $this->customerGroupService->deleteMultipleCustomerGroups($customer_group_id);

        return 'Customer Group deleted successfully!';
    }

    public function destroy($id)
    {
        $this->customerGroupService->deleteCustomerGroup($id);

        return redirect('customer_group')->with('not_permitted', 'Data deleted successfully');
    }

    public function customerGroupAll()
    {
        $html = $this->customerGroupService->getCustomerGroupOptionsHtml();
        return response()->json($html);
    }
}
