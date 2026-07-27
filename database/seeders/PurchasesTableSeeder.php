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
                'reference_no' => 'pr-20260628-010011',
                'user_id' => 1,
                'warehouse_id' => 2,
                'supplier_id' => NULL,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'item' => 1,
                'total_qty' => 6,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_cost' => 6000.0,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'order_discount' => 0.0,
                'shipping_cost' => 0.0,
                'grand_total' => 6000.0,
                'paid_amount' => 0.0,
                'status' => 1,
                'payment_status' => 1,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-06-28 13:00:11',
                'updated_at' => '2026-06-28 13:00:11',
            ),
            1 => 
            array (
                'id' => 2,
                'reference_no' => 'pr-20260628-010857',
                'user_id' => 1,
                'warehouse_id' => 2,
                'supplier_id' => 1,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'item' => 2,
                'total_qty' => 2,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_cost' => 2000.0,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'order_discount' => 0.0,
                'shipping_cost' => 0.0,
                'grand_total' => 2000.0,
                'paid_amount' => 0.0,
                'status' => 1,
                'payment_status' => 1,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-06-28 13:08:57',
                'updated_at' => '2026-06-28 13:08:57',
            ),
            2 => 
            array (
                'id' => 3,
                'reference_no' => 'pr-20260628-011733',
                'user_id' => 1,
                'warehouse_id' => 2,
                'supplier_id' => 1,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'item' => 1,
                'total_qty' => 6,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_cost' => 6000.0,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'order_discount' => 0.0,
                'shipping_cost' => 0.0,
                'grand_total' => 6000.0,
                'paid_amount' => 0.0,
                'status' => 1,
                'payment_status' => 1,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-06-28 13:17:33',
                'updated_at' => '2026-06-28 13:17:33',
            ),
            3 => 
            array (
                'id' => 4,
                'reference_no' => 'pr-20260726-023700',
                'user_id' => 1,
                'warehouse_id' => 2,
                'supplier_id' => 1,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'item' => 4,
                'total_qty' => 5,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_cost' => 5000.0,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'order_discount' => 0.0,
                'shipping_cost' => 0.0,
                'grand_total' => 5000.0,
                'paid_amount' => 0.0,
                'status' => 1,
                'payment_status' => 1,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-07-26 14:37:00',
                'updated_at' => '2026-07-26 14:37:00',
            ),
            4 => 
            array (
                'id' => 5,
                'reference_no' => 'pr-20260726-024235',
                'user_id' => 1,
                'warehouse_id' => 2,
                'supplier_id' => NULL,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'item' => 10,
                'total_qty' => 12,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_cost' => 24000.0,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'order_discount' => 0.0,
                'shipping_cost' => 0.0,
                'grand_total' => 24000.0,
                'paid_amount' => 0.0,
                'status' => 1,
                'payment_status' => 1,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-07-26 14:42:35',
                'updated_at' => '2026-07-26 14:42:35',
            ),
            5 => 
            array (
                'id' => 6,
                'reference_no' => 'pr-20260726-024301',
                'user_id' => 1,
                'warehouse_id' => 2,
                'supplier_id' => NULL,
                'currency_id' => NULL,
                'exchange_rate' => NULL,
                'item' => 10,
                'total_qty' => 13,
                'total_discount' => 0.0,
                'total_tax' => 0.0,
                'total_cost' => 13000.0,
                'order_tax_rate' => 0.0,
                'order_tax' => 0.0,
                'order_discount' => 0.0,
                'shipping_cost' => 0.0,
                'grand_total' => 13000.0,
                'paid_amount' => 0.0,
                'status' => 1,
                'payment_status' => 1,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-07-26 14:43:01',
                'updated_at' => '2026-07-26 14:43:01',
            ),
        ));
        
        
    }
}