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
                'name' => 'Main Warehouse',
                'phone' => '01770921384',
                'email' => 'warehouse@gmail.com',
                'address' => 'Dhaka, Bangladesh',
                'is_active' => 1,
                'created_at' => '2024-10-07 18:21:51',
                'updated_at' => '2024-10-07 18:21:51',
            ),
        ));
        
        
    }
}