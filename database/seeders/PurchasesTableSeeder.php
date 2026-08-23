<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchasesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchases')->delete();
        
        \DB::table('purchases')->insert(array (
            0 => 
            array (
                'id' => 1,
                'reference_no' => 'pr-20260822-014103',
                'warehouse_id' => 1,
                'supplier_id' => 1,
                'item' => 25,
                'total_qty' => 26,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_cost' => 8700.0,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'order_discount' => 0.0,
                'shipping_cost' => 0.0,
                'grand_total' => 8700.0,
                'paid_amount' => 0.0,
                'status' => 1,
                'payment_status' => 1,
                'document' => NULL,
                'note' => NULL,
                'user_id' => 1,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'created_at' => '2026-08-22 13:41:03',
                'updated_at' => '2026-08-22 13:41:03',
            ),
            1 => 
            array (
                'id' => 2,
                'reference_no' => 'pr-20260822-034215',
                'warehouse_id' => 2,
                'supplier_id' => 1,
                'item' => 25,
                'total_qty' => 25,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_cost' => 8200.0,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'order_discount' => 0.0,
                'shipping_cost' => 0.0,
                'grand_total' => 8200.0,
                'paid_amount' => 0.0,
                'status' => 1,
                'payment_status' => 1,
                'document' => NULL,
                'note' => NULL,
                'user_id' => 1,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'created_at' => '2026-08-22 15:42:15',
                'updated_at' => '2026-08-22 15:42:15',
            ),
        ));
        
        
    }
}