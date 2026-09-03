<?php

namespace App\Http\Controllers;

use App\Http\Requests\Currency\StoreCurrencyRequest;
use App\Http\Requests\Currency\UpdateCurrencyRequest;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CurrencyController extends Controller
{
    protected CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('currency')) {
            $lims_currency_all = $this->currencyService->getActiveCurrencies();
            return view('backend.currency.index', compact('lims_currency_all'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(StoreCurrencyRequest $request)
    {
        $this->currencyService->createCurrency($request->all());

        return redirect()->back()->with('message', 'Currency created successfully');
    }

    public function update(UpdateCurrencyRequest $request, $id)
    {
        $this->currencyService->updateCurrency($request->currency_id, $request->all());

        return redirect()->back()->with('message', 'Currency updated successfully');
    }

    public function destroy($id)
    {
        $this->currencyService->deleteCurrency($id);

        return redirect()->back()->with('message', 'Currency deleted successfully');
    }
}
