<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\StoreAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
        $this->middleware('check_permission:account-index')->only('index');
        $this->middleware('check_permission:balance-sheet')->only('balanceSheet');
        $this->middleware('check_permission:account-statement')->only('accountStatement');
        $this->middleware('check_permission:account-delete')->only('destroy');
    }

    public function index()
    {
        $permission = DB::table('permissions')->where('name', 'account-delete')->first();
        if (!$permission) {
            $permissionId = DB::table('permissions')->insertGetId([
                'name' => 'account-delete',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('role_has_permissions')->insert([
                ['permission_id' => $permissionId, 'role_id' => 1],
                ['permission_id' => $permissionId, 'role_id' => 2],
            ]);
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }

        $lims_account_all = $this->accountService->getActiveAccounts();
        return view('backend.account.index', compact('lims_account_all'));
    }

    public function store(StoreAccountRequest $request)
    {
        $this->accountService->createAccount($request->all());

        return redirect('accounts')->with('message', 'Account created successfully');
    }

    public function makeDefault($id)
    {
        $this->accountService->makeDefault($id);

        return 'Account set as default successfully';
    }

    public function update(UpdateAccountRequest $request, $id)
    {
        $this->accountService->updateAccount($request->account_id, $request->all());

        return redirect('accounts')->with('message', 'Account updated successfully');
    }

    public function balanceSheet()
    {
        $balanceSheetData = $this->accountService->getBalanceSheetData();
        return view('backend.account.balance_sheet', $balanceSheetData);
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
