<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AccountsController extends Controller
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('account-index')) {
            $lims_account_all = $this->accountService->getActiveAccounts();
            return view('backend.account.index', compact('lims_account_all'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'account_no' => [
                'max:255',
                Rule::unique('accounts')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $this->accountService->createAccount($request->all());

        return redirect('accounts')->with('message', 'Account created successfully');
    }

    public function makeDefault($id)
    {
        $this->accountService->makeDefault($id);

        return 'Account set as default successfully';
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'account_no' => [
                'max:255',
                Rule::unique('accounts')->ignore($request->account_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $this->accountService->updateAccount($request->account_id, $request->all());

        return redirect('accounts')->with('message', 'Account updated successfully');
    }

    public function balanceSheet()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('balance-sheet')) {
            $balanceSheetData = $this->accountService->getBalanceSheetData();
            return view('backend.account.balance_sheet', $balanceSheetData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function accountStatement(Request $request)
    {
        $statementData = $this->accountService->getAccountStatementData(
            $request->account_id,
            $request->type ?? '0',
            $request->start_date,
            $request->end_date
        );

        return view('backend.account.account_statement', $statementData);
    }

    public function destroy($id)
    {
        $result = $this->accountService->deleteAccount($id);

        return redirect('accounts')->with('not_permitted', $result['message']);
    }

    public function accountsAll()
    {
        $html = $this->accountService->getAccountOptionsHtml();

        return response()->json($html);
    }

    public function payment()
    {
        return view('backend.account.payment');
    }
}
