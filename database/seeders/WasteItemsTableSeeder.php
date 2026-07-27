<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WasteItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('waste_items')->delete();
        
        \DB::table('waste_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'waste_id' => 1,
                'product_id' => 2,
                'varient_code' => NULL,
                'qty' => 1,
                'unit_price' => 1500.0,
                'subtotal' => 1500.0,
                'created_at' => '2026-06-28 13:48:51',
                'updated_at' => '2026-06-28 13:48:51',
            ),
        ));
        
        
    }
}