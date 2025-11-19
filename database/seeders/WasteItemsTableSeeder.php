<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WasteItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('waste_items')->delete();
        
        \DB::table('waste_items')->insert(array (
            0 => 
            array (
                'id' => 3,
                'waste_id' => 3,
                'product_id' => 86,
                'qty' => 1,
                'unit_price' => 795.0,
                'subtotal' => 795.0,
                'created_at' => '2025-04-20 22:55:52',
                'updated_at' => '2025-04-20 22:55:52',
            ),
            1 => 
            array (
                'id' => 4,
                'waste_id' => 4,
                'product_id' => 131,
                'qty' => 1,
                'unit_price' => 1595.0,
                'subtotal' => 1595.0,
                'created_at' => '2025-04-21 16:42:37',
                'updated_at' => '2025-04-21 16:42:37',
            ),
            2 => 
            array (
                'id' => 5,
                'waste_id' => 5,
                'product_id' => 239,
                'qty' => 1,
                'unit_price' => 1395.0,
                'subtotal' => 1395.0,
                'created_at' => '2025-04-21 18:59:19',
                'updated_at' => '2025-04-21 18:59:19',
            ),
            3 => 
            array (
                'id' => 6,
                'waste_id' => 6,
                'product_id' => 157,
                'qty' => 1,
                'unit_price' => 1450.0,
                'subtotal' => 1450.0,
                'created_at' => '2025-04-21 18:59:37',
                'updated_at' => '2025-04-21 18:59:37',
            ),
            4 => 
            array (
                'id' => 7,
                'waste_id' => 7,
                'product_id' => 92,
                'qty' => 1,
                'unit_price' => 1050.0,
                'subtotal' => 1050.0,
                'created_at' => '2025-04-21 21:30:34',
                'updated_at' => '2025-04-21 21:30:34',
            ),
            5 => 
            array (
                'id' => 8,
                'waste_id' => 8,
                'product_id' => 188,
                'qty' => 1,
                'unit_price' => 795.0,
                'subtotal' => 795.0,
                'created_at' => '2025-04-21 22:48:10',
                'updated_at' => '2025-04-21 22:48:10',
            ),
            6 => 
            array (
                'id' => 9,
                'waste_id' => 9,
                'product_id' => 72,
                'qty' => 1,
                'unit_price' => 995.0,
                'subtotal' => 995.0,
                'created_at' => '2025-04-21 22:48:42',
                'updated_at' => '2025-04-21 22:48:42',
            ),
            7 => 
            array (
                'id' => 10,
                'waste_id' => 10,
                'product_id' => 66,
                'qty' => 1,
                'unit_price' => 1760.0,
                'subtotal' => 1760.0,
                'created_at' => '2025-04-21 22:49:12',
                'updated_at' => '2025-04-21 22:49:12',
            ),
            8 => 
            array (
                'id' => 11,
                'waste_id' => 11,
                'product_id' => 33,
                'qty' => 1,
                'unit_price' => 790.0,
                'subtotal' => 790.0,
                'created_at' => '2025-04-21 23:32:07',
                'updated_at' => '2025-04-21 23:32:07',
            ),
            9 => 
            array (
                'id' => 12,
                'waste_id' => 12,
                'product_id' => 27,
                'qty' => 1,
                'unit_price' => 850.0,
                'subtotal' => 850.0,
                'created_at' => '2025-04-22 03:35:41',
                'updated_at' => '2025-04-22 03:35:41',
            ),
            10 => 
            array (
                'id' => 13,
                'waste_id' => 12,
                'product_id' => 16,
                'qty' => 1,
                'unit_price' => 795.0,
                'subtotal' => 795.0,
                'created_at' => '2025-04-22 03:35:41',
                'updated_at' => '2025-04-22 03:35:41',
            ),
            11 => 
            array (
                'id' => 14,
                'waste_id' => 12,
                'product_id' => 83,
                'qty' => 1,
                'unit_price' => 1495.0,
                'subtotal' => 1495.0,
                'created_at' => '2025-04-22 03:35:41',
                'updated_at' => '2025-04-22 03:35:41',
            ),
            12 => 
            array (
                'id' => 15,
                'waste_id' => 12,
                'product_id' => 63,
                'qty' => 1,
                'unit_price' => 695.0,
                'subtotal' => 695.0,
                'created_at' => '2025-04-22 03:35:41',
                'updated_at' => '2025-04-22 03:35:41',
            ),
            13 => 
            array (
                'id' => 16,
                'waste_id' => 12,
                'product_id' => 328,
                'qty' => 1,
                'unit_price' => 855.0,
                'subtotal' => 855.0,
                'created_at' => '2025-04-22 03:35:41',
                'updated_at' => '2025-04-22 03:35:41',
            ),
            14 => 
            array (
                'id' => 17,
                'waste_id' => 13,
                'product_id' => 51,
                'qty' => 1,
                'unit_price' => 975.0,
                'subtotal' => 975.0,
                'created_at' => '2025-04-22 03:38:24',
                'updated_at' => '2025-04-22 03:38:24',
            ),
            15 => 
            array (
                'id' => 18,
                'waste_id' => 14,
                'product_id' => 378,
                'qty' => 1,
                'unit_price' => 1495.0,
                'subtotal' => 1495.0,
                'created_at' => '2025-04-26 01:42:04',
                'updated_at' => '2025-04-26 01:42:04',
            ),
            16 => 
            array (
                'id' => 19,
                'waste_id' => 14,
                'product_id' => 118,
                'qty' => 1,
                'unit_price' => 695.0,
                'subtotal' => 695.0,
                'created_at' => '2025-04-26 01:42:04',
                'updated_at' => '2025-04-26 01:42:04',
            ),
            17 => 
            array (
                'id' => 20,
                'waste_id' => 14,
                'product_id' => 511,
                'qty' => 1,
                'unit_price' => 755.0,
                'subtotal' => 755.0,
                'created_at' => '2025-04-26 01:42:04',
                'updated_at' => '2025-04-26 01:42:04',
            ),
            18 => 
            array (
                'id' => 21,
                'waste_id' => 14,
                'product_id' => 7,
                'qty' => 1,
                'unit_price' => 625.0,
                'subtotal' => 625.0,
                'created_at' => '2025-04-26 01:42:04',
                'updated_at' => '2025-04-26 01:42:04',
            ),
            19 => 
            array (
                'id' => 22,
                'waste_id' => 14,
                'product_id' => 350,
                'qty' => 1,
                'unit_price' => 2195.0,
                'subtotal' => 2195.0,
                'created_at' => '2025-04-26 01:42:04',
                'updated_at' => '2025-04-26 01:42:04',
            ),
            20 => 
            array (
                'id' => 23,
                'waste_id' => 14,
                'product_id' => 371,
                'qty' => 1,
                'unit_price' => 850.0,
                'subtotal' => 850.0,
                'created_at' => '2025-04-26 01:42:04',
                'updated_at' => '2025-04-26 01:42:04',
            ),
            21 => 
            array (
                'id' => 24,
                'waste_id' => 14,
                'product_id' => 402,
                'qty' => 1,
                'unit_price' => 755.0,
                'subtotal' => 755.0,
                'created_at' => '2025-04-26 01:42:04',
                'updated_at' => '2025-04-26 01:42:04',
            ),
            22 => 
            array (
                'id' => 25,
                'waste_id' => 14,
                'product_id' => 404,
                'qty' => 1,
                'unit_price' => 755.0,
                'subtotal' => 755.0,
                'created_at' => '2025-04-26 01:42:04',
                'updated_at' => '2025-04-26 01:42:04',
            ),
            23 => 
            array (
                'id' => 26,
                'waste_id' => 14,
                'product_id' => 323,
                'qty' => 1,
                'unit_price' => 1695.0,
                'subtotal' => 1695.0,
                'created_at' => '2025-04-26 01:42:04',
                'updated_at' => '2025-04-26 01:42:04',
            ),
            24 => 
            array (
                'id' => 27,
                'waste_id' => 14,
                'product_id' => 44,
                'qty' => 1,
                'unit_price' => 1275.0,
                'subtotal' => 1275.0,
                'created_at' => '2025-04-26 01:42:04',
                'updated_at' => '2025-04-26 01:42:04',
            ),
            25 => 
            array (
                'id' => 28,
                'waste_id' => 14,
                'product_id' => 82,
                'qty' => 1,
                'unit_price' => 1250.0,
                'subtotal' => 1250.0,
                'created_at' => '2025-04-26 01:42:04',
                'updated_at' => '2025-04-26 01:42:04',
            ),
            26 => 
            array (
                'id' => 29,
                'waste_id' => 15,
                'product_id' => 474,
                'qty' => 1,
                'unit_price' => 495.0,
                'subtotal' => 495.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            27 => 
            array (
                'id' => 30,
                'waste_id' => 15,
                'product_id' => 2,
                'qty' => 1,
                'unit_price' => 1150.0,
                'subtotal' => 1150.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            28 => 
            array (
                'id' => 31,
                'waste_id' => 15,
                'product_id' => 167,
                'qty' => 1,
                'unit_price' => 1225.0,
                'subtotal' => 1225.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            29 => 
            array (
                'id' => 32,
                'waste_id' => 15,
                'product_id' => 444,
                'qty' => 1,
                'unit_price' => 595.0,
                'subtotal' => 595.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            30 => 
            array (
                'id' => 33,
                'waste_id' => 15,
                'product_id' => 359,
                'qty' => 1,
                'unit_price' => 795.0,
                'subtotal' => 795.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            31 => 
            array (
                'id' => 34,
                'waste_id' => 15,
                'product_id' => 361,
                'qty' => 1,
                'unit_price' => 795.0,
                'subtotal' => 795.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            32 => 
            array (
                'id' => 35,
                'waste_id' => 15,
                'product_id' => 605,
                'qty' => 1,
                'unit_price' => 755.0,
                'subtotal' => 755.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            33 => 
            array (
                'id' => 36,
                'waste_id' => 15,
                'product_id' => 114,
                'qty' => 1,
                'unit_price' => 595.0,
                'subtotal' => 595.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            34 => 
            array (
                'id' => 37,
                'waste_id' => 15,
                'product_id' => 114,
                'qty' => 1,
                'unit_price' => 595.0,
                'subtotal' => 595.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            35 => 
            array (
                'id' => 38,
                'waste_id' => 15,
                'product_id' => 151,
                'qty' => 1,
                'unit_price' => 2095.0,
                'subtotal' => 2095.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            36 => 
            array (
                'id' => 39,
                'waste_id' => 15,
                'product_id' => 587,
                'qty' => 1,
                'unit_price' => 995.0,
                'subtotal' => 995.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            37 => 
            array (
                'id' => 40,
                'waste_id' => 15,
                'product_id' => 28,
                'qty' => 1,
                'unit_price' => 750.0,
                'subtotal' => 750.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            38 => 
            array (
                'id' => 41,
                'waste_id' => 15,
                'product_id' => 203,
                'qty' => 1,
                'unit_price' => 725.0,
                'subtotal' => 725.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            39 => 
            array (
                'id' => 42,
                'waste_id' => 15,
                'product_id' => 102,
                'qty' => 1,
                'unit_price' => 695.0,
                'subtotal' => 695.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            40 => 
            array (
                'id' => 43,
                'waste_id' => 15,
                'product_id' => 133,
                'qty' => 1,
                'unit_price' => 695.0,
                'subtotal' => 695.0,
                'created_at' => '2025-04-26 01:47:31',
                'updated_at' => '2025-04-26 01:47:31',
            ),
            41 => 
            array (
                'id' => 44,
                'waste_id' => 16,
                'product_id' => 341,
                'qty' => 1,
                'unit_price' => 1095.0,
                'subtotal' => 1095.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            42 => 
            array (
                'id' => 45,
                'waste_id' => 16,
                'product_id' => 27,
                'qty' => 1,
                'unit_price' => 850.0,
                'subtotal' => 850.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            43 => 
            array (
                'id' => 46,
                'waste_id' => 16,
                'product_id' => 159,
                'qty' => 1,
                'unit_price' => 845.0,
                'subtotal' => 845.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            44 => 
            array (
                'id' => 47,
                'waste_id' => 16,
                'product_id' => 305,
                'qty' => 1,
                'unit_price' => 1050.0,
                'subtotal' => 1050.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            45 => 
            array (
                'id' => 48,
                'waste_id' => 16,
                'product_id' => 513,
                'qty' => 1,
                'unit_price' => 495.0,
                'subtotal' => 495.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            46 => 
            array (
                'id' => 49,
                'waste_id' => 16,
                'product_id' => 254,
                'qty' => 1,
                'unit_price' => 1355.0,
                'subtotal' => 1355.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            47 => 
            array (
                'id' => 50,
                'waste_id' => 16,
                'product_id' => 177,
                'qty' => 1,
                'unit_price' => 595.0,
                'subtotal' => 595.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            48 => 
            array (
                'id' => 51,
                'waste_id' => 16,
                'product_id' => 409,
                'qty' => 1,
                'unit_price' => 695.0,
                'subtotal' => 695.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            49 => 
            array (
                'id' => 52,
                'waste_id' => 16,
                'product_id' => 20,
                'qty' => 1,
                'unit_price' => 750.0,
                'subtotal' => 750.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            50 => 
            array (
                'id' => 53,
                'waste_id' => 16,
                'product_id' => 571,
                'qty' => 1,
                'unit_price' => 895.0,
                'subtotal' => 895.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            51 => 
            array (
                'id' => 54,
                'waste_id' => 16,
                'product_id' => 851,
                'qty' => 1,
                'unit_price' => 950.0,
                'subtotal' => 950.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            52 => 
            array (
                'id' => 55,
                'waste_id' => 16,
                'product_id' => 874,
                'qty' => 1,
                'unit_price' => 750.0,
                'subtotal' => 750.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            53 => 
            array (
                'id' => 56,
                'waste_id' => 16,
                'product_id' => 620,
                'qty' => 1,
                'unit_price' => 550.0,
                'subtotal' => 550.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            54 => 
            array (
                'id' => 57,
                'waste_id' => 16,
                'product_id' => 133,
                'qty' => 1,
                'unit_price' => 695.0,
                'subtotal' => 695.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            55 => 
            array (
                'id' => 58,
                'waste_id' => 16,
                'product_id' => 326,
                'qty' => 1,
                'unit_price' => 750.0,
                'subtotal' => 750.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            56 => 
            array (
                'id' => 59,
                'waste_id' => 16,
                'product_id' => 121,
                'qty' => 1,
                'unit_price' => 855.0,
                'subtotal' => 855.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            57 => 
            array (
                'id' => 60,
                'waste_id' => 16,
                'product_id' => 322,
                'qty' => 1,
                'unit_price' => 1595.0,
                'subtotal' => 1595.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
            58 => 
            array (
                'id' => 61,
                'waste_id' => 16,
                'product_id' => 313,
                'qty' => 1,
                'unit_price' => 1595.0,
                'subtotal' => 1595.0,
                'created_at' => '2025-04-26 01:51:18',
                'updated_at' => '2025-04-26 01:51:18',
            ),
        ));
        
        
    }
}