<?php

namespace App\Http\Controllers;

use App\Http\Requests\Unit\StoreUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Services\UnitService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Auth;

class UnitController extends Controller
{
    protected UnitService $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('unit-index') || $role->hasPermissionTo('unit')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }
            $lims_unit_all = $this->unitService->getActiveUnits();
            return view('backend.unit.create', compact('lims_unit_all', 'all_permission'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(StoreUnitRequest $request)
    {
        $this->unitService->createUnit($request->all());

        return redirect('unit');
    }

    public function limsUnitSearch()
    {
        $lims_unit_name = $_GET['lims_unitNameSearch'];
        $lims_unit_all = $this->unitService->searchUnitsByName($lims_unit_name, 5);
        $lims_unit_list = $this->unitService->getAllUnits();

        return view('backend.unit.create', compact('lims_unit_all', 'lims_unit_list'));
    }

    public function edit($id)
    {
        return $this->unitService->getUnitById($id);
    }

    public function update(UpdateUnitRequest $request, $id)
    {
        $this->unitService->updateUnit($request->unit_id, $request->all());

        return redirect('unit');
    }

    public function importUnit(Request $request)
    {
        $upload = $request->file('file');
        $this->unitService->importUnits($upload);

        return redirect('unit')->with('message', 'Unit imported successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('unit-delete')) {
            return 'Sorry! You are not allowed to delete unit';
        }

        $unit_id = $request['unitIdArray'];
        $this->unitService->deleteMultipleUnits($unit_id);

        return 'Unit deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('unit-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete unit');
        }

        $this->unitService->deleteUnit($id);

        return redirect('unit');
    }
}
