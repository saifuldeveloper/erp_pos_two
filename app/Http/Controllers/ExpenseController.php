<?php

namespace App\Http\Controllers;

use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Http\Requests\Expense\UpdateExpenseRequest;
use App\Models\Account;
use App\Models\Warehouse;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    protected ExpenseService $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
        $this->middleware('check_permission:expenses-index')->only(['index', 'expenseData']);
        $this->middleware('check_permission:expenses-add')->only(['create', 'store']);
        $this->middleware('check_permission:expenses-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:expenses-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index(Request $request)
    {
        if ($request->starting_date) {
            $starting_date = $request->starting_date;
            $ending_date = $request->ending_date;
        } else {
            $starting_date = date('Y-m-01', strtotime('-1 year', strtotime(date('Y-m-d'))));
            $ending_date = date("Y-m-d");
        }

        $warehouse_id = $request->input('warehouse_id', 0);

        $lims_warehouse_list = Warehouse::select('name', 'id')->where('is_active', true)->get();
        $lims_account_list = Account::where('is_active', true)->get();

        return view('backend.expense.index', compact('lims_account_list', 'lims_warehouse_list', 'starting_date', 'ending_date', 'warehouse_id'));
    }

    public function expenseData(Request $request)
    {
        $allPermissions = $request['all_permission'] ?? [];
        $jsonData = $this->expenseService->getExpenseDataTable($request, $allPermissions);

        return response()->json($jsonData);
    }

    public function store(StoreExpenseRequest $request)
    {
        $this->expenseService->createExpense($request->all());

        return redirect('expenses')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $lims_expense_data = $this->expenseService->getExpenseById($id);
        $lims_expense_data->date = date('d-m-Y', strtotime($lims_expense_data->created_at->toDateString()));
        return $lims_expense_data;
    }

    public function update(UpdateExpenseRequest $request, $id)
    {
        $this->expenseService->updateExpense($request->expense_id, $request->all());

        return redirect('expenses')->with('message', 'Data updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $expense_id = $request['expenseIdArray'] ?? [];
        $this->expenseService->deleteMultipleExpenses($expense_id);

        return 'Expense deleted successfully!';
    }

    public function destroy($id)
    {
        $this->expenseService->deleteExpense($id);

        return redirect('expenses')->with('not_permitted', 'Data deleted successfully');
    }
}
