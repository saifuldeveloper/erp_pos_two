<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerGroup\StoreCustomerGroupRequest;
use App\Http\Requests\CustomerGroup\UpdateCustomerGroupRequest;
use App\Services\CustomerGroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerGroupController extends Controller
{
    protected CustomerGroupService $customerGroupService;

    public function __construct(CustomerGroupService $customerGroupService)
    {
        $this->customerGroupService = $customerGroupService;
        $this->middleware('check_permission:customer_group')->only(['index', 'create', 'store', 'edit', 'update', 'importCustomerGroup', 'exportCustomerGroup']);
    }

    public function index()
    {
        $lims_customer_group_all = $this->customerGroupService->getActiveCustomerGroups();
        return view('backend.customer_group.create', compact('lims_customer_group_all'));
    }

    public function store(StoreCustomerGroupRequest $request)
    {
        $this->customerGroupService->createCustomerGroup($request->all());

        return redirect('customer_group')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        return $this->customerGroupService->getCustomerGroupById($id);
    }

    public function update(UpdateCustomerGroupRequest $request, $id)
    {
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
        if (Auth::user()->role_id > 2) {
            return 'Sorry! You are not allowed to delete customer group';
        }

        $customer_group_id = $request['customer_groupIdArray'] ?? [];
        $this->customerGroupService->deleteMultipleCustomerGroups($customer_group_id);

        return 'Customer Group deleted successfully!';
    }

    public function destroy($id)
    {
        if (Auth::user()->role_id > 2) {
            return redirect('customer_group')->with('not_permitted', 'Sorry! You are not allowed to delete customer group');
        }

        $this->customerGroupService->deleteCustomerGroup($id);

        return redirect('customer_group')->with('not_permitted', 'Data deleted successfully');
    }

    public function customerGroupAll()
    {
        $html = $this->customerGroupService->getCustomerGroupOptionsHtml();
        return response()->json($html);
    }
}
