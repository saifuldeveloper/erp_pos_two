<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Eloquent\BrandRepository;
use App\Repositories\Contracts\ColorRepositoryInterface;
use App\Repositories\Eloquent\ColorRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Contracts\UnitRepositoryInterface;
use App\Repositories\Eloquent\UnitRepository;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\ProductRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public array $bindings = [
        BrandRepositoryInterface::class    => BrandRepository::class,
        ColorRepositoryInterface::class    => ColorRepository::class,
        CategoryRepositoryInterface::class => CategoryRepository::class,
        UnitRepositoryInterface::class     => UnitRepository::class,
        ProductRepositoryInterface::class  => ProductRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->bindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
