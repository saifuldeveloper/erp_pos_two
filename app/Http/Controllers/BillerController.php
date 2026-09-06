<?php

namespace App\Http\Controllers;

use App\Http\Requests\Biller\StoreBillerRequest;
use App\Http\Requests\Biller\UpdateBillerRequest;
use App\Services\BillerService;
use Illuminate\Http\Request;

class BillerController extends Controller
{
    protected BillerService $billerService;

    public function __construct(BillerService $billerService)
    {
        $this->billerService = $billerService;
        $this->middleware('check_permission:billers-index')->only('index');
        $this->middleware('check_permission:billers-add')->only(['create', 'store', 'importBiller']);
        $this->middleware('check_permission:billers-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:billers-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index()
    {
        $lims_biller_all = $this->billerService->getActiveBillers();
        return view('backend.biller.index', compact('lims_biller_all'));
    }

    public function create()
    {
        return view('backend.biller.create');
    }

    public function store(StoreBillerRequest $request)
    {
        $result = $this->billerService->createBiller($request->all(), $request->file('image'));

        return redirect('biller')->with('message', $result['message']);
    }

    public function edit($id)
    {
        $lims_biller_data = $this->billerService->getBillerById($id);
        return view('backend.biller.edit', compact('lims_biller_data'));
    }

    public function update(UpdateBillerRequest $request, $id)
    {
        $this->billerService->updateBiller($id, $request->all(), $request->file('image'));

        return redirect('biller')->with('message', 'Data updated successfully');
    }

    public function importBiller(Request $request)
    {
        $upload = $request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        }

        $message = $this->billerService->importBillers($upload);

        return redirect('biller')->with('message', $message);
    }

    public function deleteBySelection(Request $request)
    {
        $biller_id = $request['billerIdArray'] ?? [];
        $this->billerService->deleteMultipleBillers($biller_id);

        return 'Biller deleted successfully!';
    }

    public function destroy($id)
    {
        $this->billerService->deleteBiller($id);

        return redirect('biller')->with('not_permitted', 'Data deleted successfully');
    }
}
