<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\MoneyTransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class MoneyTransferController extends Controller
{
    protected MoneyTransferService $moneyTransferService;

    public function __construct(MoneyTransferService $moneyTransferService)
    {
        $this->moneyTransferService = $moneyTransferService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('money-transfer')) {
            $lims_money_transfer_all = $this->moneyTransferService->getAllTransfers();
            $lims_account_list = Account::where('is_active', true)->get();
            return view('backend.money_transfer.index', compact('lims_money_transfer_all', 'lims_account_list'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $this->moneyTransferService->createTransfer($request->all());

        return redirect()->back()->with('message', 'Money transfered successfully');
    }

    public function update(Request $request, $id)
    {
        $this->moneyTransferService->updateTransfer($request->input('id'), $request->all());

        return redirect()->back()->with('message', 'Money transfer updated successfully');
    }

    public function destroy($id)
    {
        $this->moneyTransferService->deleteTransfer($id);

        return redirect()->back()->with('not_permitted', 'Data deleted successfully');
    }
}
