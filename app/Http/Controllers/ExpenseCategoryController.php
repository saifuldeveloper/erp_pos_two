<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseCategory\StoreExpenseCategoryRequest;
use App\Http\Requests\ExpenseCategory\UpdateExpenseCategoryRequest;
use App\Services\ExpenseCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseCategoryController extends Controller
{
    protected ExpenseCategoryService $expenseCategoryService;

    public function __construct(ExpenseCategoryService $expenseCategoryService)
    {
        $this->expenseCategoryService = $expenseCategoryService;
        $this->middleware('check_permission:expense_category-index|expenses-index')->only(['index', 'generateCode', 'expenseCategoriesAll']);
        $this->middleware('check_permission:expense_category-add|expenses-add')->only(['create', 'store', 'import']);
        $this->middleware('check_permission:expense_category-edit|expenses-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:expense_category-delete')->only(['destroy', 'deleteBySelection']);
    }

    private function ensurePermissionsExist(): void
    {
        $permissions = [
            'expense_category-index' => [1, 2, 3, 5],
            'expense_category-add'   => [1, 2, 3, 5],
            'expense_category-edit'  => [1, 2, 3, 5],
            'expense_category-delete'=> [1, 2],
        ];

        $cleared = false;
        foreach ($permissions as $permissionName => $roleIds) {
            $permission = DB::table('permissions')->where('name', $permissionName)->first();
            if (!$permission) {
                $permissionId = DB::table('permissions')->insertGetId([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                foreach ($roleIds as $roleId) {
                    if (DB::table('roles')->where('id', $roleId)->exists()) {
                        DB::table('role_has_permissions')->insert([
                            'permission_id' => $permissionId,
                            'role_id' => $roleId,
                        ]);
                    }
                }
                $cleared = true;
            }
        }

        if ($cleared) {
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }
    }

    public function index()
    {
        $this->ensurePermissionsExist();
        $lims_expense_category_all = $this->expenseCategoryService->getCategoriesWithTotals();

        return view('backend.expense_category.index', compact('lims_expense_category_all'));
    }

    public function generateCode()
    {
        return $this->expenseCategoryService->generateCode();
    }

    public function store(StoreExpenseCategoryRequest $request)
    {
        $this->ensurePermissionsExist();
        $this->expenseCategoryService->createCategory($request->all());

        return redirect('expense_categories')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $this->ensurePermissionsExist();
        return $this->expenseCategoryService->getCategoryById($id);
    }

    public function update(UpdateExpenseCategoryRequest $request, $id)
    {
        $this->ensurePermissionsExist();
        $this->expenseCategoryService->updateCategory($request->expense_category_id, $request->all());

        return redirect('expense_categories')->with('message', 'Data updated successfully');
    }

    public function import(Request $request)
    {
        $upload = $request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        }

        $this->expenseCategoryService->importCategories($upload);

        return redirect('expense_categories')->with('message', 'ExpenseCategory imported successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $this->ensurePermissionsExist();
        $expense_category_id = $request['expense_categoryIdArray'] ?? [];
        $this->expenseCategoryService->deleteMultipleCategories($expense_category_id);

        return 'Expense Category deleted successfully!';
    }

    public function destroy($id)
    {
        $this->ensurePermissionsExist();
        $this->expenseCategoryService->deleteCategory($id);

        return redirect('expense_categories')->with('not_permitted', 'Data deleted successfully');
    }

    public function expenseCategoriesAll()
    {
        $html = $this->expenseCategoryService->getCategoryOptionsHtml();
        return response()->json($html);
    }
}
