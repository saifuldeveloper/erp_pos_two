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
            38 => 
            array (
                'id' => 39,
                'stock_count_id' => 4,
                'product_id' => 330,
                'item_code' => 'Black/42-R-100',
                'current_quantity' => 2,
                'updated_quantity' => 2,
                'created_at' => '2025-03-08 22:29:00',
                'updated_at' => '2025-03-08 22:29:00',
            ),
            39 => 
            array (
                'id' => 40,
                'stock_count_id' => 4,
                'product_id' => 330,
                'item_code' => 'Black/41-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 2,
                'created_at' => '2025-03-08 22:29:00',
                'updated_at' => '2025-03-08 22:29:00',
            ),
            40 => 
            array (
                'id' => 41,
                'stock_count_id' => 4,
                'product_id' => 330,
                'item_code' => 'Black/40-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:29:00',
                'updated_at' => '2025-03-08 22:29:00',
            ),
            41 => 
            array (
                'id' => 42,
                'stock_count_id' => 4,
                'product_id' => 330,
                'item_code' => 'Black/44-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:30:03',
                'updated_at' => '2025-03-08 22:30:03',
            ),
            42 => 
            array (
                'id' => 43,
                'stock_count_id' => 4,
                'product_id' => 330,
                'item_code' => 'Black/42-R-100',
                'current_quantity' => 2,
                'updated_quantity' => 2,
                'created_at' => '2025-03-08 22:30:03',
                'updated_at' => '2025-03-08 22:30:03',
            ),
            43 => 
            array (
                'id' => 44,
                'stock_count_id' => 4,
                'product_id' => 330,
                'item_code' => 'Black/41-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:30:03',
                'updated_at' => '2025-03-08 22:30:03',
            ),
            44 => 
            array (
                'id' => 45,
                'stock_count_id' => 4,
                'product_id' => 330,
                'item_code' => 'Black/40-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:30:03',
                'updated_at' => '2025-03-08 22:30:03',
            ),
            45 => 
            array (
                'id' => 46,
                'stock_count_id' => 7,
                'product_id' => 1002,
                'item_code' => 'Pink/36-R-1002',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:57:54',
                'updated_at' => '2025-03-08 22:57:54',
            ),
            46 => 
            array (
                'id' => 47,
                'stock_count_id' => 7,
                'product_id' => 1002,
                'item_code' => 'Pink/35-R-1002',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:57:54',
                'updated_at' => '2025-03-08 22:57:54',
            ),
            47 => 
            array (
                'id' => 48,
                'stock_count_id' => 7,
                'product_id' => 1002,
                'item_code' => 'Pink/34-R-1002',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:57:54',
                'updated_at' => '2025-03-08 22:57:54',
            ),
            48 => 
            array (
                'id' => 49,
                'stock_count_id' => 7,
                'product_id' => 1002,
                'item_code' => 'Pink/33-R-1002',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:57:54',
                'updated_at' => '2025-03-08 22:57:54',
            ),
            49 => 
            array (
                'id' => 50,
                'stock_count_id' => 7,
                'product_id' => 1002,
                'item_code' => 'Pink/32-R-1002',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:57:54',
                'updated_at' => '2025-03-08 22:57:54',
            ),
            50 => 
            array (
                'id' => 51,
                'stock_count_id' => 7,
                'product_id' => 1002,
                'item_code' => 'Pink/31-R-1002',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:57:54',
                'updated_at' => '2025-03-08 22:57:54',
            ),
            51 => 
            array (
                'id' => 52,
                'stock_count_id' => 7,
                'product_id' => 1002,
                'item_code' => 'Pink/36-R-1002',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:57:54',
                'updated_at' => '2025-03-08 22:57:54',
            ),
            52 => 
            array (
                'id' => 53,
                'stock_count_id' => 7,
                'product_id' => 1002,
                'item_code' => 'Pink/35-R-1002',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:57:54',
                'updated_at' => '2025-03-08 22:57:54',
            ),
            53 => 
            array (
                'id' => 54,
                'stock_count_id' => 7,
                'product_id' => 1002,
                'item_code' => 'Pink/34-R-1002',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:57:54',
                'updated_at' => '2025-03-08 22:57:54',
            ),
            54 => 
            array (
                'id' => 55,
                'stock_count_id' => 7,
                'product_id' => 1002,
                'item_code' => 'Pink/33-R-1002',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:57:54',
                'updated_at' => '2025-03-08 22:57:54',
            ),
            55 => 
            array (
                'id' => 56,
                'stock_count_id' => 7,
                'product_id' => 1002,
                'item_code' => 'Pink/32-R-1002',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:57:54',
                'updated_at' => '2025-03-08 22:57:54',
            ),
            56 => 
            array (
                'id' => 57,
                'stock_count_id' => 7,
                'product_id' => 1002,
                'item_code' => 'Pink/31-R-1002',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-08 22:57:54',
                'updated_at' => '2025-03-08 22:57:54',
            ),
            57 => 
            array (
                'id' => 58,
                'stock_count_id' => 8,
                'product_id' => 330,
                'item_code' => 'Black/44-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:40:59',
                'updated_at' => '2025-03-22 04:40:59',
            ),
            58 => 
            array (
                'id' => 59,
                'stock_count_id' => 8,
                'product_id' => 330,
                'item_code' => 'Black/42-R-100',
                'current_quantity' => 2,
                'updated_quantity' => 2,
                'created_at' => '2025-03-22 04:40:59',
                'updated_at' => '2025-03-22 04:40:59',
            ),
            59 => 
            array (
                'id' => 60,
                'stock_count_id' => 8,
                'product_id' => 330,
                'item_code' => 'Black/40-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:40:59',
                'updated_at' => '2025-03-22 04:40:59',
            ),
            60 => 
            array (
                'id' => 61,
                'stock_count_id' => 8,
                'product_id' => 5,
                'item_code' => 'BR/44-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:41:44',
                'updated_at' => '2025-03-22 04:41:44',
            ),
            61 => 
            array (
                'id' => 62,
                'stock_count_id' => 8,
                'product_id' => 5,
                'item_code' => 'BR/43-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:41:44',
                'updated_at' => '2025-03-22 04:41:44',
            ),
            62 => 
            array (
                'id' => 63,
                'stock_count_id' => 8,
                'product_id' => 5,
                'item_code' => 'BR/40-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:41:44',
                'updated_at' => '2025-03-22 04:41:44',
            ),
            63 => 
            array (
                'id' => 64,
                'stock_count_id' => 8,
                'product_id' => 4,
                'item_code' => 'G/41-R-102',
                'current_quantity' => 2,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:42:07',
                'updated_at' => '2025-03-22 04:42:07',
            ),
            64 => 
            array (
                'id' => 65,
                'stock_count_id' => 8,
                'product_id' => 5,
                'item_code' => 'BR/43-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:42:26',
                'updated_at' => '2025-03-22 04:42:26',
            ),
            65 => 
            array (
                'id' => 66,
                'stock_count_id' => 8,
                'product_id' => 5,
                'item_code' => 'BR/40-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 2,
                'created_at' => '2025-03-22 04:42:26',
                'updated_at' => '2025-03-22 04:42:26',
            ),
            66 => 
            array (
                'id' => 67,
                'stock_count_id' => 9,
                'product_id' => 330,
                'item_code' => 'Black/44-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:44:03',
                'updated_at' => '2025-03-22 04:44:03',
            ),
            67 => 
            array (
                'id' => 68,
                'stock_count_id' => 9,
                'product_id' => 330,
                'item_code' => 'Black/43-R-100',
                'current_quantity' => 0,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:44:03',
                'updated_at' => '2025-03-22 04:44:03',
            ),
            68 => 
            array (
                'id' => 69,
                'stock_count_id' => 9,
                'product_id' => 330,
                'item_code' => 'Black/42-R-100',
                'current_quantity' => 2,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:44:03',
                'updated_at' => '2025-03-22 04:44:03',
            ),
            69 => 
            array (
                'id' => 70,
                'stock_count_id' => 9,
                'product_id' => 330,
                'item_code' => 'Black/41-R-100',
                'current_quantity' => 0,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:44:03',
                'updated_at' => '2025-03-22 04:44:03',
            ),
            70 => 
            array (
                'id' => 71,
                'stock_count_id' => 9,
                'product_id' => 330,
                'item_code' => 'Black/40-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:44:03',
                'updated_at' => '2025-03-22 04:44:03',
            ),
            71 => 
            array (
                'id' => 72,
                'stock_count_id' => 9,
                'product_id' => 4,
                'item_code' => 'G/41-R-102',
                'current_quantity' => 2,
                'updated_quantity' => 2,
                'created_at' => '2025-03-22 04:44:56',
                'updated_at' => '2025-03-22 04:44:56',
            ),
            72 => 
            array (
                'id' => 73,
                'stock_count_id' => 9,
                'product_id' => 4,
                'item_code' => 'G/40-R-102',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:44:56',
                'updated_at' => '2025-03-22 04:44:56',
            ),
            73 => 
            array (
                'id' => 74,
                'stock_count_id' => 9,
                'product_id' => 330,
                'item_code' => 'Black/44-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:46:26',
                'updated_at' => '2025-03-22 04:46:26',
            ),
            74 => 
            array (
                'id' => 75,
                'stock_count_id' => 9,
                'product_id' => 330,
                'item_code' => 'Black/42-R-100',
                'current_quantity' => 2,
                'updated_quantity' => 2,
                'created_at' => '2025-03-22 04:46:26',
                'updated_at' => '2025-03-22 04:46:26',
            ),
            75 => 
            array (
                'id' => 76,
                'stock_count_id' => 9,
                'product_id' => 330,
                'item_code' => 'Black/40-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-03-22 04:46:26',
                'updated_at' => '2025-03-22 04:46:26',
            ),
            76 => 
            array (
                'id' => 77,
                'stock_count_id' => 10,
                'product_id' => 330,
                'item_code' => 'Black/44-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:51:59',
                'updated_at' => '2025-05-01 04:51:59',
            ),
            77 => 
            array (
                'id' => 78,
                'stock_count_id' => 10,
                'product_id' => 330,
                'item_code' => 'Black/42-R-100',
                'current_quantity' => 2,
                'updated_quantity' => 2,
                'created_at' => '2025-05-01 04:51:59',
                'updated_at' => '2025-05-01 04:51:59',
            ),
            78 => 
            array (
                'id' => 79,
                'stock_count_id' => 10,
                'product_id' => 330,
                'item_code' => 'Black/40-R-100',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:51:59',
                'updated_at' => '2025-05-01 04:51:59',
            ),
            79 => 
            array (
                'id' => 80,
                'stock_count_id' => 10,
                'product_id' => 5,
                'item_code' => 'BR/44-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:52:21',
                'updated_at' => '2025-05-01 04:52:21',
            ),
            80 => 
            array (
                'id' => 81,
                'stock_count_id' => 10,
                'product_id' => 5,
                'item_code' => 'BR/43-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:52:21',
                'updated_at' => '2025-05-01 04:52:21',
            ),
            81 => 
            array (
                'id' => 82,
                'stock_count_id' => 10,
                'product_id' => 5,
                'item_code' => 'BR/42-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:52:21',
                'updated_at' => '2025-05-01 04:52:21',
            ),
            82 => 
            array (
                'id' => 83,
                'stock_count_id' => 10,
                'product_id' => 5,
                'item_code' => 'BR/41-R-101',
                'current_quantity' => 0,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:52:21',
                'updated_at' => '2025-05-01 04:52:21',
            ),
            83 => 
            array (
                'id' => 84,
                'stock_count_id' => 10,
                'product_id' => 5,
                'item_code' => 'BR/40-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 2,
                'created_at' => '2025-05-01 04:52:21',
                'updated_at' => '2025-05-01 04:52:21',
            ),
            84 => 
            array (
                'id' => 85,
                'stock_count_id' => 10,
                'product_id' => 5,
                'item_code' => 'BR/44-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:52:41',
                'updated_at' => '2025-05-01 04:52:41',
            ),
            85 => 
            array (
                'id' => 86,
                'stock_count_id' => 10,
                'product_id' => 5,
                'item_code' => 'BR/43-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:52:41',
                'updated_at' => '2025-05-01 04:52:41',
            ),
            86 => 
            array (
                'id' => 87,
                'stock_count_id' => 10,
                'product_id' => 5,
                'item_code' => 'BR/42-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:52:41',
                'updated_at' => '2025-05-01 04:52:41',
            ),
            87 => 
            array (
                'id' => 88,
                'stock_count_id' => 10,
                'product_id' => 5,
                'item_code' => 'BR/40-R-101',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:52:41',
                'updated_at' => '2025-05-01 04:52:41',
            ),
            88 => 
            array (
                'id' => 89,
                'stock_count_id' => 10,
                'product_id' => 8,
                'item_code' => 'Brown/44-R-105',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:53:31',
                'updated_at' => '2025-05-01 04:53:31',
            ),
            89 => 
            array (
                'id' => 90,
                'stock_count_id' => 10,
                'product_id' => 8,
                'item_code' => 'Brown/40-R-105',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:53:31',
                'updated_at' => '2025-05-01 04:53:31',
            ),
            90 => 
            array (
                'id' => 91,
                'stock_count_id' => 10,
                'product_id' => 8,
                'item_code' => 'Brown/44-R-105',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:53:31',
                'updated_at' => '2025-05-01 04:53:31',
            ),
            91 => 
            array (
                'id' => 92,
                'stock_count_id' => 10,
                'product_id' => 8,
                'item_code' => 'Brown/40-R-105',
                'current_quantity' => 1,
                'updated_quantity' => 1,
                'created_at' => '2025-05-01 04:53:31',
                'updated_at' => '2025-05-01 04:53:31',
            ),
        ));
        
        
    }
}