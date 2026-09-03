<?php

namespace App\Repositories\Eloquent;

use App\Models\ExpenseCategory;
use App\Repositories\Contracts\ExpenseCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ExpenseCategoryRepository extends BaseRepository implements ExpenseCategoryRepositoryInterface
{
    /**
     * ExpenseCategoryRepository constructor.
     *
     * @param ExpenseCategory $model
     */
    public function __construct(ExpenseCategory $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active expense categories with total sum of expenses.
     *
     * @return Collection
     */
    public function getActiveCategoriesWithTotalExpense(): Collection
    {
        return $this->model->where('expense_categories.is_active', true)
            ->leftJoin('expenses', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->select('expense_categories.*', DB::raw('SUM(expenses.amount) as total_amount'))
            ->groupBy('expense_categories.id')
            ->get();
    }

    /**
     * Get all active expense categories.
     *
     * @return Collection
     */
    public function getActiveCategories(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Deactivate an expense category.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool
    {
        $cat = $this->find($id);
        if ($cat) {
            $cat->is_active = false;
            return (bool) $cat->save();
        }
        return false;
    }

    /**
     * Deactivate multiple expense categories.
     *
     * @param array $ids
     * @return bool
     */
    public function deactivateMultiple(array $ids): bool
    {
        return (bool) $this->model->whereIn('id', $ids)->update(['is_active' => false]);
    }

    /**
     * Get the first record matching attributes or instantiate it.
     *
     * @param array $attributes
     * @param array $values
     * @return ExpenseCategory
     */
    public function firstOrNew(array $attributes, array $values = []): ExpenseCategory
    {
        return $this->model->firstOrNew($attributes, $values);
    }
}
