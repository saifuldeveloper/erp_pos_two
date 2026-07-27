<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSalesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_sales')->delete();
        
        \DB::table('product_sales')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sale_id' => 1,
                'product_id' => 3,
                'product_batch_id' => NULL,
                'variant_id' => NULL,
                'imei_number' => NULL,
                'qty' => 1.0,
                'return_qty' => 0.0,
                'sale_unit_id' => 1,
                'net_unit_price' => 1500.0,
                'discount' => 0.0,
                'tax_rate' => 0.0,
                'tax' => 0.0,
                'total' => 1500.0,
                'created_at' => '2026-06-28 13:38:20',
                'updated_at' => '2026-06-28 13:38:20',
            ),
            1 => 
            array (
                'id' => 2,
                'sale_id' => 2,
                'product_id' => 7,
                'product_batch_id' => NULL,
                'variant_id' => 16,
                'imei_number' => NULL,
                'qty' => 1.0,
                'return_qty' => 0.0,
                'sale_unit_id' => 1,
                'net_unit_price' => 2000.0,
                'discount' => 0.0,
                'tax_rate' => 0.0,
                'tax' => 0.0,
                'total' => 2000.0,
                'created_at' => '2026-07-26 17:48:21',
                'updated_at' => '2026-07-26 17:48:21',
            ),
        ));
        
        
    }
}