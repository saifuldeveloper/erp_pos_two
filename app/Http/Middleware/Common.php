<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
use Auth;
use Cache;
use Illuminate\Support\Facades\URL;

class Common
{
    public function handle(Request $request, Closure $next)
    {
        // 1. General Setting (Cached for 24h)
        $general_setting = Cache::remember('general_setting', 60 * 60 * 24, function () {
            return DB::table('general_settings')->latest()->first();
        });

        $todayDate = date("Y-m-d");
        if ($general_setting && $general_setting->expiry_date) {
            $expiry_date = date("Y-m-d", strtotime($general_setting->expiry_date));
            if ($todayDate > $expiry_date) {
                auth()->logout();
                return redirect()->route('contactForRenewal');
            }
        }

        // 2. Language setting
        if (isset($_COOKIE['language'])) {
            \App::setLocale($_COOKIE['language']);
        } else {
            \App::setLocale('bn');
        }

        // 3. Theme setting
        if (isset($_COOKIE['theme'])) {
            View::share('theme', $_COOKIE['theme']);
        } else {
            View::share('theme', 'light');
        }

        // 4. Currency (Cached)
        $currency = null;
        if ($general_setting && $general_setting->currency) {
            $currency = Cache::remember('currency_' . $general_setting->currency, 60 * 60 * 24, function () use ($general_setting) {
                return \App\Models\Currency::find($general_setting->currency);
            });
        }

        // 5. Settings (Cached for 24h)
        $pos_setting = Cache::remember('pos_setting', 60 * 60 * 24, function () {
            return DB::table('pos_setting')->latest()->first();
        });

        $reward_point_setting = Cache::remember('reward_point_setting', 60 * 60 * 24, function () {
            return DB::table('reward_point_settings')->latest()->first();
        });

        $mail_setting = Cache::remember('mail_setting', 60 * 60 * 24, function () {
            return DB::table('mail_settings')->latest()->first();
        });

        View::share('general_setting', $general_setting);
        View::share('currency', $currency);
        View::share('pos_setting', $pos_setting);
        View::share('reward_point_setting', $reward_point_setting);
        View::share('mail_setting', $mail_setting);

        if ($general_setting) {
            config([
                'staff_access' => $general_setting->staff_access,
                'date_format' => $general_setting->date_format,
                'currency' => $currency->code ?? '',
                'currency_position' => $general_setting->currency_position,
                'decimal' => $general_setting->decimal,
                'is_zatca' => $general_setting->is_zatca,
                'company_name' => $general_setting->company_name,
                'vat_registration_number' => $general_setting->vat_registration_number,
                'without_stock' => $general_setting->without_stock
            ]);
        }

        // 6. Alert product count (Cached for 10 minutes)
        $alert_product = Cache::remember('alert_product_count', 600, function () {
            return DB::table('products')->where('is_active', true)->whereColumn('alert_quantity', '>', 'qty')->count();
        });

        $dso_alert_product = DB::table('dso_alerts')->select('number_of_products')->whereDate('created_at', date("Y-m-d"))->first();
        $dso_alert_product_no = $dso_alert_product ? $dso_alert_product->number_of_products : 0;
        View::share(['alert_product' => $alert_product, 'dso_alert_product_no' => $dso_alert_product_no]);

        // 7. Role and Permissions for Auth User (Cached per role for 24h)
        if (Auth::check()) {
            $role_id = Auth::user()->role_id;

            $role = Cache::remember('role_obj_' . $role_id, 60 * 60 * 24, function () use ($role_id) {
                return DB::table('roles')->find($role_id);
            });
            View::share('role', $role);

            $permission_list = Cache::remember('all_permissions_list', 60 * 60 * 24, function () {
                return DB::table('permissions')->get();
            });
            View::share('permission_list', $permission_list);

            $role_has_permissions = Cache::remember('role_has_permissions_raw_' . $role_id, 60 * 60 * 24, function () use ($role_id) {
                return DB::table('role_has_permissions')->where('role_id', $role_id)->get();
            });
            View::share('role_has_permissions', $role_has_permissions);

            $role_has_permissions_list = Cache::remember('role_has_permissions_list_' . $role_id, 60 * 60 * 24, function () use ($role_id) {
                return DB::table('permissions')
                    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where('role_id', $role_id)
                    ->select('permissions.name')
                    ->get();
            });
            View::share('role_has_permissions_list', $role_has_permissions_list);

            $all_permission = $role_has_permissions_list->pluck('name')->toArray();
            if (empty($all_permission)) {
                $all_permission = ['dummy text'];
            }
            View::share('all_permission', $all_permission);
        }

        // 8. Root categories list (Cached for 24h)
        $categories_list = Cache::remember('root_categories_list', 60 * 60 * 24, function () {
            return DB::table('categories')
                ->whereNull('parent_id')
                ->where('is_active', 1)
                ->select('id', 'name')
                ->get();
        });
        View::share('categories_list', $categories_list);

        return $next($request);
    }
}
