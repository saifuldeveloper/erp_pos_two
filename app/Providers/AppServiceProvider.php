<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Support\Facades\URL;
use App\Services\AvijatriService;

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
        $this->app->singleton(AvijatriService::class, function ($app) {
            return new AvijatriService();
        });
    }

    public function boot()
    {
        // Schema::defaultStringLength(191);
    }
}
