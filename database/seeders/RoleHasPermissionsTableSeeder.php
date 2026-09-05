<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleHasPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Clear existing role permissions
        DB::table('role_has_permissions')->truncate();

        $allPermissions = Permission::all();
        $allPermissionNames = $allPermissions->pluck('name')->toArray();

        // Helper to get permission IDs by list of names
        $getPermissionIds = function (array $names) use ($allPermissions) {
            return $allPermissions->whereIn('name', $names)->pluck('id')->toArray();
        };

        // ----------------------------------------------------
        // 1. Admin (ID: 1) - FULL ACCESS (All Permissions)
        // ----------------------------------------------------
        $adminRole = Role::find(1);
        if ($adminRole) {
            $adminRole->syncPermissions($allPermissionNames);
        }

        // ----------------------------------------------------
        // 2. Owner (ID: 2) - FULL ACCESS (All Permissions)
        // ----------------------------------------------------
        $ownerRole = Role::find(2);
        if ($ownerRole) {
            $ownerRole->syncPermissions($allPermissionNames);
        }

        // ----------------------------------------------------
        // 3. Manager (ID: 3) - All permissions EXCEPT any DELETE & system configs
        // ----------------------------------------------------
        $managerRole = Role::find(3);
        if ($managerRole) {
            // Filter out any permission containing "-delete" or sensitive system configs
            $managerPermissions = array_filter($allPermissionNames, function ($permission) {
                // Strictly exclude any delete action
                if (str_contains($permission, '-delete') || str_contains($permission, 'delete_')) {
                    return false;
                }
                // Exclude system dangerous permissions
                if (in_array($permission, ['empty_database', 'backup_database', 'role'])) {
                    return false;
                }
                return true;
            });

            $managerRole->syncPermissions(array_values($managerPermissions));
        }

        // ----------------------------------------------------
        // 4. Billers (ID: 5) - Billing / Sales / Customer access (NO DELETE, NO SENSITIVE ACTIONS)
        // ----------------------------------------------------
        $billerRole = Role::find(5);
        if ($billerRole) {
            $billerPermissions = [
                // Products / Catalog view
                'products-index',
                'category-index',
                'category',
                'brand-index',
                'brand',
                'unit-index',
                'unit',
                'color-index',
                'print_barcode',
                // Sales / POS
                'sales-index',
                'sales-add',
                'sales-edit',
                'sale-payment-index',
                'sale-payment-add',
                'sale-payment-edit',
                'coupon',
                'delivery',
                // Customer management
                'customers-index',
                'customers-add',
                'customers-edit',
                // Return & Expense
                'returns-index',
                'returns-add',
                'expenses-index',
                'expenses-add',
                'expense_category-index',
                'expense_category-add',
                'expense_category-edit',
                // Waste & Warehouse view
                'waste-index',
                'waste-add',
                'warehouse-index',
                // Reports
                'today_sale',
                'daily-sale',
                'due-report',
            ];

            // Ensure no delete permissions in biller list
            $billerPermissions = array_filter($billerPermissions, function ($p) {
                return !str_contains($p, 'delete');
            });

            $billerRole->syncPermissions(array_values($billerPermissions));
        }

        // ----------------------------------------------------
        // 5. Salesman (ID: 7) - POS / Basic Sales access (NO DELETE)
        // ----------------------------------------------------
        $salesmanRole = Role::find(7);
        if ($salesmanRole) {
            $salesmanPermissions = [
                'products-index',
                'category-index',
                'brand-index',
                'sales-index',
                'sales-add',
                'sale-payment-index',
                'sale-payment-add',
                'customers-index',
                'customers-add',
                'today_sale',
            ];

            $salesmanRole->syncPermissions($salesmanPermissions);
        }

        // ----------------------------------------------------
        // 6. Management (ID: 8) - Same as Manager (NO DELETE)
        // ----------------------------------------------------
        $managementRole = Role::find(8);
        if ($managementRole) {
            $managementPermissions = array_filter($allPermissionNames, function ($permission) {
                return !str_contains($permission, '-delete') && !in_array($permission, ['empty_database', 'backup_database']);
            });

            $managementRole->syncPermissions(array_values($managementPermissions));
        }

        // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}