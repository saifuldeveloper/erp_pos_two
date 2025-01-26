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
                'name' => 'লেডিস',
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
                'name' => 'জেন্টস',
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
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2024-12-12 07:52:55',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'টেপ',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2024-12-12 07:53:04',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'আংটা',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2024-12-12 07:53:18',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'লোফার',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2024-12-12 07:53:22',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'সীট',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2024-12-12 07:53:28',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'কলাপুরি',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2024-12-12 07:53:33',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'গোলাই',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2024-12-12 07:52:51',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'কারচুপী',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2024-12-12 07:53:41',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'সীট পাম্পী',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2024-12-12 07:52:42',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => '০-২',
                'image' => NULL,
                'parent_id' => 4,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2024-12-12 07:53:12',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'কেডস',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Ladies',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Keds',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'নাগড়া',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'পাম্পি',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Pumpi',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Baby',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Keds.',
                'image' => NULL,
                'parent_id' => 21,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => '6-9',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Keds..',
                'image' => NULL,
                'parent_id' => 23,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'জে',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => '2024-12-15 16:16:05',
                'updated_at' => '2024-12-15 16:16:05',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Test',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2024-12-27 11:59:17',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Pew',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'গোলাই',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Belt',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Flat',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Sandal',
                'image' => NULL,
                'parent_id' => 35,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'বেল্ট',
                'image' => NULL,
                'parent_id' => 25,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'দুই ফিতা',
                'image' => NULL,
                'parent_id' => 25,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'আংটা',
                'image' => NULL,
                'parent_id' => 23,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Gents',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Loafer',
                'image' => NULL,
                'parent_id' => 35,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Angta',
                'image' => NULL,
                'parent_id' => 35,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Nagra',
                'image' => NULL,
                'parent_id' => 35,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'belts',
                'image' => NULL,
                'parent_id' => 35,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Sacchi',
                'image' => NULL,
                'parent_id' => 35,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Loafer.',
                'image' => NULL,
                'parent_id' => 23,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'দুই-ফিতা',
                'image' => NULL,
                'parent_id' => 23,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'name' => '-Belt',
                'image' => NULL,
                'parent_id' => 23,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'পাম',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'পাম্পি.',
                'image' => NULL,
                'parent_id' => 21,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Half Shoe',
                'image' => NULL,
                'parent_id' => 21,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Sneakers',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Sneakers.',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'School',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2025-01-01 15:21:22',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'eds',
                'image' => NULL,
                'parent_id' => 49,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2025-01-01 15:19:05',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'School',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2025-01-01 15:27:50',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Jump',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'আংটা.',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'পাঞ্জা',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'WAIST BELT',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'W-Belt',
                'image' => NULL,
                'parent_id' => 35,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'মোজা',
                'image' => NULL,
                'parent_id' => 35,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'Wallet',
                'image' => NULL,
                'parent_id' => 35,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'Nagra',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'Sit Pumpi',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'Boston',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'Sandal',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'Shoe',
                'image' => NULL,
                'parent_id' => 35,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'Sit',
                'image' => NULL,
                'parent_id' => 35,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'Sit',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'Heels',
                'image' => NULL,
                'parent_id' => 16,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}