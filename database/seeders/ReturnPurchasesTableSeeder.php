<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReturnPurchasesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('return_purchases')->delete();
        
        \DB::table('return_purchases')->insert(array (
            0 => 
            array (
                'id' => 1,
                'reference_no' => 'prr-20250114-043756',
                'supplier_id' => 2,
                'warehouse_id' => 1,
                'user_id' => 1,
                'purchase_id' => 388,
                'account_id' => 1,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'item' => 5,
                'total_qty' => 6.0,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_cost' => 12450.0,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'grand_total' => 12450.0,
                'document' => NULL,
                'return_note' => NULL,
                'staff_note' => NULL,
                'created_at' => '2025-01-14 16:37:56',
                'updated_at' => '2025-01-14 16:37:56',
            ),
            1 => 
            array (
                'id' => 2,
                'reference_no' => 'prr-20250123-042255',
                'supplier_id' => 2,
                'warehouse_id' => 1,
                'user_id' => 3,
                'purchase_id' => 11,
                'account_id' => 1,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'item' => 4,
                'total_qty' => 6.0,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_cost' => 9600.0,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'grand_total' => 9600.0,
                'document' => NULL,
                'return_note' => NULL,
                'staff_note' => NULL,
                'created_at' => '2025-01-23 16:22:55',
                'updated_at' => '2025-01-23 16:22:55',
            ),
            2 => 
            array (
                'id' => 3,
                'reference_no' => 'prr-20250123-042430',
                'supplier_id' => 2,
                'warehouse_id' => 1,
                'user_id' => 3,
                'purchase_id' => 14,
                'account_id' => 1,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'item' => 5,
                'total_qty' => 6.0,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_cost' => 9600.0,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'grand_total' => 9600.0,
                'document' => NULL,
                'return_note' => NULL,
                'staff_note' => NULL,
                'created_at' => '2025-01-23 16:24:30',
                'updated_at' => '2025-01-23 16:24:30',
            ),
            3 => 
            array (
                'id' => 4,
                'reference_no' => 'prr-20250125-065221',
                'supplier_id' => 2,
                'warehouse_id' => 1,
                'user_id' => 1,
                'purchase_id' => 386,
                'account_id' => 1,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'item' => 1,
                'total_qty' => 1.0,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_cost' => 2075.0,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'grand_total' => 2075.0,
                'document' => NULL,
                'return_note' => NULL,
                'staff_note' => NULL,
                'created_at' => '2025-01-25 18:52:21',
                'updated_at' => '2025-01-25 18:52:21',
            ),
        ));
        
        
    }
}