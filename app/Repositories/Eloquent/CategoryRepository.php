<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * CategoryRepository constructor.
     *
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active parent categories.
     *
     * @return Collection
     */
    public function getActiveParentCategories(): Collection
    {
        return $this->model
            ->whereNull('parent_id')
            ->where('is_active', 1)
            ->select('id', 'name')
            ->get();
    }

    /**
     * Count total active categories with non-null parent_id.
     *
     * @return int
     */
    public function countTotalCategoriesForDataTable(): int
    {
        return $this->model
            ->where('is_active', true)
            ->whereNotNull('parent_id')
            ->count();
    }

    /**
     * Count total categories matching search filter.
     *
     * @param string|null $searchValue
     * @return int
     */
    public function countFilteredCategoriesForDataTable(?string $searchValue = null): int
    {
        if (empty($searchValue)) {
            return $this->countTotalCategoriesForDataTable();
        }

        return $this->model
            ->where([
                ['name', 'LIKE', "%{$searchValue}%"],
                ['is_active', true],
            ])
            ->whereNotNull('parent_id')
            ->count();
    }

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
    public function getFilteredCategoriesForDataTable(int $start, int $limit, string $order, string $dir, ?string $searchValue = null): Collection
    {
        if (empty($searchValue)) {
            if ($order === 'number_of_product') {
                return $this->model
                    ->withCount(['product' => function ($query) {
                        $query->where('is_active', true);
                    }])
                    ->where('is_active', true)
                    ->whereNotNull('parent_id')
                    ->orderBy('product_count', $dir)
                    ->offset($start)
                    ->limit($limit)
                    ->get();
            }

            if ($order === 'stock_qty') {
                return $this->model
                    ->selectRaw('categories.*,
                        (SELECT SUM(qty) FROM products WHERE products.category_id = categories.id AND products.is_active = 1) AS stock_qty')
                    ->where('is_active', true)
                    ->orderBy('stock_qty', $dir)
                    ->whereNotNull('parent_id')
                    ->offset($start)
                    ->limit($limit)
                    ->get();
            }

            return $this->model
                ->offset($start)
                ->where('is_active', true)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->whereNotNull('parent_id')
                ->get();
        }

        return $this->model
            ->where([
                ['name', 'LIKE', "%{$searchValue}%"],
                ['is_active', true],
            ])
            ->whereNotNull('parent_id')
            ->orderBy($order, $dir)
            ->offset($start)
            ->limit($limit)
            ->get();
    }

    /**
     * Deactivate a category and all products associated with it.
     *
     * @param int|string $id
     * @return Category|null
     */
    public function deactivateWithProducts($id): ?Category
    {
        $category = $this->find($id);
        if (!$category) {
            return null;
        }

        Product::where('category_id', $id)->update(['is_active' => false]);

        $category->is_active = false;
        $category->save();

        return $category;
    }

    /**
     * Deactivate multiple categories and all products associated with them.
     *
     * @param array $ids
     * @return array
     */
    public function deactivateMultipleWithProducts(array $ids): array
    {
        $categories = [];
        foreach ($ids as $id) {
            $category = $this->deactivateWithProducts($id);
            if ($category) {
                $categories[] = $category;
            }
        }
        return $categories;
    }

    /**
     * Get the first record matching attributes or instantiate it.
     *
     * @param array $attributes
     * @param array $values
     * @return Category
     */
    public function firstOrNew(array $attributes, array $values = []): Category
    {
        return $this->model->firstOrNew($attributes, $values);
    }
}
