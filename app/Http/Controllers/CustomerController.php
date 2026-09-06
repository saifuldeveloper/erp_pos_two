<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\CustomField;
use App\Models\CustomerGroup;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
        $this->middleware('check_permission:customers-index')->only(['index', 'customerData']);
        $this->middleware('check_permission:customers-add')->only(['create', 'store', 'importCustomer', 'addDeposit']);
        $this->middleware('check_permission:customers-edit')->only(['edit', 'update', 'updateDeposit']);
        $this->middleware('check_permission:customers-delete')->only(['destroy', 'deleteBySelection', 'deleteDeposit']);
    }

    public function index()
    {
        $custom_fields = CustomField::where([
            ['belongs_to', 'customer'],
            ['is_table', true]
        ])->pluck('name');

        return view('backend.customer.index', compact('custom_fields'));
    }

    public function customerData(Request $request)
    {
        $allPermissions = $request->input('all_permission', []);
        $jsonData = $this->customerService->getCustomerDataTable($request, $allPermissions);

        return response()->json($jsonData);
    }

    public function clearDue(Request $request)
    {
        $this->customerService->clearDue(
            (int) $request->customer_id,
            (float) $request->amount,
            $request->note
        );

        return redirect()->back()->with('message', 'Due cleared successfully');
    }

    public function create()
    {
        $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
        $custom_fields = CustomField::where('belongs_to', 'customer')->get();
        return view('backend.customer.create', compact('lims_customer_group_all', 'custom_fields'));
    }

    public function store(StoreCustomerRequest $request)
    {
        $result = $this->customerService->createCustomer($request->all(), $request);
        $customer = $result['customer'];
        $message = $result['message'];

        if (!empty($request->pos)) {
            return [
                'id'           => $customer->id,
                'name'         => $customer->name,
                'phone_number' => $customer->phone_number,
            ];
        }

        return redirect('customer')->with('create_message', $message);
    }

    public function edit($id)
    {
        $lims_customer_data = $this->customerService->getCustomerById($id);
        $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
        $custom_fields = CustomField::where('belongs_to', 'customer')->get();
        return view('backend.customer.edit', compact('lims_customer_data', 'lims_customer_group_all', 'custom_fields'));
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        $result = $this->customerService->updateCustomer($id, $request->all(), $request);

        return redirect('customer')->with('edit_message', $result['message']);
    }

    public function importCustomer(Request $request)
    {
        $upload = $request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        }

        $message = $this->customerService->importCustomers($upload, $request);

        return redirect('customer')->with('import_message', $message);
    }

    public function getDeposit($id)
    {
        return $this->customerService->getDepositHistory($id);
    }

    public function addDeposit(Request $request)
    {
        $message = $this->customerService->addDeposit($request->all(), $request);
        return redirect('customer')->with('create_message', $message);
    }

    public function updateDeposit(Request $request)
    {
        $this->customerService->updateDeposit($request->all());
        return redirect('customer')->with('create_message', 'Data updated successfully');
    }

    public function deleteDeposit(Request $request)
    {
        $this->customerService->deleteDeposit($request->id);
        return redirect('customer')->with('not_permitted', 'Data deleted successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $customer_id = $request['customerIdArray'] ?? [];
        $this->customerService->deleteMultipleCustomers($customer_id);

        return 'Customer deleted successfully!';
    }

    public function destroy($id)
    {
        $this->customerService->deleteCustomer($id);

        return redirect('customer')->with('not_permitted', 'Data deleted Successfully');
    }

    public function customersAll()
    {
        $html = $this->customerService->getCustomerOptionsHtml();
        return response()->json($html);
    }
}
