<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseCategory\StoreExpenseCategoryRequest;
use App\Http\Requests\ExpenseCategory\UpdateExpenseCategoryRequest;
use App\Services\ExpenseCategoryService;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    protected ExpenseCategoryService $expenseCategoryService;

    public function __construct(ExpenseCategoryService $expenseCategoryService)
    {
        $this->expenseCategoryService = $expenseCategoryService;
    }

    public function index()
    {
        $lims_expense_category_all = $this->expenseCategoryService->getCategoriesWithTotals();
        return view('backend.expense_category.index', compact('lims_expense_category_all'));
    }

    public function generateCode()
    {
        return $this->expenseCategoryService->generateCode();
    }

    public function store(StoreExpenseCategoryRequest $request)
    {
        $this->expenseCategoryService->createCategory($request->all());

        return redirect('expense_categories')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        return $this->expenseCategoryService->getCategoryById($id);
    }

    public function update(UpdateExpenseCategoryRequest $request, $id)
    {
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
        $expense_category_id = $request['expense_categoryIdArray'] ?? [];
        $this->expenseCategoryService->deleteMultipleCategories($expense_category_id);

        return 'Expense Category deleted successfully!';
    }

    public function destroy($id)
    {
        $this->expenseCategoryService->deleteCategory($id);

        return redirect('expense_categories')->with('not_permitted', 'Data deleted successfully');
    }

    public function expenseCategoriesAll()
    {
        $html = $this->expenseCategoryService->getCategoryOptionsHtml();
        return response()->json($html);
    }
}
