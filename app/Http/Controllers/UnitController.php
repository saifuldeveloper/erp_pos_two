<?php

namespace App\Http\Controllers;

use App\Http\Requests\Unit\StoreUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Services\UnitService;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    protected UnitService $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
        $this->middleware('check_permission:unit-index|unit')->only(['index', 'limsUnitSearch']);
        $this->middleware('check_permission:unit-add')->only(['create', 'store', 'importUnit']);
        $this->middleware('check_permission:unit-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:unit-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index()
    {
        $lims_unit_all = $this->unitService->getActiveUnits();
        return view('backend.unit.create', compact('lims_unit_all'));
    }

    public function store(StoreUnitRequest $request)
    {
        $this->unitService->createUnit($request->all());

        return redirect('unit');
    }

    public function limsUnitSearch(Request $request)
    {
        $lims_unit_name = $request->query('lims_unitNameSearch', '');
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
        $unit_id = $request['unitIdArray'] ?? [];
        $this->unitService->deleteMultipleUnits($unit_id);

        return 'Unit deleted successfully!';
    }

    public function destroy($id)
    {
        $this->unitService->deleteUnit($id);

        return redirect('unit');
    }
}
