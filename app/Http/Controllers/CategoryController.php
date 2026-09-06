<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->middleware('check_permission:category-index|category')->only(['index', 'parentCategory']);
        $this->middleware('check_permission:category-add')->only(['create', 'store', 'import']);
        $this->middleware('check_permission:category-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:category-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index()
    {
        $parents = $this->categoryService->getParentCategories();
        return view('backend.category.create', compact('parents'));
    }

    public function categoryData(Request $request)
    {
        $user = Auth::user();
        $isSuperOrAdmin = $user && $user->role_id <= 2;
        $role = $user ? Role::find($user->role_id) : null;

        $permissions = [
            'can_edit'   => $isSuperOrAdmin || ($role && $role->hasPermissionTo('category-edit')),
            'can_delete' => $isSuperOrAdmin || ($role && $role->hasPermissionTo('category-delete')),
        ];

        $jsonData = $this->categoryService->getCategoryDataTable($request, $permissions);

        return response()->json($jsonData);
    }

    public function store(StoreCategoryRequest $request)
    {
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

    public function update(UpdateCategoryRequest $request)
    {
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
        $parents = $this->categoryService->getParentCategories();
        return view('backend.parent_category.create', compact('parents'));
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
        $category_id = $request['categoryIdArray'] ?? [];
        $this->categoryService->deleteMultipleCategories($category_id);

        return 'Category deleted successfully!';
    }

    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);

        return redirect()->back()->with('not_permitted', 'Category deleted successfully');
    }
}
