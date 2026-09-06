<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CheckPermission
{
    /**
     * Handle an incoming request and check if user's role has the required permission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->guest('login');
        }

        // Super Admin (1) and Admin (2) always have full access
        if ($user->role_id <= 2) {
            return $next($request);
        }

        // Check if user's role has any of the piped permissions (e.g. 'category-index|category')
        $permissions = explode('|', $permission);
        $role = Role::find($user->role_id);

        if ($role) {
            foreach ($permissions as $perm) {
                try {
                    if ($role->hasPermissionTo(trim($perm))) {
                        return $next($request);
                    }
                } catch (\Throwable $e) {
                    // Permission not registered in DB; check next fallback or safely deny
                }
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response('Sorry! You are not allowed to access this module', 403);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
}
