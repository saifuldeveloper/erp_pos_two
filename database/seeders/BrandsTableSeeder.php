<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('brands')->delete();
        
        \DB::table('brands')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Avijatry',
                'image' => '20251121080900.png',
                'is_active' => 1,
                'created_at' => '2024-10-07 10:07:13',
                'updated_at' => '2025-11-21 20:09:00',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Apex',
                'image' => '20241007040726.jpeg',
                'is_active' => 0,
                'created_at' => '2024-10-07 10:07:26',
                'updated_at' => '2024-12-12 01:49:59',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Bata',
                'image' => '20241007040816.png',
                'is_active' => 0,
                'created_at' => '2024-10-07 10:08:16',
                'updated_at' => '2024-12-12 01:50:04',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Lotto',
                'image' => '20241007040829.png',
                'is_active' => 0,
                'created_at' => '2024-10-07 10:08:29',
                'updated_at' => '2024-12-12 01:49:52',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'China',
                'image' => '20251121080933.jpg',
                'is_active' => 1,
                'created_at' => '2024-12-11 22:51:07',
                'updated_at' => '2025-11-21 20:09:33',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Test',
                'image' => NULL,
                'is_active' => 0,
                'created_at' => '2024-12-21 05:19:25',
                'updated_at' => '2024-12-22 23:06:35',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'Accessories',
                'image' => '20250104123203.jpeg',
                'is_active' => 1,
                'created_at' => '2025-01-04 06:23:57',
                'updated_at' => '2025-11-13 02:38:20',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'Khulna China',
                'image' => '20250119074747.png',
                'is_active' => 1,
                'created_at' => '2025-01-19 13:47:47',
                'updated_at' => '2025-11-13 02:38:25',
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'Khulna accessories',
                'image' => NULL,
                'is_active' => 1,
                'created_at' => '2025-05-24 13:35:06',
                'updated_at' => '2025-11-13 02:38:40',
            ),
        ));
        
        
    }
}