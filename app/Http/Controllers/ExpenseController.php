<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Warehouse;
use App\Services\ExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ExpenseController extends Controller
{
    protected ExpenseService $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('expenses-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

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

            return view('backend.expense.index', compact('lims_account_list', 'lims_warehouse_list', 'all_permission', 'starting_date', 'ending_date', 'warehouse_id'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function expenseData(Request $request)
    {
        $allPermissions = $request['all_permission'] ?? [];
        $jsonData = $this->expenseService->getExpenseDataTable($request, $allPermissions);

        return response()->json($jsonData);
    }

    public function store(Request $request)
    {
        $this->expenseService->createExpense($request->all());

        return redirect('expenses')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $role = Role::firstOrCreate(['id' => Auth::user()->role_id]);
        if ($role->hasPermissionTo('expenses-edit')) {
            $lims_expense_data = $this->expenseService->getExpenseById($id);
            $lims_expense_data->date = date('d-m-Y', strtotime($lims_expense_data->created_at->toDateString()));
            return $lims_expense_data;
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $this->expenseService->updateExpense($request->expense_id, $request->all());

        return redirect('expenses')->with('message', 'Data updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('expenses-delete')) {
            return 'Sorry! You are not allowed to delete expense';
        }

        $expense_id = $request['expenseIdArray'] ?? [];
        $this->expenseService->deleteMultipleExpenses($expense_id);

        return 'Expense deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('expenses-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete expense');
        }

        $this->expenseService->deleteExpense($id);

        return redirect('expenses')->with('not_permitted', 'Data deleted successfully');
    }
}
