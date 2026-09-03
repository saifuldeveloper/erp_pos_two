<?php

namespace App\Http\Controllers;

use App\Services\WarehouseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class WarehouseController extends Controller
{
    protected WarehouseService $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('warehouse-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }
            $lims_warehouse_all = $this->warehouseService->getActiveWarehouses();
            $numberOfWarehouse = $this->warehouseService->countActiveWarehouses();

            return view('backend.warehouse.create', compact('lims_warehouse_all', 'numberOfWarehouse', 'all_permission'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('warehouse-add')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to create warehouse');
        }

        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('warehouses')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $this->warehouseService->createWarehouse($request->all());

        return redirect('warehouse')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('warehouse-edit')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $this->warehouseService->getWarehouseById($id);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('warehouse-edit')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to edit warehouse');
        }

        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('warehouses')->ignore($request->warehouse_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $this->warehouseService->updateWarehouse($request->warehouse_id, $request->all());

        return redirect('warehouse')->with('message', 'Data updated successfully');
    }

    public function importWarehouse(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('warehouse-add')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to import warehouse');
        }

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
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('warehouse-delete')) {
            return 'You are not allowed to delete warehouse';
        }

        $warehouse_id = $request['warehouseIdArray'];
        $this->warehouseService->deleteMultipleWarehouses($warehouse_id);

        return 'Warehouse deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('warehouse-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete warehouse');
        }

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
