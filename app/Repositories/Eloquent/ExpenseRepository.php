<?php

namespace App\Repositories\Eloquent;

use App\Models\Expense;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ExpenseRepository extends BaseRepository implements ExpenseRepositoryInterface
{
    /**
     * ExpenseRepository constructor.
     *
     * @param Expense $model
     */
    public function __construct(Expense $model)
    {
        parent::__construct($model);
    }

    /**
     * Build base query with filters.
     */
    protected function buildFilteredQuery(array $filters)
    {
        $q = $this->model->newQuery();

        if (!empty($filters['starting_date'])) {
            $q->whereDate('created_at', '>=', $filters['starting_date']);
        }
        if (!empty($filters['ending_date'])) {
            $q->whereDate('created_at', '<=', $filters['ending_date']);
        }
        if (!empty($filters['expense_category_id'])) {
            $q->where('expense_category_id', $filters['expense_category_id']);
        }
        if (!empty($filters['warehouse_id'])) {
            $q->where('warehouse_id', $filters['warehouse_id']);
        }
        if (Auth::user() && Auth::user()->role_id > 2 && config('staff_access') == 'own') {
            $q->where('user_id', Auth::id());
        }

        return $q;
    }

    /**
     * Count total expenses matching date & warehouse filters.
     *
     * @param array $filters
     * @return int
     */
    public function countTotalExpenses(array $filters): int
    {
        return $this->buildFilteredQuery($filters)->count();
    }

    /**
     * Get filtered expenses for DataTables.
     *
     * @param int $start
     * @param int $limit
     * @param string $order
     * @param string $dir
     * @param array $filters
     * @param string|null $searchValue
     * @return Collection
     */
    public function getFilteredExpensesForDataTable(int $start, int $limit, string $order, string $dir, array $filters, ?string $searchValue = null): Collection
    {
        $q = $this->buildFilteredQuery($filters)->with('warehouse', 'expenseCategory');

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue) {
                $query->whereDate('created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $searchValue))))
                    ->orWhere('reference_no', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }

    /**
     * Count filtered expenses for DataTables.
     *
     * @param array $filters
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredExpensesForDataTable(array $filters, ?string $searchValue = null): int
    {
        $q = $this->buildFilteredQuery($filters);

        if (!empty($searchValue)) {
            $q->where(function ($query) use ($searchValue) {
                $query->whereDate('created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $searchValue))))
                    ->orWhere('reference_no', 'LIKE', "%{$searchValue}%");
            });
        }

        return $q->count();
    }
}
