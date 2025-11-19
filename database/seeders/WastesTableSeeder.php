<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WastesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('wastes')->delete();
        
        \DB::table('wastes')->insert(array (
            0 => 
            array (
                'id' => 3,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'Black/13-R-86',
                'total_price' => '795.00',
                'status' => 1,
                'created_at' => '2025-04-20 22:55:52',
                'updated_at' => '2025-04-20 22:55:52',
            ),
            1 => 
            array (
                'id' => 4,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'R-131- 39/Black',
                'total_price' => '1595.00',
                'status' => 1,
                'created_at' => '2025-04-21 16:42:37',
                'updated_at' => '2025-04-21 16:42:37',
            ),
            2 => 
            array (
                'id' => 5,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'R-239- 43/Master',
                'total_price' => '1395.00',
                'status' => 1,
                'created_at' => '2025-04-21 18:59:19',
                'updated_at' => '2025-04-21 18:59:19',
            ),
            3 => 
            array (
                'id' => 6,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '1450.00',
                'status' => 1,
                'created_at' => '2025-04-21 18:59:37',
                'updated_at' => '2025-04-21 18:59:37',
            ),
            4 => 
            array (
                'id' => 7,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '1050.00',
                'status' => 1,
                'created_at' => '2025-04-21 21:30:34',
                'updated_at' => '2025-04-21 21:30:34',
            ),
            5 => 
            array (
                'id' => 8,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'R-188-43 CH',
                'total_price' => '795.00',
                'status' => 1,
                'created_at' => '2025-04-21 22:48:10',
                'updated_at' => '2025-04-21 22:48:10',
            ),
            6 => 
            array (
                'id' => 9,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'R-72-41-Black',
                'total_price' => '995.00',
                'status' => 1,
                'created_at' => '2025-04-21 22:48:42',
                'updated_at' => '2025-04-21 22:48:42',
            ),
            7 => 
            array (
                'id' => 10,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'R-66-40-Master',
                'total_price' => '1760.00',
                'status' => 1,
                'created_at' => '2025-04-21 22:49:12',
                'updated_at' => '2025-04-21 22:49:12',
            ),
            8 => 
            array (
                'id' => 11,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '790.00',
                'status' => 1,
                'created_at' => '2025-04-21 23:32:07',
                'updated_at' => '2025-04-21 23:32:07',
            ),
            9 => 
            array (
                'id' => 12,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '4690.00',
                'status' => 1,
                'created_at' => '2025-04-22 03:35:41',
                'updated_at' => '2025-04-22 03:35:41',
            ),
            10 => 
            array (
                'id' => 13,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '975.00',
                'status' => 1,
                'created_at' => '2025-04-22 03:38:24',
                'updated_at' => '2025-04-22 03:38:24',
            ),
            11 => 
            array (
                'id' => 14,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '12345.00',
                'status' => 1,
                'created_at' => '2025-04-26 01:42:04',
                'updated_at' => '2025-04-26 01:42:04',
            ),
            12 => 
            array (
                'id' => 15,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '12955.00',
                'status' => 1,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            13 => 
            array (
                'id' => 16,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '16365.00',
                'status' => 1,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
        ));
        
        
    }
}