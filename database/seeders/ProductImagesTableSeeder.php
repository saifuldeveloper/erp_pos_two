<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductImagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_images')->delete();
        
        \DB::table('product_images')->insert(array (
            0 => 
            array (
                'id' => 1,
                'product_id' => 410,
                'color_id' => 1,
                'image' => 'khulna_20250105125417red677983d9569d6.jpeg',
                'created_at' => '2025-01-05 00:54:17',
                'updated_at' => '2025-01-05 00:54:17',
            ),
            1 => 
            array (
                'id' => 2,
                'product_id' => 410,
                'color_id' => 2,
                'image' => 'khulna_20250105125417gree677983d958157.jpeg',
                'created_at' => '2025-01-05 00:54:17',
                'updated_at' => '2025-01-05 00:54:17',
            ),
            2 => 
            array (
                'id' => 3,
                'product_id' => 411,
                'color_id' => 3,
                'image' => 'khulna_20250105024654pink677a46fee6fe9.jpeg',
                'created_at' => '2025-01-05 14:46:54',
                'updated_at' => '2025-01-05 14:46:54',
            ),
            3 => 
            array (
                'id' => 4,
                'product_id' => 411,
                'color_id' => 4,
                'image' => 'khulna_20250105024654black677a46fee8122.jpeg',
                'created_at' => '2025-01-05 14:46:54',
                'updated_at' => '2025-01-05 14:46:54',
            ),
            4 => 
            array (
                'id' => 5,
                'product_id' => 421,
                'color_id' => 5,
                'image' => 'khulna_20250108114205BK677e102d05740.jpg',
                'created_at' => '2025-01-08 11:42:05',
                'updated_at' => '2025-01-08 11:42:05',
            ),
            5 => 
            array (
                'id' => 6,
                'product_id' => 421,
                'color_id' => 6,
                'image' => 'khulna_20250108114205CH677e102d069e1.jpg',
                'created_at' => '2025-01-08 11:42:05',
                'updated_at' => '2025-01-08 11:42:05',
            ),
            6 => 
            array (
                'id' => 7,
                'product_id' => 421,
                'color_id' => 8,
                'image' => 'khulna_20250108114205MR677e102d0767c.jpg',
                'created_at' => '2025-01-08 11:42:05',
                'updated_at' => '2025-01-08 11:42:05',
            ),
            7 => 
            array (
                'id' => 8,
                'product_id' => 435,
                'color_id' => 21,
                'image' => 'khulna_20250112051752Brown6783a4e013f8e.jpg',
                'created_at' => '2025-01-12 17:17:52',
                'updated_at' => '2025-01-12 17:17:52',
            ),
            8 => 
            array (
                'id' => 9,
                'product_id' => 435,
                'color_id' => 20,
                'image' => 'khulna_20250112051752Grey6783a4e016fbb.jpeg',
                'created_at' => '2025-01-12 17:17:52',
                'updated_at' => '2025-01-12 17:17:52',
            ),
        ));
        
        
    }
}