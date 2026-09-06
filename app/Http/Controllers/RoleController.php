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
        $this->ensureRolePermissionExists();
    }

    /**
     * Ensure the Spatie permission for role management exists
     */
    protected function ensureRolePermissionExists(): void
    {
        try {
            $perm = Permission::firstOrCreate(['name' => 'role-permission', 'guard_name' => 'web']);
            $mgmtRole = Role::where('name', 'Management')->first();
            if ($mgmtRole && !$mgmtRole->hasPermissionTo('role-permission')) {
                $mgmtRole->givePermissionTo($perm);
            }
        } catch (\Throwable $e) {
            // DB not ready or during migration
        }
    }

    /**
     * Determine if current user is authorized to manage roles and permissions
     */
    protected function canManageRoles(): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        // Super Admin (1) and Admin (2) always have access
        if ($user->role_id <= 2) {
            return true;
        }

        // Management role
        $roleModel = Roles::find($user->role_id);
        if ($roleModel && (strtolower($roleModel->name) === 'management' || $roleModel->id == 8)) {
            return true;
        }

        // Check if role has 'role-permission' Spatie permission
        $spatieRole = Role::find($user->role_id);
        if ($spatieRole && $spatieRole->permissions->where('name', 'role-permission')->isNotEmpty()) {
            return true;
        }

        return false;
    }

    public function index()
    {
        if ($this->canManageRoles()) {
            $lims_role_all = $this->roleService->getActiveRoles();
            return view('backend.role.create', compact('lims_role_all'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(StoreRoleRequest $request)
    {
        if (!$this->canManageRoles()) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }

        $this->roleService->createRole($request->all());

        return redirect('role')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        if ($this->canManageRoles()) {
            return Roles::find($id);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        if (!$this->canManageRoles()) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }

        // Prevent non-admins from modifying Admin or Owner roles
        if (Auth::user()->role_id > 2 && in_array($request->role_id, [1, 2])) {
            return redirect()->back()->with('not_permitted', 'You are not allowed to modify Admin roles');
        }

        $this->roleService->updateRole($request->role_id, $request->all());

        return redirect('role')->with('message', 'Data updated successfully');
    }

    public function permission($id)
    {
        if ($this->canManageRoles()) {
            // Prevent non-admins from editing Admin or Owner role permissions
            if (Auth::user()->role_id > 2 && in_array($id, [1, 2])) {
                return redirect()->back()->with('not_permitted', 'You cannot modify Admin role permissions');
            }

            $data = $this->roleService->getRolePermissionsData($id);
            return view('backend.role.permission', $data);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function setPermission(Request $request)
    {
        if (!$this->canManageRoles()) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }

        // Prevent non-admins from editing Admin or Owner role permissions
        if (Auth::user()->role_id > 2 && in_array($request['role_id'], [1, 2])) {
            return redirect()->back()->with('not_permitted', 'You cannot modify Admin role permissions');
        }

        $lims_role_data = Roles::findOrFail($request['role_id']);
        $role = Role::firstOrCreate(['name' => $lims_role_data->name, 'guard_name' => 'web']);
        $allPermissions = Permission::all();

        $permissionsToSync = [];
        foreach ($allPermissions as $p) {
            if ($request->has($p->name)) {
                $permissionsToSync[] = $p->name;
            }
        }

        $role->syncPermissions($permissionsToSync);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        \Illuminate\Support\Facades\Cache::forget('role_permissions_list_' . $request['role_id']);
        \Illuminate\Support\Facades\Cache::forget('role_has_permissions_raw_' . $request['role_id']);
        \Illuminate\Support\Facades\Cache::forget('all_permissions_list');

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
