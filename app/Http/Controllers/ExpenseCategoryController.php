<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseCategory\StoreExpenseCategoryRequest;
use App\Http\Requests\ExpenseCategory\UpdateExpenseCategoryRequest;
use App\Services\ExpenseCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ExpenseCategoryController extends Controller
{
    protected ExpenseCategoryService $expenseCategoryService;

    public function __construct(ExpenseCategoryService $expenseCategoryService)
    {
        $this->expenseCategoryService = $expenseCategoryService;
    }

    private function ensurePermissionsExist(): void
    {
        $permissions = [
            'expense_category-index' => [1, 2, 3, 5],
            'expense_category-add'   => [1, 2, 3, 5],
            'expense_category-edit'  => [1, 2, 3, 5],
            'expense_category-delete'=> [1, 2], // Only Admin (1) & Owner (2), excluding Manager (3) & Biller (5)
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

        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('expense_category-index') || $role->hasPermissionTo('expenses-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

            $lims_expense_category_all = $this->expenseCategoryService->getCategoriesWithTotals();
            return view('backend.expense_category.index', compact('lims_expense_category_all', 'all_permission'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function generateCode()
    {
        return $this->expenseCategoryService->generateCode();
    }

    public function store(StoreExpenseCategoryRequest $request)
    {
        $this->ensurePermissionsExist();

        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('expense_category-add') && !$role->hasPermissionTo('expenses-add') && Auth::user()->role_id > 2) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to add expense category');
        }

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

        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('expense_category-edit') && !$role->hasPermissionTo('expenses-edit') && Auth::user()->role_id > 2) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to update expense category');
        }

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

        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('expense_category-delete') && Auth::user()->role_id > 2) {
            return 'Sorry! You are not allowed to delete expense category';
        }

        $expense_category_id = $request['expense_categoryIdArray'] ?? [];
        $this->expenseCategoryService->deleteMultipleCategories($expense_category_id);

        return 'Expense Category deleted successfully!';
    }

    public function destroy($id)
    {
        $this->ensurePermissionsExist();

        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('expense_category-delete') && Auth::user()->role_id > 2) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete expense category');
        }

        $this->expenseCategoryService->deleteCategory($id);

        return redirect('expense_categories')->with('not_permitted', 'Data deleted successfully');
    }

    public function expenseCategoriesAll()
    {
        $html = $this->expenseCategoryService->getCategoryOptionsHtml();
        return response()->json($html);
    }
}
