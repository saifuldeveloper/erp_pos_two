<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WarehousesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('warehouses')->delete();
        
        \DB::table('warehouses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Comilla Warehouse',
                'phone' => '01629166721',
                'email' => NULL,
                'address' => 'Kandirpar, Comilla',
                'is_active' => 1,
                'created_at' => '2025-04-19 17:20:40',
                'updated_at' => '2025-04-19 17:20:40',
                'is_default' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Comilla Discount',
                'phone' => '01629166721',
                'email' => 'comilladiscount@gmail.com',
                'address' => 'Kandirpar, Comilla',
                'is_active' => 1,
                'created_at' => '2025-04-21 16:07:06',
                'updated_at' => '2025-04-21 16:07:32',
                'is_default' => 1,
            ),
        ));
        
        
    }
}