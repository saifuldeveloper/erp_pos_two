<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Models\Account;
use App\Models\CustomerGroup;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
        $this->middleware('check_permission:suppliers-index')->only(['index', 'dueClearList']);
        $this->middleware('check_permission:suppliers-add')->only(['create', 'store', 'importSupplier', 'clearDue']);
        $this->middleware('check_permission:suppliers-edit')->only(['edit', 'update', 'clearDueUpdate']);
        $this->middleware('check_permission:suppliers-delete')->only(['destroy', 'deleteBySelection', 'clearDueDelete']);
    }

    public function index()
    {
        $lims_supplier_all = $this->supplierService->getActiveSuppliers();
        $lims_accounts = Account::where('is_active', true)->get();

        return view('backend.supplier.index', compact('lims_supplier_all', 'lims_accounts'));
    }

    public function clearDue(Request $request)
    {
        $this->supplierService->clearDue(
            (int) $request->supplier_id,
            (int) $request->account_id,
            (float) $request->amount,
            $request->note,
            $request->created_at
        );

        return redirect()->back()->with('message', 'Due cleared successfully');
    }

    public function dueClearList(Request $request, $supplier_id)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $lims_supplier_due_list = $this->supplierService->getDueClearList($supplier_id, $start_date, $end_date);
        $lims_accounts = Account::where('is_active', true)->get();
        $lims_supplier = $this->supplierService->getSupplierById($supplier_id);

        return view('backend.supplier.due_clear_list', compact('lims_supplier_due_list', 'lims_accounts', 'lims_supplier', 'start_date', 'end_date'));
    }

    public function clearDueUpdate(Request $request, $id)
    {
        $lims_supplier_due = $this->supplierService->updateClearDue($id, $request->all());

        return redirect('suppliers/dueClear-list/' . $lims_supplier_due->supplier_id)->with('message', 'Due cleared updated successfully');
    }

    public function clearDueDelete($id)
    {
        $this->supplierService->deleteClearDue($id);

        return redirect()->back()->with('message', 'Due cleared deleted successfully');
    }

    public function create()
    {
        $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
        return view('backend.supplier.create', compact('lims_customer_group_all'));
    }

    public function store(StoreSupplierRequest $request)
    {
        $result = $this->supplierService->createSupplier($request->all(), $request->file('image'), $request);

        return redirect('supplier')->with('message', $result['message']);
    }

    public function edit($id)
    {
        $lims_supplier_data = $this->supplierService->getSupplierById($id);
        return view('backend.supplier.edit', compact('lims_supplier_data'));
    }

    public function update(UpdateSupplierRequest $request, $id)
    {
        $this->supplierService->updateSupplier($id, $request->all(), $request->file('image'));

        return redirect('supplier')->with('message', 'Data updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $supplier_id = $request['supplierIdArray'] ?? [];
        $this->supplierService->deleteMultipleSuppliers($supplier_id);

        return 'Supplier deleted successfully!';
    }

    public function destroy($id)
    {
        $this->supplierService->deleteSupplier($id);

        return redirect('supplier')->with('not_permitted', 'Data deleted successfully');
    }

    public function importSupplier(Request $request)
    {
        $upload = $request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        }

        $this->supplierService->importSuppliers($upload);

        return redirect('supplier')->with('message', 'Supplier Imported Successfully');
    }

    public function suppliersAll()
    {
        $html = $this->supplierService->getSupplierOptionsHtml();
        return response()->json($html);
    }
}
