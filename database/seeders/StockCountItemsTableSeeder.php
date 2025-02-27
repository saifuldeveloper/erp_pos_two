<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StockCountItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('stock_count_items')->delete();
        
        \DB::table('stock_count_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'stock_count_id' => 1,
                'product_id' => 461,
                'item_code' => 'Pink/36-R-461',
                'current_quantity' => 1,
                'updated_quantity' => 2,
                'created_at' => '2025-02-12 18:23:53',
                'updated_at' => '2025-02-12 18:23:53',
            ),
            1 => 
            array (
                'id' => 2,
                'stock_count_id' => 1,
                'product_id' => 451,
                'item_code' => 'Golden/41-R-451',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-12 18:24:19',
                'updated_at' => '2025-02-12 18:24:19',
            ),
            2 => 
            array (
                'id' => 3,
                'stock_count_id' => 1,
                'product_id' => 451,
                'item_code' => 'Golden/40-R-451',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-12 18:24:19',
                'updated_at' => '2025-02-12 18:24:19',
            ),
            3 => 
            array (
                'id' => 4,
                'stock_count_id' => 1,
                'product_id' => 451,
                'item_code' => 'Golden/39-R-451',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-12 18:24:19',
                'updated_at' => '2025-02-12 18:24:19',
            ),
            4 => 
            array (
                'id' => 5,
                'stock_count_id' => 1,
                'product_id' => 734,
                'item_code' => 'Cream/6-R-734',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-13 19:00:06',
                'updated_at' => '2025-02-13 19:00:06',
            ),
            5 => 
            array (
                'id' => 6,
                'stock_count_id' => 1,
                'product_id' => 734,
                'item_code' => 'Cream/5-R-734',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-13 19:00:06',
                'updated_at' => '2025-02-13 19:00:06',
            ),
            6 => 
            array (
                'id' => 7,
                'stock_count_id' => 1,
                'product_id' => 734,
                'item_code' => 'Cream/4-R-734',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-13 19:00:06',
                'updated_at' => '2025-02-13 19:00:06',
            ),
            7 => 
            array (
                'id' => 8,
                'stock_count_id' => 5,
                'product_id' => 330,
                'item_code' => 'Black/44-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-15 22:19:00',
                'updated_at' => '2025-02-15 22:19:00',
            ),
            8 => 
            array (
                'id' => 9,
                'stock_count_id' => 5,
                'product_id' => 330,
                'item_code' => 'Black/42-R-100',
                'current_quantity' => 2,
                'updated_quantity' => 2,
                'created_at' => '2025-02-15 22:19:00',
                'updated_at' => '2025-02-15 22:19:00',
            ),
            9 => 
            array (
                'id' => 10,
                'stock_count_id' => 5,
                'product_id' => 330,
                'item_code' => 'Black/41-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-15 22:19:00',
                'updated_at' => '2025-02-15 22:19:00',
            ),
            10 => 
            array (
                'id' => 11,
                'stock_count_id' => 5,
                'product_id' => 330,
                'item_code' => 'Black/40-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-15 22:19:00',
                'updated_at' => '2025-02-15 22:19:00',
            ),
            11 => 
            array (
                'id' => 12,
                'stock_count_id' => 6,
                'product_id' => 330,
                'item_code' => 'Black/44-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-15 22:19:48',
                'updated_at' => '2025-02-15 22:19:48',
            ),
            12 => 
            array (
                'id' => 13,
                'stock_count_id' => 6,
                'product_id' => 330,
                'item_code' => 'Black/42-R-100',
                'current_quantity' => 2,
                'updated_quantity' => 1,
                'created_at' => '2025-02-15 22:19:48',
                'updated_at' => '2025-02-15 22:19:48',
            ),
            13 => 
            array (
                'id' => 14,
                'stock_count_id' => 6,
                'product_id' => 330,
                'item_code' => 'Black/41-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-15 22:19:48',
                'updated_at' => '2025-02-15 22:19:48',
            ),
            14 => 
            array (
                'id' => 15,
                'stock_count_id' => 6,
                'product_id' => 330,
                'item_code' => 'Black/40-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-15 22:19:48',
                'updated_at' => '2025-02-15 22:19:48',
            ),
            15 => 
            array (
                'id' => 16,
                'stock_count_id' => 6,
                'product_id' => 330,
                'item_code' => 'Black/42-R-100',
                'current_quantity' => 2,
                'updated_quantity' => 1,
                'created_at' => '2025-02-15 22:21:50',
                'updated_at' => '2025-02-15 22:21:50',
            ),
            16 => 
            array (
                'id' => 17,
                'stock_count_id' => 2,
                'product_id' => 188,
                'item_code' => 'Black/44-R-72',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-16 16:16:16',
                'updated_at' => '2025-02-16 16:16:16',
            ),
            17 => 
            array (
                'id' => 18,
                'stock_count_id' => 2,
                'product_id' => 188,
                'item_code' => 'Black/43-R-72',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-16 16:16:16',
                'updated_at' => '2025-02-16 16:16:16',
            ),
            18 => 
            array (
                'id' => 19,
                'stock_count_id' => 2,
                'product_id' => 188,
                'item_code' => 'Black/42-R-72',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-16 16:16:16',
                'updated_at' => '2025-02-16 16:16:16',
            ),
            19 => 
            array (
                'id' => 20,
                'stock_count_id' => 2,
                'product_id' => 188,
                'item_code' => 'Black/41-R-72',
                'current_quantity' => 2,
                'updated_quantity' => 2,
                'created_at' => '2025-02-16 16:16:16',
                'updated_at' => '2025-02-16 16:16:16',
            ),
            20 => 
            array (
                'id' => 21,
                'stock_count_id' => 2,
                'product_id' => 188,
                'item_code' => 'Black/40-R-72',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-16 16:16:16',
                'updated_at' => '2025-02-16 16:16:16',
            ),
            21 => 
            array (
                'id' => 22,
                'stock_count_id' => 2,
                'product_id' => 61,
                'item_code' => 'Brown/38-R-137',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-16 16:17:02',
                'updated_at' => '2025-02-16 16:17:02',
            ),
            22 => 
            array (
                'id' => 23,
                'stock_count_id' => 2,
                'product_id' => 61,
                'item_code' => 'Brown/37-R-137',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-16 16:17:02',
                'updated_at' => '2025-02-16 16:17:02',
            ),
            23 => 
            array (
                'id' => 24,
                'stock_count_id' => 2,
                'product_id' => 54,
                'item_code' => 'Black/36-R-130',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-18 18:58:38',
                'updated_at' => '2025-02-18 18:58:38',
            ),
            24 => 
            array (
                'id' => 25,
                'stock_count_id' => 3,
                'product_id' => 401,
                'item_code' => 'BK-AS/43-R-184',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-18 19:00:31',
                'updated_at' => '2025-02-18 19:00:31',
            ),
            25 => 
            array (
                'id' => 26,
                'stock_count_id' => 3,
                'product_id' => 401,
                'item_code' => 'BK-AS/42-R-184',
                'current_quantity' => 2,
                'updated_quantity' => 1,
                'created_at' => '2025-02-18 19:00:31',
                'updated_at' => '2025-02-18 19:00:31',
            ),
            26 => 
            array (
                'id' => 27,
                'stock_count_id' => 3,
                'product_id' => 401,
                'item_code' => 'BK-AS/41-R-184',
                'current_quantity' => 2,
                'updated_quantity' => 1,
                'created_at' => '2025-02-18 19:00:31',
                'updated_at' => '2025-02-18 19:00:31',
            ),
            27 => 
            array (
                'id' => 28,
                'stock_count_id' => 4,
                'product_id' => 371,
                'item_code' => 'Pink/38-R-166',
                'current_quantity' => 2,
                'updated_quantity' => 1,
                'created_at' => '2025-02-25 23:49:15',
                'updated_at' => '2025-02-25 23:49:15',
            ),
            28 => 
            array (
                'id' => 29,
                'stock_count_id' => 4,
                'product_id' => 29,
                'item_code' => 'Pink/40-R-116',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-25 23:49:29',
                'updated_at' => '2025-02-25 23:49:29',
            ),
            29 => 
            array (
                'id' => 30,
                'stock_count_id' => 4,
                'product_id' => 29,
                'item_code' => 'Pink/37-R-116',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-25 23:49:29',
                'updated_at' => '2025-02-25 23:49:29',
            ),
            30 => 
            array (
                'id' => 31,
                'stock_count_id' => 4,
                'product_id' => 354,
                'item_code' => 'Off Wi/38-R-155',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-25 23:50:22',
                'updated_at' => '2025-02-25 23:50:22',
            ),
            31 => 
            array (
                'id' => 32,
                'stock_count_id' => 4,
                'product_id' => 354,
                'item_code' => 'Off Wi/36-R-155',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-25 23:50:22',
                'updated_at' => '2025-02-25 23:50:22',
            ),
            32 => 
            array (
                'id' => 33,
                'stock_count_id' => 4,
                'product_id' => 767,
                'item_code' => 'PNK/41-R-767',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-25 23:50:56',
                'updated_at' => '2025-02-25 23:50:56',
            ),
            33 => 
            array (
                'id' => 34,
                'stock_count_id' => 4,
                'product_id' => 767,
                'item_code' => 'PNK/39-R-767',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-25 23:50:56',
                'updated_at' => '2025-02-25 23:50:56',
            ),
            34 => 
            array (
                'id' => 35,
                'stock_count_id' => 4,
                'product_id' => 767,
                'item_code' => 'PNK/38-R-767',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-25 23:50:56',
                'updated_at' => '2025-02-25 23:50:56',
            ),
            35 => 
            array (
                'id' => 36,
                'stock_count_id' => 4,
                'product_id' => 767,
                'item_code' => 'PNK/36-R-767',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-25 23:50:56',
                'updated_at' => '2025-02-25 23:50:56',
            ),
            36 => 
            array (
                'id' => 37,
                'stock_count_id' => 4,
                'product_id' => 23,
                'item_code' => 'Purple/40-R-114',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-02-25 23:52:08',
                'updated_at' => '2025-02-25 23:52:08',
            ),
            37 => 
            array (
                'id' => 38,
                'stock_count_id' => 4,
                'product_id' => 23,
                'item_code' => 'Purple/38-R-114',
                'current_quantity' => 2,
                'updated_quantity' => 2,
                'created_at' => '2025-02-25 23:52:08',
                'updated_at' => '2025-02-25 23:52:08',
            ),
        ));
        
        
    }
}