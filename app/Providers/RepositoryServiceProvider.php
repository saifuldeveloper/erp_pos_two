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
use App\Repositories\Contracts\WarehouseRepositoryInterface;
use App\Repositories\Eloquent\WarehouseRepository;
use App\Repositories\Contracts\TaxRepositoryInterface;
use App\Repositories\Eloquent\TaxRepository;
use App\Repositories\Contracts\CustomerGroupRepositoryInterface;
use App\Repositories\Eloquent\CustomerGroupRepository;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use App\Repositories\Eloquent\SupplierRepository;
use App\Repositories\Contracts\BillerRepositoryInterface;
use App\Repositories\Eloquent\BillerRepository;
use App\Repositories\Contracts\ExpenseCategoryRepositoryInterface;
use App\Repositories\Eloquent\ExpenseCategoryRepository;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use App\Repositories\Eloquent\ExpenseRepository;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Eloquent\AccountRepository;
use App\Repositories\Contracts\MoneyTransferRepositoryInterface;
use App\Repositories\Eloquent\MoneyTransferRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public array $bindings = [
        BrandRepositoryInterface::class           => BrandRepository::class,
        ColorRepositoryInterface::class           => ColorRepository::class,
        CategoryRepositoryInterface::class        => CategoryRepository::class,
        UnitRepositoryInterface::class            => UnitRepository::class,
        ProductRepositoryInterface::class         => ProductRepository::class,
        WarehouseRepositoryInterface::class       => WarehouseRepository::class,
        TaxRepositoryInterface::class             => TaxRepository::class,
        CustomerGroupRepositoryInterface::class   => CustomerGroupRepository::class,
        CustomerRepositoryInterface::class        => CustomerRepository::class,
        SupplierRepositoryInterface::class        => SupplierRepository::class,
        BillerRepositoryInterface::class          => BillerRepository::class,
        ExpenseCategoryRepositoryInterface::class => ExpenseCategoryRepository::class,
        ExpenseRepositoryInterface::class         => ExpenseRepository::class,
        AccountRepositoryInterface::class         => AccountRepository::class,
        MoneyTransferRepositoryInterface::class   => MoneyTransferRepository::class,
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
