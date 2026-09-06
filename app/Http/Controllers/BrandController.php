<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
        $this->middleware('check_permission:brand-index|brand')->only('index');
        $this->middleware('check_permission:brand-add')->only(['create', 'store', 'importBrand']);
        $this->middleware('check_permission:brand-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:brand-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index()
    {
        $lims_brand_all = $this->brandService->getActiveBrands();
        return view('backend.brand.create', compact('lims_brand_all'));
    }

    public function store(StoreBrandRequest $request)
    {
        $input = $request->except('image');
        $this->brandService->createBrand($input, $request->file('image'));

        return redirect('brand');
    }

    public function edit($id)
    {
        return $this->brandService->getBrandById($id);
    }

    public function update(UpdateBrandRequest $request, $id)
    {
        $data = ['title' => $request->title];
        $this->brandService->updateBrand($request->brand_id, $data, $request->file('image'));

        return redirect('brand');
    }

    public function importBrand(Request $request)
    {
        $upload = $request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        }

        $this->brandService->importBrands($upload);

        return redirect('brand')->with('message', 'Brand imported successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $this->brandService->deleteMultipleBrands($request['brandIdArray'] ?? []);

        return 'Brand deleted successfully!';
    }

    public function destroy($id)
    {
        $this->brandService->deleteBrand($id);

        return redirect('brand')->with('not_permitted', 'Brand deleted successfully!');
    }

    public function exportBrand(Request $request)
    {
        return $this->brandService->exportBrands($request['brandArray'] ?? []);
    }
}
