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
use App\Repositories\Contracts\PurchaseRepositoryInterface;
use App\Repositories\Eloquent\PurchaseRepository;
use App\Repositories\Contracts\ReturnPurchaseRepositoryInterface;
use App\Repositories\Eloquent\ReturnPurchaseRepository;
use App\Repositories\Contracts\TransferRepositoryInterface;
use App\Repositories\Eloquent\TransferRepository;
use App\Repositories\Contracts\AdjustmentRepositoryInterface;
use App\Repositories\Eloquent\AdjustmentRepository;
use App\Repositories\Contracts\StockCountRepositoryInterface;
use App\Repositories\Eloquent\StockCountRepository;
use App\Repositories\Contracts\WasteRepositoryInterface;
use App\Repositories\Eloquent\WasteRepository;
use App\Repositories\Contracts\CashRegisterRepositoryInterface;
use App\Repositories\Eloquent\CashRegisterRepository;
use App\Repositories\Contracts\CourierRepositoryInterface;
use App\Repositories\Eloquent\CourierRepository;
use App\Repositories\Contracts\QuotationRepositoryInterface;
use App\Repositories\Eloquent\QuotationRepository;
use App\Repositories\Contracts\DeliveryRepositoryInterface;
use App\Repositories\Eloquent\DeliveryRepository;
use App\Repositories\Contracts\ReturnRepositoryInterface;
use App\Repositories\Eloquent\ReturnRepository;
use App\Repositories\Contracts\SaleRepositoryInterface;
use App\Repositories\Eloquent\SaleRepository;
use App\Repositories\Contracts\DiscountPlanRepositoryInterface;
use App\Repositories\Eloquent\DiscountPlanRepository;
use App\Repositories\Contracts\DiscountRepositoryInterface;
use App\Repositories\Eloquent\DiscountRepository;
use App\Repositories\Contracts\CouponRepositoryInterface;
use App\Repositories\Eloquent\CouponRepository;
use App\Repositories\Contracts\GiftCardRepositoryInterface;
use App\Repositories\Eloquent\GiftCardRepository;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Repositories\Eloquent\DepartmentRepository;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Repositories\Eloquent\EmployeeRepository;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Repositories\Eloquent\AttendanceRepository;
use App\Repositories\Contracts\HolidayRepositoryInterface;
use App\Repositories\Eloquent\HolidayRepository;
use App\Repositories\Contracts\PayrollTypeRepositoryInterface;
use App\Repositories\Eloquent\PayrollTypeRepository;
use App\Repositories\Contracts\PayrollRepositoryInterface;
use App\Repositories\Eloquent\PayrollRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use App\Repositories\Eloquent\CurrencyRepository;
use App\Repositories\Contracts\CustomFieldRepositoryInterface;
use App\Repositories\Eloquent\CustomFieldRepository;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Eloquent\TableRepository;

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
        PurchaseRepositoryInterface::class        => PurchaseRepository::class,
        ReturnPurchaseRepositoryInterface::class  => ReturnPurchaseRepository::class,
        TransferRepositoryInterface::class        => TransferRepository::class,
        AdjustmentRepositoryInterface::class      => AdjustmentRepository::class,
        StockCountRepositoryInterface::class      => StockCountRepository::class,
        WasteRepositoryInterface::class           => WasteRepository::class,
        CashRegisterRepositoryInterface::class    => CashRegisterRepository::class,
        CourierRepositoryInterface::class         => CourierRepository::class,
        QuotationRepositoryInterface::class       => QuotationRepository::class,
        DeliveryRepositoryInterface::class        => DeliveryRepository::class,
        ReturnRepositoryInterface::class          => ReturnRepository::class,
        SaleRepositoryInterface::class            => SaleRepository::class,
        DiscountPlanRepositoryInterface::class    => DiscountPlanRepository::class,
        DiscountRepositoryInterface::class        => DiscountRepository::class,
        CouponRepositoryInterface::class          => CouponRepository::class,
        GiftCardRepositoryInterface::class        => GiftCardRepository::class,
        DepartmentRepositoryInterface::class      => DepartmentRepository::class,
        EmployeeRepositoryInterface::class        => EmployeeRepository::class,
        AttendanceRepositoryInterface::class      => AttendanceRepository::class,
        HolidayRepositoryInterface::class         => HolidayRepository::class,
        PayrollTypeRepositoryInterface::class     => PayrollTypeRepository::class,
        PayrollRepositoryInterface::class         => PayrollRepository::class,
        UserRepositoryInterface::class            => UserRepository::class,
        RoleRepositoryInterface::class            => RoleRepository::class,
        CurrencyRepositoryInterface::class        => CurrencyRepository::class,
        CustomFieldRepositoryInterface::class     => CustomFieldRepository::class,
        TableRepositoryInterface::class           => TableRepository::class,
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
