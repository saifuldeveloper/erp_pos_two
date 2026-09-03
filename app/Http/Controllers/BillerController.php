<?php

namespace App\Http\Controllers;

use App\Services\BillerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class BillerController extends Controller
{
    protected BillerService $billerService;

    public function __construct(BillerService $billerService)
    {
        $this->billerService = $billerService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('billers-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }
            $lims_biller_all = $this->billerService->getActiveBillers();
            return view('backend.biller.index', compact('lims_biller_all', 'all_permission'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('billers-add')) {
            return view('backend.biller.create');
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'company_name' => [
                'max:255',
                Rule::unique('billers')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'email' => [
                'email',
                'max:255',
                Rule::unique('billers')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:10000',
        ]);

        $result = $this->billerService->createBiller($request->all(), $request->file('image'));

        return redirect('biller')->with('message', $result['message']);
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('billers-edit')) {
            $lims_biller_data = $this->billerService->getBillerById($id);
            return view('backend.biller.edit', compact('lims_biller_data'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'company_name' => [
                'max:255',
                Rule::unique('billers')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'email' => [
                'email',
                'max:255',
                Rule::unique('billers')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

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
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('billers-delete')) {
            return 'Sorry! You are not allowed to delete biller';
        }

        $biller_id = $request['billerIdArray'] ?? [];
        $this->billerService->deleteMultipleBillers($biller_id);

        return 'Biller deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('billers-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete biller');
        }

        $this->billerService->deleteBiller($id);

        return redirect('biller')->with('not_permitted', 'Data deleted successfully');
    }
}
