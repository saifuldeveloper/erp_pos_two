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
                'product_id' => 1023,
                'qty' => 1,
                'unit_price' => 1495.0,
                'subtotal' => 1495.0,
                'created_at' => '2025-03-07 05:35:28',
                'updated_at' => '2025-03-07 05:35:28',
            ),
        ));
        
        
    }
}