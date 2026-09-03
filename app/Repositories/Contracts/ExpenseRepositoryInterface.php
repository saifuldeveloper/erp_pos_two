<?php

namespace App\Repositories\Contracts;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseRepositoryInterface extends BaseRepositoryInterface
{
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
    public function getFilteredExpensesForDataTable(int $start, int $limit, string $order, string $dir, array $filters, ?string $searchValue = null): Collection;

    /**
     * Count filtered expenses for DataTables.
     *
     * @param array $filters
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredExpensesForDataTable(array $filters, ?string $searchValue = null): int;

    /**
     * Count total expenses matching date & warehouse filters.
     *
     * @param array $filters
     * @return int
     */
    public function countTotalExpenses(array $filters): int;
}
