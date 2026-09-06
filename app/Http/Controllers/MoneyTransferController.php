<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoneyTransfer\StoreMoneyTransferRequest;
use App\Http\Requests\MoneyTransfer\UpdateMoneyTransferRequest;
use App\Models\Account;
use App\Services\MoneyTransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoneyTransferController extends Controller
{
    protected MoneyTransferService $moneyTransferService;

    public function __construct(MoneyTransferService $moneyTransferService)
    {
        $this->moneyTransferService = $moneyTransferService;
        $this->middleware('check_permission:money-transfer')->only(['index', 'create', 'store', 'edit', 'update']);
    }

    public function index()
    {
        $lims_money_transfer_all = $this->moneyTransferService->getAllTransfers();
        $lims_account_list = Account::where('is_active', true)->get();
        return view('backend.money_transfer.index', compact('lims_money_transfer_all', 'lims_account_list'));
    }

    public function store(StoreMoneyTransferRequest $request)
    {
        $this->moneyTransferService->createTransfer($request->all());

        return redirect()->back()->with('message', 'Money transfered successfully');
    }

    public function update(UpdateMoneyTransferRequest $request, $id)
    {
        $this->moneyTransferService->updateTransfer($request->input('id'), $request->all());

        return redirect()->back()->with('message', 'Money transfer updated successfully');
    }

    public function destroy($id)
    {
        if (Auth::user()->role_id > 2) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete money transfer');
        }

        $this->moneyTransferService->deleteTransfer($id);

        return redirect()->back()->with('not_permitted', 'Data deleted successfully');
    }
}
