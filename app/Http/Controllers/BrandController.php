<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Auth;

class BrandController extends Controller
{
    protected BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('brand-index') || $role->hasPermissionTo('brand')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }
            $lims_brand_all = $this->brandService->getActiveBrands();
            return view('backend.brand.create', compact('lims_brand_all', 'all_permission'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $request->title = preg_replace('/\s+/', ' ', $request->title);
        $this->validate($request, [
            'title' => [
                'max:255',
                Rule::unique('brands')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

        $input = $request->except('image');
        $this->brandService->createBrand($input, $request->file('image'));

        return redirect('brand');
    }

    public function edit($id)
    {
        return $this->brandService->getBrandById($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => [
                'max:255',
                Rule::unique('brands')->ignore($request->brand_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

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
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('brand-delete')) {
            return 'Sorry! You are not allowed to delete brand';
        }

        $this->brandService->deleteMultipleBrands($request['brandIdArray']);

        return 'Brand deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('brand-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete brand');
        }

        $this->brandService->deleteBrand($id);

        return redirect('brand')->with('not_permitted', 'Brand deleted successfully!');
    }

    public function exportBrand(Request $request)
    {
        return $this->brandService->exportBrands($request['brandArray']);
    }
}
