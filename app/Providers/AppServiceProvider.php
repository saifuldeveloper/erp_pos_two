<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Services\AvijatryService;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Supplier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AvijatryService::class, function ($app) {
            return new AvijatryService();
        });
    }

    public function boot()
    {
        // Schema::defaultStringLength(191);
        View::composer(['backend.layouts.app', 'backend.auth.*'], function ($view) {
            $general_setting = Cache::remember('general_setting', 60 * 60 * 24, function () {
                return DB::table('general_settings')->latest()->first();
            });
            $view->with('general_setting', $general_setting);
        });

        View::composer(['backend.layout.top-head', 'backend.layout.top-head-rtl'], function ($view) {
            $view->with([
                'top_head_users' => Cache::remember('top_head_users', 60 * 60, function () {
                    return User::where('is_active', true)->select('id', 'name', 'email', 'phone')->get();
                }),
                'top_head_customers' => Cache::remember('top_head_customers', 60 * 60, function () {
                    return Customer::where('is_active', true)->select('id', 'name', 'phone_number')->get();
                }),
                'top_head_customer_groups' => Cache::remember('top_head_customer_groups', 60 * 60 * 24, function () {
                    return CustomerGroup::where('is_active', true)->select('id', 'name')->get();
                }),
                'top_head_suppliers' => Cache::remember('top_head_suppliers', 60 * 60, function () {
                    return Supplier::where('is_active', true)->select('id', 'name', 'phone_number')->get();
                }),
            ]);
        });
    }
}
