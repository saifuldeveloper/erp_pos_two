<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\StoreAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('account-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $p) {
                $all_permission[] = $p->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

            $lims_account_all = $this->accountService->getActiveAccounts();
            return view('backend.account.index', compact('lims_account_all', 'all_permission'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
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
        $role = Role::find(Auth::user()->role_id);
        if (Auth::user()->role_id > 2 && !$role->hasPermissionTo('account-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete account');
        }

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
