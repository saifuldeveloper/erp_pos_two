<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('colors')->delete();
        
        \DB::table('colors')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Black',
                'code' => NULL,
                'created_at' => '2025-04-19 17:22:40',
                'updated_at' => '2025-04-19 17:22:40',
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'White',
                'code' => NULL,
                'created_at' => '2025-04-19 17:22:57',
                'updated_at' => '2025-04-19 17:22:57',
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'Blue',
                'code' => NULL,
                'created_at' => '2025-04-19 17:23:03',
                'updated_at' => '2025-04-19 17:23:03',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'Pink',
                'code' => NULL,
                'created_at' => '2025-04-19 17:23:21',
                'updated_at' => '2025-04-19 17:23:21',
            ),
            4 => 
            array (
                'id' => 6,
                'name' => 'Chocolate',
                'code' => NULL,
                'created_at' => '2025-04-19 17:23:30',
                'updated_at' => '2025-04-19 17:23:30',
            ),
            5 => 
            array (
                'id' => 7,
                'name' => 'Gray',
                'code' => NULL,
                'created_at' => '2025-04-19 17:23:38',
                'updated_at' => '2025-04-19 17:23:38',
            ),
            6 => 
            array (
                'id' => 8,
                'name' => 'Green',
                'code' => NULL,
                'created_at' => '2025-04-19 19:11:16',
                'updated_at' => '2025-04-19 19:11:16',
            ),
            7 => 
            array (
                'id' => 9,
                'name' => 'Coffee',
                'code' => NULL,
                'created_at' => '2025-04-19 19:11:26',
                'updated_at' => '2025-04-19 19:11:26',
            ),
            8 => 
            array (
                'id' => 10,
                'name' => 'Cream',
                'code' => NULL,
                'created_at' => '2025-04-19 19:12:02',
                'updated_at' => '2025-04-19 19:12:02',
            ),
            9 => 
            array (
                'id' => 11,
                'name' => 'Golden',
                'code' => NULL,
                'created_at' => '2025-04-19 19:12:12',
                'updated_at' => '2025-04-19 19:12:12',
            ),
            10 => 
            array (
                'id' => 12,
                'name' => 'Maroon',
                'code' => NULL,
                'created_at' => '2025-04-19 19:12:20',
                'updated_at' => '2025-04-19 19:12:20',
            ),
            11 => 
            array (
                'id' => 13,
                'name' => 'Master',
                'code' => NULL,
                'created_at' => '2025-04-19 19:12:28',
                'updated_at' => '2025-04-19 19:12:28',
            ),
            12 => 
            array (
                'id' => 14,
                'name' => 'Navy',
                'code' => NULL,
                'created_at' => '2025-04-19 19:13:12',
                'updated_at' => '2025-04-19 19:13:12',
            ),
            13 => 
            array (
                'id' => 15,
                'name' => 'Purple',
                'code' => NULL,
                'created_at' => '2025-04-19 19:13:21',
                'updated_at' => '2025-04-19 19:13:21',
            ),
            14 => 
            array (
                'id' => 16,
                'name' => 'Silver',
                'code' => NULL,
                'created_at' => '2025-04-19 19:13:30',
                'updated_at' => '2025-04-19 19:13:30',
            ),
            15 => 
            array (
                'id' => 17,
                'name' => 'Biscuit',
                'code' => 'EFCCA2',
                'created_at' => '2025-04-22 01:36:49',
                'updated_at' => '2025-04-22 01:36:49',
            ),
            16 => 
            array (
                'id' => 18,
                'name' => 'Olive',
                'code' => NULL,
                'created_at' => '2025-04-24 00:43:56',
                'updated_at' => '2025-04-24 00:43:56',
            ),
            17 => 
            array (
                'id' => 19,
                'name' => 'Brown',
                'code' => '964B00',
                'created_at' => '2025-04-24 17:33:04',
                'updated_at' => '2025-04-24 17:33:04',
            ),
            18 => 
            array (
                'id' => 20,
                'name' => 'RED',
                'code' => 'FF0000',
                'created_at' => '2025-04-24 17:40:03',
                'updated_at' => '2025-04-24 17:40:03',
            ),
            19 => 
            array (
                'id' => 21,
                'name' => 'Sky Blue',
                'code' => NULL,
                'created_at' => '2025-08-10 18:45:53',
                'updated_at' => '2025-08-10 18:45:53',
            ),
        ));
        
        
    }
}