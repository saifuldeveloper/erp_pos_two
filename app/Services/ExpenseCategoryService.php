<?php

namespace App\Services;

use App\Models\ExpenseCategory;
use App\Repositories\Contracts\ExpenseCategoryRepositoryInterface;
use App\Traits\CacheForget;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Keygen\Keygen;

class ExpenseCategoryService
{
    use CacheForget;

    protected ExpenseCategoryRepositoryInterface $expenseCategoryRepository;

    /**
     * ExpenseCategoryService constructor.
     *
     * @param ExpenseCategoryRepositoryInterface $expenseCategoryRepository
     */
    public function __construct(ExpenseCategoryRepositoryInterface $expenseCategoryRepository)
    {
        $this->expenseCategoryRepository = $expenseCategoryRepository;
    }

    /**
     * Get all active expense categories with their total expense amounts.
     *
     * @return Collection
     */
    public function getCategoriesWithTotals(): Collection
    {
        return $this->expenseCategoryRepository->getActiveCategoriesWithTotalExpense();
    }

    /**
     * Generate unique numeric code for expense category.
     *
     * @return string
     */
    public function generateCode(): string
    {
        return \Keygen::numeric(8)->generate();
    }

    /**
     * Get expense category by ID.
     *
     * @param int|string $id
     * @return ExpenseCategory
     */
    public function getCategoryById($id): ExpenseCategory
    {
        return $this->expenseCategoryRepository->findOrFail($id);
    }

    /**
     * Create a new expense category.
     *
     * @param array $data
     * @return ExpenseCategory
     */
    public function createCategory(array $data): ExpenseCategory
    {
        $data['is_active'] = true;
        $category = $this->expenseCategoryRepository->create($data);
        $this->cacheForget('expense_category_list');

        return $category;
    }

    /**
     * Update an existing expense category.
     *
     * @param int|string $id
     * @param array $data
     * @return ExpenseCategory
     */
    public function updateCategory($id, array $data): ExpenseCategory
    {
        $category = $this->expenseCategoryRepository->findOrFail($id);
        $category->update($data);
        $this->cacheForget('expense_category_list');

        return $category;
    }

    /**
     * Import expense categories from CSV.
     *
     * @param UploadedFile $file
     * @return void
     */
    public function importCategories(UploadedFile $file): void
    {
        $filePath = $file->getRealPath();
        $handle = fopen($filePath, 'r');
        $header = fgetcsv($handle);
        $escapedHeader = [];

        foreach ($header as $value) {
            $lheader = strtolower($value);
            $escapedItem = preg_replace('/[^a-z]/', '', $lheader);
            $escapedHeader[] = $escapedItem;
        }

        while ($columns = fgetcsv($handle)) {
            if ($columns[0] == '') {
                continue;
            }

            foreach ($columns as $key => $value) {
                $columns[$key] = preg_replace('/\D/', '', $value);
            }

            $data = array_combine($escapedHeader, $columns);
            $category = $this->expenseCategoryRepository->firstOrNew(['code' => $data['code'], 'is_active' => true]);
            $category->code = $data['code'];
            $category->name = $data['name'];
            $category->is_active = true;
            $category->save();
        }

        fclose($handle);
        $this->cacheForget('expense_category_list');
    }

    /**
     * Deactivate an expense category.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteCategory($id): bool
    {
        $result = $this->expenseCategoryRepository->deactivate($id);
        $this->cacheForget('expense_category_list');

        return $result;
    }

    /**
     * Deactivate multiple expense categories.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleCategories(array $ids): bool
    {
        $result = $this->expenseCategoryRepository->deactivateMultiple($ids);
        $this->cacheForget('expense_category_list');

        return $result;
    }

    /**
     * Get HTML options for expense category select dropdown.
     *
     * @return string
     */
    public function getCategoryOptionsHtml(): string
    {
        $categories = $this->expenseCategoryRepository->getActiveCategories();
        $html = '';
        foreach ($categories as $category) {
            $html .= '<option value="' . $category->id . '">' . $category->name . ' (' . $category->code . ')' . '</option>';
        }

        return $html;
    }
}
