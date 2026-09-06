<?php

namespace App\Http\Controllers;

use App\Http\Requests\Warehouse\StoreWarehouseRequest;
use App\Http\Requests\Warehouse\UpdateWarehouseRequest;
use App\Services\WarehouseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    protected WarehouseService $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
        $this->middleware('check_permission:warehouse-index|warehouse')->only('index');
        $this->middleware('check_permission:warehouse-add')->only(['create', 'store', 'importWarehouse']);
        $this->middleware('check_permission:warehouse-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:warehouse-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index()
    {
        $lims_warehouse_all = $this->warehouseService->getActiveWarehouses();
        $numberOfWarehouse = $this->warehouseService->countActiveWarehouses();

        return view('backend.warehouse.create', compact('lims_warehouse_all', 'numberOfWarehouse'));
    }

    public function store(StoreWarehouseRequest $request)
    {
        $this->warehouseService->createWarehouse($request->all());

        return redirect('warehouse')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        return $this->warehouseService->getWarehouseById($id);
    }

    public function update(UpdateWarehouseRequest $request, $id)
    {
        $this->warehouseService->updateWarehouse($request->warehouse_id, $request->all());

        return redirect('warehouse')->with('message', 'Data updated successfully');
    }

    public function importWarehouse(Request $request)
    {
        $upload = $request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        }

        $this->warehouseService->importWarehouses($upload);

        return redirect('warehouse')->with('message', 'Warehouse imported successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $warehouse_id = $request['warehouseIdArray'] ?? [];
        $this->warehouseService->deleteMultipleWarehouses($warehouse_id);

        return 'Warehouse deleted successfully!';
    }

    public function destroy($id)
    {
        $this->warehouseService->deleteWarehouse($id);

        return redirect('warehouse')->with('not_permitted', 'Data deleted successfully');
    }

    public function warehouseAll()
    {
        $html = $this->warehouseService->getWarehouseOptionsHtml(
            Auth::user()->role_id,
            Auth::user()->warehouse_id
        );

        return response()->json($html);
    }
}
