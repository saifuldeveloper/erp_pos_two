<?php

namespace App\Http\Controllers;

use App\Http\Requests\Currency\StoreCurrencyRequest;
use App\Http\Requests\Currency\UpdateCurrencyRequest;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
        $this->middleware('check_permission:currency');
    }

    public function index()
    {
        $lims_currency_all = $this->currencyService->getActiveCurrencies();
        return view('backend.currency.index', compact('lims_currency_all'));
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
