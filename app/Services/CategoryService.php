<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Traits\CacheForget;
use App\Traits\FileHandleTrait;
use App\Traits\TenantInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryService
{
    use CacheForget;
    use FileHandleTrait;
    use TenantInfo;

    protected CategoryRepositoryInterface $categoryRepository;

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get active parent categories.
     *
     * @return Collection
     */
    public function getParentCategories(): Collection
    {
        return $this->categoryRepository->getActiveParentCategories();
    }

    /**
     * Get category by ID.
     *
     * @param int|string $id
     * @return Category|null
     */
    public function getCategoryById($id): ?Category
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * Process category data for DataTables.
     *
     * @param Request $request
     * @param array $permissions
     * @return array
     */
    public function getCategoryDataTable(Request $request, array $permissions): array
    {
        $can_edit = $permissions['can_edit'] ?? false;
        $can_delete = $permissions['can_delete'] ?? false;

        $columns = [
            1 => 'name',
            2 => 'parent_id',
            3 => 'number_of_product',
            4 => 'stock_qty',
        ];

        $totalData = $this->categoryRepository->countTotalCategoriesForDataTable();
        $totalFiltered = $totalData;

        $limit = $request->input('length') != -1 ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'name';
        $dir = $request->input('order.0.dir', 'asc');
        $searchValue = $request->input('search.value');

        $categories = $this->categoryRepository->getFilteredCategoriesForDataTable($start, $limit, $order, $dir, $searchValue);

        if (!empty($searchValue)) {
            $totalFiltered = $this->categoryRepository->countFilteredCategoriesForDataTable($searchValue);
        }

        $data = [];
        if ($categories->isNotEmpty()) {
            foreach ($categories as $key => $category) {
                $nestedData['id'] = $category->id;
                $nestedData['key'] = $key;
                $nestedData['name'] = $category->name;

                if ($category->parent_id) {
                    $parent = $this->categoryRepository->find($category->parent_id);
                    $nestedData['parent_id'] = $parent ? $parent->name : 'N/A';
                } else {
                    $nestedData['parent_id'] = 'N/A';
                }

                $nestedData['number_of_product'] = $category->product()->where('is_active', true)->count();
                $nestedData['stock_qty'] = $category->product()->where('is_active', true)->sum('qty');
                $total_price = $category->product()->where('is_active', true)->sum(DB::raw('price * qty'));
                $total_cost = $category->product()->where('is_active', true)->sum(DB::raw('cost * qty'));

                if (config('currency_position') == 'prefix') {
                    $nestedData['stock_worth'] = config('currency') . ' ' . $total_price . ' / ' . config('currency') . ' ' . $total_cost;
                } else {
                    $nestedData['stock_worth'] = $total_price . ' ' . config('currency') . ' / ' . $total_cost . ' ' . config('currency');
                }

                $options = '<div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . trans("file.action") . '
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">';
                if ($can_edit) {
                    $options .= '<li>
                                    <button type="button" data-id="' . $category->id . '" class="open-EditCategoryDialog btn btn-link" data-toggle="modal" data-target="#editModal" ><i class="dripicons-document-edit"></i> ' . trans("file.edit") . '</button>
                                </li>';
                }
                if ($can_delete) {
                    $options .= '<li class="divider"></li>' .
                                \Form::open(["route" => ["category.destroy", $category->id], "method" => "DELETE"]) . '
                                <li>
                                  <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> ' . trans("file.delete") . '</button>
                                </li>' . \Form::close();
                }
                $options .= '</ul></div>';
                $nestedData['options'] = $options;
                $data[] = $nestedData;
            }
        }

        return [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        ];
    }

    /**
     * Create a new category with image/icon handling.
     *
     * @param array $data
     * @param UploadedFile|null $image
     * @param UploadedFile|null $icon
     * @return Category
     */
    public function createCategory(array $data, ?UploadedFile $image = null, ?UploadedFile $icon = null): Category
    {
        $input = [
            'name'      => $data['name'],
            'parent_id' => $data['parent_id'] ?? null,
            'is_active' => true,
        ];

        if ($image) {
            $imageName = $this->uploadImage($image, 'public/images/category', 300, 300);
            $input['image'] = $imageName;
        }

        if ($icon) {
            $iconName = $this->uploadImage($icon, 'public/images/category/icons', 100, 100);
            $input['icon'] = $iconName;
        }

        if (isset($data['is_sync_disable'])) {
            $input['is_sync_disable'] = $data['is_sync_disable'];
        }

        if (isset($data['slug'])) {
            $input['slug'] = Str::slug($data['name'], '-');
            $input['featured'] = $data['featured'] ?? 0;
            $input['page_title'] = $data['page_title'] ?? null;
            $input['short_description'] = $data['short_description'] ?? null;
        }

        $category = $this->categoryRepository->create($input);
        $this->cacheForget('category_list');

        return $category;
    }

    /**
     * Update an existing category.
     *
     * @param int|string $id
     * @param array $data
     * @param UploadedFile|null $image
     * @param UploadedFile|null $icon
     * @return Category
     */
    public function updateCategory($id, array $data, ?UploadedFile $image = null, ?UploadedFile $icon = null): Category
    {
        $category = $this->categoryRepository->findOrFail($id);
        $input = $data;

        if ($image) {
            $this->fileDelete('images/category/', $category->image);
            $input['image'] = $this->uploadImage($image, 'public/images/category', 100, 100);
        }

        if ($icon) {
            $this->fileDelete('images/category/icons/', $category->icon);
            $input['icon'] = $this->uploadImage($icon, 'public/images/category/icons', 100, 100);
        }

        if (!isset($input['featured']) && Schema::hasColumn('categories', 'featured')) {
            $input['featured'] = 0;
        }

        if (!isset($input['is_sync_disable']) && Schema::hasColumn('categories', 'is_sync_disable')) {
            $input['is_sync_disable'] = null;
        }

        $this->categoryRepository->update($id, $input);
        $this->cacheForget('category_list');

        return $this->categoryRepository->find($id);
    }

    /**
     * Import categories from CSV file.
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
            $category = $this->categoryRepository->firstOrNew(['name' => $data['name'], 'is_active' => true]);

            $parentId = null;
            if (!empty($data['parentcategory'])) {
                $parentCategory = $this->categoryRepository->firstOrNew(['name' => $data['parentcategory'], 'is_active' => true]);
                if (!$parentCategory->exists) {
                    $parentCategory->save();
                }
                $parentId = $parentCategory->id;
            }

            $category->parent_id = $parentId;
            $category->is_active = true;
            $category->save();
        }

        fclose($handle);
        $this->cacheForget('category_list');
    }

    /**
     * Delete a single category and related products & files.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteCategory($id): bool
    {
        $category = $this->categoryRepository->deactivateWithProducts($id);
        if ($category) {
            $this->fileDelete('images/category/', $category->image);
            $this->fileDelete('images/category/icons/', $category->icon);
        }

        $this->cacheForget('category_list');
        return true;
    }

    /**
     * Delete multiple categories and related products & files.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleCategories(array $ids): bool
    {
        $categories = $this->categoryRepository->deactivateMultipleWithProducts($ids);
        foreach ($categories as $category) {
            $this->fileDelete('images/category/', $category->image);
            $this->fileDelete('images/category/icons/', $category->icon);
        }

        $this->cacheForget('category_list');
        return true;
    }

    /**
     * Helper to upload and fit an image.
     *
     * @param UploadedFile $file
     * @param string $destinationPath
     * @param int $width
     * @param int $height
     * @return string
     */
    protected function uploadImage(UploadedFile $file, string $destinationPath, int $width, int $height): string
    {
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $filename = date('Ymdhis');

        if (!config('database.connections.saas_landlord')) {
            $filename = $filename . '.' . $ext;
        } else {
            $filename = $this->getTenantId() . '_' . $filename . '.' . $ext;
        }

        $file->move($destinationPath, $filename);
        Image::make($destinationPath . '/' . $filename)->fit($width, $height)->save();

        return $filename;
    }
}
