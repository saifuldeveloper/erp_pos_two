<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'লে',
                'image' => '20241008042953.jpg',
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'সু',
                'image' => '20241008043138.png',
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'জে',
                'image' => '20241008042657.jpg',
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'বেবি',
                'image' => '20241008042833.png',
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'পাম',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'টেপ',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'আংটা',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'লোফার',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'সীট',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'কলাপুরি',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'গোলাই',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'কারচুপী',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'সীট পাম্পী',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => '০-২',
                'image' => NULL,
                'parent_id' => 4,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}