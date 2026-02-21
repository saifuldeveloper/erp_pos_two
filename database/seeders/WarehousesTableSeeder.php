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
                'name' => 'Khulna Warehouse',
                'phone' => '0123456789',
                'email' => 'khulnaavijatry@gmail.com',
                'address' => 'Dak Bangla, Khulna',
                'is_active' => 1,
                'created_at' => '2024-10-07 12:21:51',
                'updated_at' => '2025-01-07 06:34:48',
                'is_default' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Khulna',
                'phone' => '1',
                'email' => 'khulna@avijatry.com',
                'address' => 'Khulna',
                'is_active' => 0,
                'created_at' => '2024-12-21 00:56:12',
                'updated_at' => '2024-12-22 22:24:44',
                'is_default' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Cumilla',
                'phone' => '2',
                'email' => 'cumilla@avijatry.com',
                'address' => 'Kandirpar, Cumilla',
                'is_active' => 0,
                'created_at' => '2024-12-21 00:56:43',
                'updated_at' => '2024-12-22 22:04:11',
                'is_default' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Godawon',
                'phone' => '1234567890',
                'email' => 'info.avijatrykhulna@gmail.com',
                'address' => 'Dak Bangla Mor, Khulna',
                'is_active' => 1,
                'created_at' => '2025-01-22 06:22:58',
                'updated_at' => '2025-01-22 06:22:58',
                'is_default' => 1,
            ),
        ));
        
        
    }
}