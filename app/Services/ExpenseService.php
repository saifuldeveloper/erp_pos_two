<?php

namespace App\Services;

use App\Models\CashRegister;
use App\Models\Expense;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseService
{
    protected ExpenseRepositoryInterface $expenseRepository;

    /**
     * ExpenseService constructor.
     *
     * @param ExpenseRepositoryInterface $expenseRepository
     */
    public function __construct(ExpenseRepositoryInterface $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    /**
     * Get expense by ID.
     *
     * @param int|string $id
     * @return Expense
     */
    public function getExpenseById($id): Expense
    {
        return $this->expenseRepository->findOrFail($id);
    }

    /**
     * Process DataTables server-side response for expense list.
     *
     * @param Request $request
     * @param array $allPermissions
     * @return array
     */
    public function getExpenseDataTable(Request $request, array $allPermissions): array
    {
        $columns = [
            1 => 'created_at',
            2 => 'reference_no',
        ];

        $filters = [
            'starting_date'       => $request->input('starting_date'),
            'ending_date'         => $request->input('ending_date'),
            'expense_category_id' => $request->input('expense_category_id') ?? 0,
            'warehouse_id'        => $request->input('warehouse_id'),
        ];

        $totalData = $this->expenseRepository->countTotalExpenses($filters);
        $limit = ($request->input('length') != -1) ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $orderColumn = $request->input('order.0.column');
        $order = 'expenses.' . ($columns[$orderColumn] ?? 'created_at');
        $dir = $request->input('order.0.dir') ?? 'desc';
        $searchValue = $request->input('search.value');

        $expenses = $this->expenseRepository->getFilteredExpensesForDataTable($start, $limit, $order, $dir, $filters, $searchValue);
        $totalFiltered = $this->expenseRepository->countFilteredExpensesForDataTable($filters, $searchValue);

        $data = [];
        foreach ($expenses as $key => $expense) {
            $nestedData = [];
            $nestedData['id'] = $expense->id;
            $nestedData['key'] = $key;
            $nestedData['date'] = date(config('date_format') . ' (h:i A)', strtotime($expense->created_at));
            $nestedData['reference_no'] = $expense->reference_no;
            $nestedData['warehouse'] = $expense->warehouse ? $expense->warehouse->name : 'N/A';
            $nestedData['expenseCategory'] = $expense->expenseCategory ? $expense->expenseCategory->name : 'N/A';
            $nestedData['amount'] = number_format((float) $expense->amount, (int) (config('decimal') ?: 2));
            $nestedData['note'] = $expense->note;

            $options = '<div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . trans("file.action") . '
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">';

            if (in_array("expenses-edit", $allPermissions)) {
                $options .= '<li>
                    <button type="button" data-id="' . $expense->id . '" class="open-Editexpense_categoryDialog btn btn-link" data-toggle="modal" data-target="#editModal"><i class="dripicons-document-edit"></i>' . trans('file.edit') . '</button>
                    </li>';
            }

            if (in_array("expenses-delete", $allPermissions)) {
                $options .= \Form::open(["route" => ["expenses.destroy", $expense->id], "method" => "DELETE"]) . '
                        <li>
                          <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> ' . trans("file.delete") . '</button>
                        </li>' . \Form::close() . '
                    </ul>
                </div>';
            } else {
                $options .= '</ul></div>';
            }

            $nestedData['options'] = $options;
            $data[] = $nestedData;
        }

        return [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];
    }

    /**
     * Create a new expense.
     *
     * @param array $requestData
     * @return Expense
     */
    public function createExpense(array $requestData): Expense
    {
        $data = $requestData;
        if (isset($data['created_at'])) {
            $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
        } else {
            $data['created_at'] = date("Y-m-d H:i:s");
        }

        $data['reference_no'] = 'er-' . date("Ymd") . '-' . date("his");
        $data['user_id'] = Auth::id();

        $cashRegister = CashRegister::where([
            ['user_id', $data['user_id']],
            ['warehouse_id', $data['warehouse_id']],
            ['status', true]
        ])->first();

        if ($cashRegister) {
            $data['cash_register_id'] = $cashRegister->id;
        }

        return $this->expenseRepository->create($data);
    }

    /**
     * Update an existing expense.
     *
     * @param int|string $id
     * @param array $requestData
     * @return Expense
     */
    public function updateExpense($id, array $requestData): Expense
    {
        $expense = $this->expenseRepository->findOrFail($id);
        $data = $requestData;
        if (!empty($data['created_at'])) {
            $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
        }

        $expense->update($data);

        return $expense;
    }

    /**
     * Delete an expense.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteExpense($id): bool
    {
        return $this->expenseRepository->delete($id);
    }

    /**
     * Delete multiple expenses.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleExpenses(array $ids): bool
    {
        return (bool) Expense::whereIn('id', $ids)->delete();
    }
}
