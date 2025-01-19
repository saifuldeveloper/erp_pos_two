<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseProductReturnTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_product_return')->delete();
        
        \DB::table('purchase_product_return')->insert(array (
            0 => 
            array (
                'id' => 1,
                'return_id' => 1,
                'product_id' => 388,
                'product_batch_id' => NULL,
                'variant_id' => 355,
                'imei_number' => NULL,
                'qty' => 1.0,
                'purchase_unit_id' => 1,
                'net_unit_cost' => 2075.0,
                'discount' => 0.0,
                'tax_rate' => 0.0,
                'tax' => 0.0,
                'total' => 2075.0,
                'created_at' => '2025-01-14 16:37:56',
                'updated_at' => '2025-01-14 16:37:56',
            ),
            1 => 
            array (
                'id' => 2,
                'return_id' => 1,
                'product_id' => 388,
                'product_batch_id' => NULL,
                'variant_id' => 355,
                'imei_number' => NULL,
                'qty' => 1.0,
                'purchase_unit_id' => 1,
                'net_unit_cost' => 2075.0,
                'discount' => 0.0,
                'tax_rate' => 0.0,
                'tax' => 0.0,
                'total' => 2075.0,
                'created_at' => '2025-01-14 16:37:56',
                'updated_at' => '2025-01-14 16:37:56',
            ),
            2 => 
            array (
                'id' => 3,
                'return_id' => 1,
                'product_id' => 388,
                'product_batch_id' => NULL,
                'variant_id' => 355,
                'imei_number' => NULL,
                'qty' => 1.0,
                'purchase_unit_id' => 1,
                'net_unit_cost' => 2075.0,
                'discount' => 0.0,
                'tax_rate' => 0.0,
                'tax' => 0.0,
                'total' => 2075.0,
                'created_at' => '2025-01-14 16:37:56',
                'updated_at' => '2025-01-14 16:37:56',
            ),
            3 => 
            array (
                'id' => 4,
                'return_id' => 1,
                'product_id' => 388,
                'product_batch_id' => NULL,
                'variant_id' => 355,
                'imei_number' => NULL,
                'qty' => 1.0,
                'purchase_unit_id' => 1,
                'net_unit_cost' => 2075.0,
                'discount' => 0.0,
                'tax_rate' => 0.0,
                'tax' => 0.0,
                'total' => 2075.0,
                'created_at' => '2025-01-14 16:37:56',
                'updated_at' => '2025-01-14 16:37:56',
            ),
            4 => 
            array (
                'id' => 5,
                'return_id' => 1,
                'product_id' => 388,
                'product_batch_id' => NULL,
                'variant_id' => 352,
                'imei_number' => NULL,
                'qty' => 2.0,
                'purchase_unit_id' => 1,
                'net_unit_cost' => 2075.0,
                'discount' => 0.0,
                'tax_rate' => 0.0,
                'tax' => 0.0,
                'total' => 2075.0,
                'created_at' => '2025-01-14 16:37:56',
                'updated_at' => '2025-01-14 16:37:56',
            ),
        ));
        
        
    }
}