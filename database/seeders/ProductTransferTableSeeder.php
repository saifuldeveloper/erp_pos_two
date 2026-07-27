<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductTransferTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_transfer')->delete();
        
        \DB::table('product_transfer')->insert(array (
            0 => 
            array (
                'id' => 1,
                'transfer_id' => 1,
                'product_id' => 7,
                'product_batch_id' => NULL,
                'variant_id' => 16,
                'imei_number' => NULL,
                'qty' => 1.0,
                'purchase_unit_id' => 1,
                'net_unit_cost' => 1000.0,
                'tax_rate' => 0.0,
                'tax' => 0.0,
                'total' => 1000.0,
                'created_at' => '2026-07-26 17:48:21',
                'updated_at' => '2026-07-26 17:48:21',
            ),
        ));
        
        
    }
}