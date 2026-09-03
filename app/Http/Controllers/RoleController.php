<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Roles;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        if (Auth::user()->role_id <= 2) {
            $lims_role_all = $this->roleService->getActiveRoles();
            return view('backend.role.create', compact('lims_role_all'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(StoreRoleRequest $request)
    {
        $this->roleService->createRole($request->all());

        return redirect('role')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        if (Auth::user()->role_id <= 2) {
            return Roles::find($id);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $this->roleService->updateRole($request->role_id, $request->all());

        return redirect('role')->with('message', 'Data updated successfully');
    }

    public function permission($id)
    {
        if (Auth::user()->role_id <= 2) {
            $data = $this->roleService->getRolePermissionsData($id);
            return view('backend.role.permission', $data);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function setPermission(Request $request)
    {
        $role = Role::firstOrCreate(['id' => $request['role_id']]);
        $allPermissions = Permission::all();

        foreach ($allPermissions as $p) {
            if ($request->has($p->name)) {
                if (!$role->hasPermissionTo($p->name)) {
                    $role->givePermissionTo($p);
                }
            } else {
                if ($role->hasPermissionTo($p->name)) {
                    $role->revokePermissionTo($p->name);
                }
            }
        }

        return redirect('role')->with('message', 'Permission updated successfully');
    }

    public function destroy($id)
    {
        if (Auth::user()->role_id <= 2) {
            $this->roleService->deleteRole($id);
            return redirect('role')->with('not_permitted', 'Data deleted successfully');
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
}
