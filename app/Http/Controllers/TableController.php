<?php

namespace App\Http\Controllers;

use App\Services\TableService;
use Illuminate\Http\Request;

class TableController extends Controller
{
    protected TableService $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    public function index()
    {
        $lims_table_all = $this->tableService->getActiveTables();
        return view('backend.table.index', compact('lims_table_all'));
    }

    public function store(Request $request)
    {
        $this->tableService->createTable($request->all());

        return redirect()->back()->with('message', 'Table created successfully');
    }

    public function update(Request $request, $id)
    {
        $this->tableService->updateTable($request->table_id, $request->all());

        return redirect()->back()->with('message', 'Table updated successfully');
    }

    public function destroy($id)
    {
        $this->tableService->deleteTable($id);

        return redirect()->back()->with('message', 'Table deleted successfully');
    }
}
