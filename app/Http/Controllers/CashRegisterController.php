<?php

namespace App\Http\Controllers;

use App\Services\CashRegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashRegisterController extends Controller
{
    protected CashRegisterService $cashRegisterService;

    public function __construct(CashRegisterService $cashRegisterService)
    {
        $this->cashRegisterService = $cashRegisterService;
    }

    public function index()
    {
        if (Auth::user()->role_id <= 2) {
            $lims_cash_register_all = $this->cashRegisterService->getAllRegisters();
            return view('backend.cash_register.index', compact('lims_cash_register_all'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $this->cashRegisterService->openRegister($request->all());

        return redirect()->back()->with('message', 'Cash register created successfully');
    }

    public function getDetails($id)
    {
        return $this->cashRegisterService->getRegisterDetails($id);
    }

    public function showDetails($warehouse_id)
    {
        return $this->cashRegisterService->getActiveWarehouseRegisterDetails($warehouse_id);
    }

    public function close(Request $request)
    {
        $this->cashRegisterService->closeRegister($request->cash_register_id);

        return redirect()->back()->with('message', 'Cash register closed successfully');
    }

    public function checkAvailability($warehouse_id)
    {
        return $this->cashRegisterService->checkAvailability($warehouse_id) ? 'true' : 'false';
    }
}
