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
                'name' => 'Ladies',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Gents',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Baby',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Sandal',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Over',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Shoe',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Pum',
                'image' => NULL,
                'parent_id' => 6,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Sit',
                'image' => NULL,
                'parent_id' => 6,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Wallet',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Belt',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Angta',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Nagra',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Sit',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => '6-9',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Loafer',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Sacchi',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Keds',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => '0-2',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Sandal',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'keds',
                'image' => NULL,
                'parent_id' => 3,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Golai',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Keds',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'nagra',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Pumpi',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Pew',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Belt',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Flat',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Sit Pumpi',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Sit',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Casual',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Shoes',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Hill',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Karchupi',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Over',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Boston',
                'image' => NULL,
                'parent_id' => 1,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Kolapuri',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Socks',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Accessories',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 0,
                'created_at' => NULL,
                'updated_at' => '2025-04-25 22:38:46',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'W-Belt',
                'image' => NULL,
                'parent_id' => 2,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Shiner',
                'image' => NULL,
                'parent_id' => 6,
                'is_active' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'লে',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => '2025-05-28 20:42:04',
                'updated_at' => '2025-05-28 20:42:04',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'পিউ চটি',
                'image' => NULL,
                'parent_id' => 41,
                'is_active' => 1,
                'created_at' => '2025-05-28 20:42:04',
                'updated_at' => '2025-05-28 20:42:04',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'জে',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => '2025-05-28 21:03:32',
                'updated_at' => '2025-05-28 21:03:32',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'বেল্ট',
                'image' => NULL,
                'parent_id' => 43,
                'is_active' => 1,
                'created_at' => '2025-05-28 21:03:32',
                'updated_at' => '2025-05-28 21:03:32',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'দুই ফিতা',
                'image' => NULL,
                'parent_id' => 43,
                'is_active' => 1,
                'created_at' => '2025-05-28 21:03:32',
                'updated_at' => '2025-05-28 21:03:32',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'চটি',
                'image' => NULL,
                'parent_id' => 43,
                'is_active' => 1,
                'created_at' => '2025-05-28 21:03:32',
                'updated_at' => '2025-05-28 21:03:32',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'আংটা',
                'image' => NULL,
                'parent_id' => 43,
                'is_active' => 1,
                'created_at' => '2025-05-28 21:03:33',
                'updated_at' => '2025-05-28 21:03:33',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => '১৬-১৮',
                'image' => NULL,
                'parent_id' => 43,
                'is_active' => 1,
                'created_at' => '2025-05-28 22:14:20',
                'updated_at' => '2025-05-28 22:14:20',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'ফ্লাট',
                'image' => NULL,
                'parent_id' => 41,
                'is_active' => 1,
                'created_at' => '2025-05-29 02:43:12',
                'updated_at' => '2025-05-29 02:43:12',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'গোলাই চটি',
                'image' => NULL,
                'parent_id' => 41,
                'is_active' => 1,
                'created_at' => '2025-05-29 02:55:47',
                'updated_at' => '2025-05-29 02:55:47',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'নাগড়া',
                'image' => NULL,
                'parent_id' => 41,
                'is_active' => 1,
                'created_at' => '2025-05-29 02:55:47',
                'updated_at' => '2025-05-29 02:55:47',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'হীল',
                'image' => NULL,
                'parent_id' => 41,
                'is_active' => 1,
                'created_at' => '2025-05-29 02:55:47',
                'updated_at' => '2025-05-29 02:55:47',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'নাগড়া হীল',
                'image' => NULL,
                'parent_id' => 41,
                'is_active' => 1,
                'created_at' => '2025-05-29 02:55:47',
                'updated_at' => '2025-05-29 02:55:47',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'পাম্পি',
                'image' => NULL,
                'parent_id' => 41,
                'is_active' => 1,
                'created_at' => '2025-05-29 02:55:47',
                'updated_at' => '2025-05-29 02:55:47',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'লোফার',
                'image' => NULL,
                'parent_id' => 43,
                'is_active' => 1,
                'created_at' => '2025-05-29 03:24:38',
                'updated_at' => '2025-05-29 03:24:38',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'কলাপুরি',
                'image' => NULL,
                'parent_id' => 43,
                'is_active' => 1,
                'created_at' => '2025-05-29 03:24:39',
                'updated_at' => '2025-05-29 03:24:39',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'সাচ্চি',
                'image' => NULL,
                'parent_id' => 43,
                'is_active' => 1,
                'created_at' => '2025-05-29 03:24:39',
                'updated_at' => '2025-05-29 03:24:39',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'সীট',
                'image' => NULL,
                'parent_id' => 43,
                'is_active' => 1,
                'created_at' => '2025-05-29 03:24:39',
                'updated_at' => '2025-05-29 03:24:39',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'সু',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => '2025-05-29 03:24:39',
                'updated_at' => '2025-05-29 03:24:39',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'পাম',
                'image' => NULL,
                'parent_id' => 59,
                'is_active' => 1,
                'created_at' => '2025-05-29 03:24:39',
                'updated_at' => '2025-05-29 03:24:39',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => '১২-১৫',
                'image' => NULL,
                'parent_id' => 41,
                'is_active' => 1,
                'created_at' => '2025-08-10 18:03:16',
                'updated_at' => '2025-08-10 18:03:16',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'পিউ বেল্ট',
                'image' => NULL,
                'parent_id' => 41,
                'is_active' => 1,
                'created_at' => '2025-08-10 21:07:03',
                'updated_at' => '2025-08-10 21:07:03',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'সীট পাম্পী',
                'image' => NULL,
                'parent_id' => 41,
                'is_active' => 1,
                'created_at' => '2025-11-01 21:21:24',
                'updated_at' => '2025-11-01 21:21:24',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'বুস্টন',
                'image' => NULL,
                'parent_id' => 41,
                'is_active' => 1,
                'created_at' => '2025-11-01 21:21:24',
                'updated_at' => '2025-11-01 21:21:24',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'বেবি',
                'image' => NULL,
                'parent_id' => NULL,
                'is_active' => 1,
                'created_at' => '2025-11-02 00:10:23',
                'updated_at' => '2025-11-02 00:10:23',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'ক্যাজুয়াল',
                'image' => NULL,
                'parent_id' => 43,
                'is_active' => 1,
                'created_at' => '2025-11-02 23:10:25',
                'updated_at' => '2025-11-02 23:10:25',
            ),
        ));
        
        
    }
}