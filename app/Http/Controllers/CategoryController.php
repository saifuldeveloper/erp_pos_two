<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Auth;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        $parents = $this->categoryService->getParentCategories();
        if ($role->hasPermissionTo('category-index') || $role->hasPermissionTo('category')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }
            return view('backend.category.create', compact('parents', 'all_permission'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function categoryData(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        $permissions = [
            'can_edit'   => $role->hasPermissionTo('category-edit'),
            'can_delete' => $role->hasPermissionTo('category-delete'),
        ];

        $jsonData = $this->categoryService->getCategoryDataTable($request, $permissions);

        return response()->json($jsonData);
    }

    public function store(Request $request)
    {
        $request->name = preg_replace('/\s+/', ' ', $request->name);
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('categories')->where(function ($query) use ($request) {
                    return $query->where('is_active', 1)
                        ->where('parent_id', $request->parent_id);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif',
            'icon'  => 'mimetypes:text/plain,image/png,image/jpeg,image/svg',
        ]);

        $this->categoryService->createCategory(
            $request->all(),
            $request->file('image'),
            $request->file('icon')
        );

        return redirect()->back()->with('message', 'Category inserted successfully');
    }

    public function edit($id)
    {
        return $this->categoryService->getCategoryById($id);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('categories')->ignore($request->category_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif',
            'icon'  => 'mimetypes:text/plain,image/png,image/jpeg,image/svg',
        ]);

        $input = $request->except('image', 'icon', '_method', '_token', 'category_id');

        $this->categoryService->updateCategory(
            $request->category_id,
            $input,
            $request->file('image'),
            $request->file('icon')
        );

        return redirect()->back()->with('message', 'Category updated successfully');
    }

    public function parentCategory()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('category-index') || $role->hasPermissionTo('category')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }
            $parents = $this->categoryService->getParentCategories();
            return view('backend.parent_category.create', compact('parents', 'all_permission'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function import(Request $request)
    {
        $upload = $request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        }

        $this->categoryService->importCategories($upload);

        return redirect('category')->with('message', 'Category imported successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('category-delete')) {
            return 'Sorry! You are not allowed to delete category';
        }

        $category_id = $request['categoryIdArray'];
        $this->categoryService->deleteMultipleCategories($category_id);

        return 'Category deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('category-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete category');
        }

        $this->categoryService->deleteCategory($id);

        return redirect()->back()->with('not_permitted', 'Category deleted successfully');
    }
}
