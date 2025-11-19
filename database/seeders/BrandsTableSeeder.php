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
                'image' => '20250419013907.jpg',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:39:07',
                'updated_at' => '2025-04-19 19:39:07',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'China',
                'image' => '20250419013945.jpg',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:39:45',
                'updated_at' => '2025-04-19 19:39:45',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Avijatry Discount',
                'image' => '20250420082854.jpg',
                'is_active' => 1,
                'created_at' => '2025-04-21 02:28:54',
                'updated_at' => '2025-04-21 02:28:54',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'China Discount',
                'image' => '20250424040942.png',
                'is_active' => 1,
                'created_at' => '2025-04-24 22:09:43',
                'updated_at' => '2025-04-24 22:09:43',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Accessories',
                'image' => '20250425044000.jpg',
                'is_active' => 1,
                'created_at' => '2025-04-25 22:40:00',
                'updated_at' => '2025-04-25 22:40:00',
            ),
        ));
        
        
    }
}