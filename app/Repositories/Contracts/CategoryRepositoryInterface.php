<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get active parent categories (where parent_id is null and is_active is 1).
     *
     * @return Collection
     */
    public function getActiveParentCategories(): Collection;

    /**
     * Get all active categories.
     *
     * @return Collection
     */
    public function getActiveCategories(): Collection;

    /**
     * Get categories query/data for DataTables with sorting, limit, and search.
     *
     * @param int $start
     * @param int $limit
     * @param string $order
     * @param string $dir
     * @param string|null $searchValue
     * @return Collection
     */
    public function getFilteredCategoriesForDataTable(int $start, int $limit, string $order, string $dir, ?string $searchValue = null): Collection;

    /**
     * Count total categories matching search filter.
     *
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredCategoriesForDataTable(?string $searchValue = null): int;

    /**
     * Count total active categories with non-null parent_id.
     *
     * @return int
     */
    public function countTotalCategoriesForDataTable(): int;

    /**
     * Deactivate a category and all products associated with it.
     *
     * @param int|string $id
     * @return Category|null
     */
    public function deactivateWithProducts($id): ?Category;

    /**
     * Deactivate multiple categories and all products associated with them.
     *
     * @param array $ids
     * @return array
     */
    public function deactivateMultipleWithProducts(array $ids): array;

    /**
     * Get the first record matching attributes or instantiate it.
     *
     * @param array $attributes
     * @param array $values
     * @return Category
     */
    public function firstOrNew(array $attributes, array $values = []): Category;
}
