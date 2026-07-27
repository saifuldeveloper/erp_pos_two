<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SalesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sales')->delete();
        
        \DB::table('sales')->insert(array (
            0 => 
            array (
                'id' => 1,
                'reference_no' => 'posr-20260628-013820',
                'user_id' => 1,
                'cash_register_id' => NULL,
                'table_id' => NULL,
                'queue' => NULL,
                'customer_id' => 2,
                'warehouse_id' => 1,
                'biller_id' => 4,
                'item' => 1,
                'total_qty' => 1.0,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_price' => 1500.0,
                'grand_total' => 1350.0,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'order_discount_type' => 'Percentage',
                'order_discount_value' => 10.0,
                'order_discount' => 150.0,
                'coupon_id' => NULL,
                'coupon_discount' => NULL,
                'shipping_cost' => 0.0,
                'sale_status' => 3,
                'sale_type' => NULL,
                'payment_status' => 2,
                'document' => NULL,
                'paid_amount' => NULL,
                'payment_note' => NULL,
                'sale_note' => NULL,
                'staff_note' => NULL,
                'created_at' => '2026-06-28 13:38:20',
                'updated_at' => '2026-06-28 13:38:20',
            ),
            1 => 
            array (
                'id' => 2,
                'reference_no' => 'posr-20260726-054821',
                'user_id' => 1,
                'cash_register_id' => NULL,
                'table_id' => NULL,
                'queue' => NULL,
                'customer_id' => 4,
                'warehouse_id' => 1,
                'biller_id' => 1,
                'item' => 1,
                'total_qty' => 1.0,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_price' => 2000.0,
                'grand_total' => 2000.0,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'order_discount_type' => 'Flat',
                'order_discount_value' => NULL,
                'order_discount' => 0.0,
                'coupon_id' => NULL,
                'coupon_discount' => NULL,
                'shipping_cost' => 0.0,
                'sale_status' => 1,
                'sale_type' => NULL,
                'payment_status' => 4,
                'document' => NULL,
                'paid_amount' => 2000.0,
                'payment_note' => NULL,
                'sale_note' => NULL,
                'staff_note' => NULL,
                'created_at' => '2026-07-26 17:48:21',
                'updated_at' => '2026-07-26 17:48:21',
            ),
        ));
        
        
    }
}