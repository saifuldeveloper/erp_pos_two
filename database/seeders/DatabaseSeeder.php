<?php

use Database\Seeders\CurrenciesTableSeeder;
use Database\Seeders\GeneralSettingsTableSeeder;
use Database\Seeders\HrmSettingsTableSeeder;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\PosSettingTableSeeder;
use Database\Seeders\RoleHasPermissionsTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\AccountsTableSeeder;
use Database\Seeders\BillersTableSeeder;
use Database\Seeders\BrandsTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\CustomersTableSeeder;
use Database\Seeders\SuppliersTableSeeder;
use Database\Seeders\UnitsTableSeeder;
use Database\Seeders\WarehousesTableSeeder;
use Database\Seeders\CustomerGroupsTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([CountriesTableSeeder::class]);
        $this->call([
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            RoleHasPermissionsTableSeeder::class,
            UsersTableSeeder::class,
            CurrenciesTableSeeder::class,
            GeneralSettingsTableSeeder::class,
            AccountsTableSeeder::class,
            BillersTableSeeder::class,
            BrandsTableSeeder::class,
            CustomerGroupsTableSeeder::class,
            CategoriesTableSeeder::class,
            CustomersTableSeeder::class,
            SuppliersTableSeeder::class,
            UnitsTableSeeder::class,
            WarehousesTableSeeder::class,
            PosSettingTableSeeder::class,
            HrmSettingsTableSeeder::class
        ]);

        $this->call(HrmSettingsTableSeeder::class);
    }
}
