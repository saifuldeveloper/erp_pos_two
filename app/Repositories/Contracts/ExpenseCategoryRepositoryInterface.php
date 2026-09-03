<?php

namespace App\Repositories\Contracts;

use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseCategoryRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active expense categories with total sum of expenses.
     *
     * @return Collection
     */
    public function getActiveCategoriesWithTotalExpense(): Collection;

    /**
     * Get all active expense categories.
     *
     * @return Collection
     */
    public function getActiveCategories(): Collection;

    /**
     * Deactivate an expense category.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool;

    /**
     * Deactivate multiple expense categories.
     *
     * @param array $ids
     * @return bool
     */
    public function deactivateMultiple(array $ids): bool;

    /**
     * Get the first record matching attributes or instantiate it.
     *
     * @param array $attributes
     * @param array $values
     * @return ExpenseCategory
     */
    public function firstOrNew(array $attributes, array $values = []): ExpenseCategory;
}
