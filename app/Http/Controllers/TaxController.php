<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tax\StoreTaxRequest;
use App\Http\Requests\Tax\UpdateTaxRequest;
use App\Services\TaxService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class TaxController extends Controller
{
    protected TaxService $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('tax')) {
            $lims_tax_all = $this->taxService->getActiveTaxes();
            return view('backend.tax.create', compact('lims_tax_all'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(StoreTaxRequest $request)
    {
        $this->taxService->createTax($request->all());

        return redirect('tax')->with('message', 'Data inserted successfully');
    }

    public function limsTaxSearch()
    {
        $lims_tax_name = $_GET['lims_taxNameSearch'];
        $lims_tax_all = $this->taxService->searchTaxesByName($lims_tax_name, 5);
        $lims_tax_list = $this->taxService->getAllTaxes();

        return view('backend.tax.create', compact('lims_tax_all', 'lims_tax_list'));
    }

    public function edit($id)
    {
        return $this->taxService->getTaxById($id);
    }

    public function update(UpdateTaxRequest $request, $id)
    {
        $this->taxService->updateTax($request->tax_id, $request->all());

        return redirect('tax')->with('message', 'Data updated successfully');
    }

    public function importTax(Request $request)
    {
        $upload = $request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        }

        $this->taxService->importTaxes($upload);

        return redirect('tax')->with('message', 'Tax imported successfully');
    }

    public function deleteBySelection(Request $request)
    {
        if (Auth::user()->role_id > 2) {
            return 'Sorry! You are not allowed to delete tax';
        }

        $tax_id = $request['taxIdArray'];
        $this->taxService->deleteMultipleTaxes($tax_id);

        return 'Tax deleted successfully!';
    }

    public function destroy($id)
    {
        if (Auth::user()->role_id > 2) {
            return redirect('tax')->with('not_permitted', 'Sorry! You are not allowed to delete tax');
        }

        $this->taxService->deleteTax($id);

        return redirect('tax')->with('not_permitted', 'Data deleted successfully');
    }
}
