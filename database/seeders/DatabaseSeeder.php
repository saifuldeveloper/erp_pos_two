<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AccountsTableSeeder::class);
        $this->call(AdjustmentsTableSeeder::class);
        $this->call(AttendancesTableSeeder::class);
        $this->call(BillersTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
        $this->call(CashRegistersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ColorsTableSeeder::class);
        $this->call(CouponsTableSeeder::class);
        $this->call(CouriersTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(CustomFieldsTableSeeder::class);
        $this->call(CustomerGroupsTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(DeliveriesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(DepositsTableSeeder::class);
        $this->call(DiscountPlanCustomersTableSeeder::class);
        $this->call(DiscountPlanDiscountsTableSeeder::class);
        $this->call(DiscountPlansTableSeeder::class);
        $this->call(DiscountsTableSeeder::class);
        $this->call(DsoAlertsTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(ExpenseCategoriesTableSeeder::class);
        $this->call(ExpensesTableSeeder::class);
        $this->call(GeneralSettingsTableSeeder::class);
        $this->call(GiftCardRechargesTableSeeder::class);
        $this->call(GiftCardsTableSeeder::class);
        $this->call(GiftReceivesTableSeeder::class);
        $this->call(HolidaysTableSeeder::class);
        $this->call(HrmSettingsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(MailSettingsTableSeeder::class);
        $this->call(MoneyTransfersTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
        $this->call(PaymentWithChequeTableSeeder::class);
        $this->call(PaymentWithCreditCardTableSeeder::class);
        $this->call(PaymentWithGiftCardTableSeeder::class);
        $this->call(PaymentWithPaypalTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(PayrollsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PosSettingTableSeeder::class);
        $this->call(ProductAdjustmentsTableSeeder::class);
        $this->call(ProductBatchesTableSeeder::class);
        $this->call(ProductImagesTableSeeder::class);
        $this->call(ProductPurchasesTableSeeder::class);
        $this->call(ProductQuotationTableSeeder::class);
        $this->call(ProductReturnsTableSeeder::class);
        $this->call(ProductSalesTableSeeder::class);
        $this->call(ProductTransferTableSeeder::class);
        $this->call(ProductVariantsTableSeeder::class);
        $this->call(ProductWarehouseTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(PurchaseProductReturnTableSeeder::class);
        $this->call(PurchasesTableSeeder::class);
        $this->call(QuotationsTableSeeder::class);
        $this->call(ReturnPurchasesTableSeeder::class);
        $this->call(ReturnsTableSeeder::class);
        $this->call(RewardPointSettingsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(SalesTableSeeder::class);
        $this->call(SuppliersTableSeeder::class);
        $this->call(TablesTableSeeder::class);
        $this->call(TaxesTableSeeder::class);
        $this->call(TransfersTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(VariantsTableSeeder::class);
        $this->call(WarehousesTableSeeder::class);
        $this->call(WasteItemsTableSeeder::class);
        $this->call(WastesTableSeeder::class);
    }
}
