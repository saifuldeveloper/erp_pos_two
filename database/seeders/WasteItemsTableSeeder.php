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
                'id' => 1,
                'waste_id' => 1,
                'product_id' => 1023,
                'qty' => 1,
                'unit_price' => 1495.0,
                'subtotal' => 1495.0,
                'created_at' => '2025-03-06 23:35:28',
                'updated_at' => '2025-03-06 23:35:28',
            ),
            1 => 
            array (
                'id' => 19,
                'waste_id' => 7,
                'product_id' => 203,
                'qty' => 1,
                'unit_price' => 2095.0,
                'subtotal' => 2095.0,
                'created_at' => '2025-04-13 18:14:37',
                'updated_at' => '2025-04-13 18:14:37',
            ),
            2 => 
            array (
                'id' => 20,
                'waste_id' => 8,
                'product_id' => 583,
                'qty' => 1,
                'unit_price' => 655.0,
                'subtotal' => 655.0,
                'created_at' => '2025-04-13 18:15:45',
                'updated_at' => '2025-04-13 18:15:45',
            ),
            3 => 
            array (
                'id' => 21,
                'waste_id' => 8,
                'product_id' => 690,
                'qty' => 1,
                'unit_price' => 1555.0,
                'subtotal' => 1555.0,
                'created_at' => '2025-04-13 18:15:45',
                'updated_at' => '2025-04-13 18:15:45',
            ),
            4 => 
            array (
                'id' => 22,
                'waste_id' => 9,
                'product_id' => 649,
                'qty' => 1,
                'unit_price' => 2095.0,
                'subtotal' => 2095.0,
                'created_at' => '2025-04-13 18:17:28',
                'updated_at' => '2025-04-13 18:17:28',
            ),
            5 => 
            array (
                'id' => 23,
                'waste_id' => 2,
                'product_id' => 472,
                'qty' => 1,
                'unit_price' => 825.0,
                'subtotal' => 825.0,
                'created_at' => '2025-04-13 18:18:46',
                'updated_at' => '2025-04-13 18:18:46',
            ),
            6 => 
            array (
                'id' => 24,
                'waste_id' => 2,
                'product_id' => 779,
                'qty' => 1,
                'unit_price' => 1150.0,
                'subtotal' => 1150.0,
                'created_at' => '2025-04-13 18:18:46',
                'updated_at' => '2025-04-13 18:18:46',
            ),
            7 => 
            array (
                'id' => 25,
                'waste_id' => 3,
                'product_id' => 399,
                'qty' => 1,
                'unit_price' => 590.0,
                'subtotal' => 590.0,
                'created_at' => '2025-04-13 18:20:38',
                'updated_at' => '2025-04-13 18:20:38',
            ),
            8 => 
            array (
                'id' => 26,
                'waste_id' => 3,
                'product_id' => 907,
                'qty' => 1,
                'unit_price' => 1790.0,
                'subtotal' => 1790.0,
                'created_at' => '2025-04-13 18:20:38',
                'updated_at' => '2025-04-13 18:20:38',
            ),
            9 => 
            array (
                'id' => 27,
                'waste_id' => 3,
                'product_id' => 941,
                'qty' => 1,
                'unit_price' => 1890.0,
                'subtotal' => 1890.0,
                'created_at' => '2025-04-13 18:20:38',
                'updated_at' => '2025-04-13 18:20:38',
            ),
            10 => 
            array (
                'id' => 28,
                'waste_id' => 4,
                'product_id' => 1075,
                'qty' => 1,
                'unit_price' => 1595.0,
                'subtotal' => 1595.0,
                'created_at' => '2025-04-13 18:23:02',
                'updated_at' => '2025-04-13 18:23:02',
            ),
            11 => 
            array (
                'id' => 29,
                'waste_id' => 4,
                'product_id' => 397,
                'qty' => 1,
                'unit_price' => 350.0,
                'subtotal' => 350.0,
                'created_at' => '2025-04-13 18:23:02',
                'updated_at' => '2025-04-13 18:23:02',
            ),
            12 => 
            array (
                'id' => 30,
                'waste_id' => 5,
                'product_id' => 408,
                'qty' => 1,
                'unit_price' => 590.0,
                'subtotal' => 590.0,
                'created_at' => '2025-04-13 18:24:38',
                'updated_at' => '2025-04-13 18:24:38',
            ),
            13 => 
            array (
                'id' => 31,
                'waste_id' => 5,
                'product_id' => 817,
                'qty' => 1,
                'unit_price' => 1550.0,
                'subtotal' => 1550.0,
                'created_at' => '2025-04-13 18:24:38',
                'updated_at' => '2025-04-13 18:24:38',
            ),
            14 => 
            array (
                'id' => 32,
                'waste_id' => 5,
                'product_id' => 1125,
                'qty' => 1,
                'unit_price' => 1990.0,
                'subtotal' => 1990.0,
                'created_at' => '2025-04-13 18:24:38',
                'updated_at' => '2025-04-13 18:24:38',
            ),
            15 => 
            array (
                'id' => 33,
                'waste_id' => 6,
                'product_id' => 540,
                'qty' => 1,
                'unit_price' => 695.0,
                'subtotal' => 695.0,
                'created_at' => '2025-04-13 18:25:29',
                'updated_at' => '2025-04-13 18:25:29',
            ),
            16 => 
            array (
                'id' => 34,
                'waste_id' => 6,
                'product_id' => 1021,
                'qty' => 1,
                'unit_price' => 2095.0,
                'subtotal' => 2095.0,
                'created_at' => '2025-04-13 18:25:29',
                'updated_at' => '2025-04-13 18:25:29',
            ),
            17 => 
            array (
                'id' => 35,
                'waste_id' => 6,
                'product_id' => 271,
                'qty' => 1,
                'unit_price' => 1355.0,
                'subtotal' => 1355.0,
                'created_at' => '2025-04-13 18:25:29',
                'updated_at' => '2025-04-13 18:25:29',
            ),
            18 => 
            array (
                'id' => 36,
                'waste_id' => 10,
                'product_id' => 998,
                'qty' => 1,
                'unit_price' => 1990.0,
                'subtotal' => 1990.0,
                'created_at' => '2025-04-13 19:54:24',
                'updated_at' => '2025-04-13 19:54:24',
            ),
            19 => 
            array (
                'id' => 37,
                'waste_id' => 10,
                'product_id' => 763,
                'qty' => 1,
                'unit_price' => 1555.0,
                'subtotal' => 1555.0,
                'created_at' => '2025-04-13 19:54:24',
                'updated_at' => '2025-04-13 19:54:24',
            ),
            20 => 
            array (
                'id' => 38,
                'waste_id' => 10,
                'product_id' => 161,
                'qty' => 1,
                'unit_price' => 1495.0,
                'subtotal' => 1495.0,
                'created_at' => '2025-04-13 19:54:24',
                'updated_at' => '2025-04-13 19:54:24',
            ),
            21 => 
            array (
                'id' => 39,
                'waste_id' => 11,
                'product_id' => 1038,
                'qty' => 1,
                'unit_price' => 1450.0,
                'subtotal' => 1450.0,
                'created_at' => '2025-04-13 19:59:11',
                'updated_at' => '2025-04-13 19:59:11',
            ),
            22 => 
            array (
                'id' => 40,
                'waste_id' => 11,
                'product_id' => 399,
                'qty' => 1,
                'unit_price' => 590.0,
                'subtotal' => 590.0,
                'created_at' => '2025-04-13 19:59:11',
                'updated_at' => '2025-04-13 19:59:11',
            ),
            23 => 
            array (
                'id' => 41,
                'waste_id' => 12,
                'product_id' => 1021,
                'qty' => 1,
                'unit_price' => 2095.0,
                'subtotal' => 2095.0,
                'created_at' => '2025-04-13 20:09:45',
                'updated_at' => '2025-04-13 20:09:45',
            ),
            24 => 
            array (
                'id' => 42,
                'waste_id' => 13,
                'product_id' => 777,
                'qty' => 1,
                'unit_price' => 1295.0,
                'subtotal' => 1295.0,
                'created_at' => '2025-04-13 20:13:49',
                'updated_at' => '2025-04-13 20:13:49',
            ),
            25 => 
            array (
                'id' => 43,
                'waste_id' => 13,
                'product_id' => 1008,
                'qty' => 1,
                'unit_price' => 2990.0,
                'subtotal' => 2990.0,
                'created_at' => '2025-04-13 20:13:49',
                'updated_at' => '2025-04-13 20:13:49',
            ),
            26 => 
            array (
                'id' => 44,
                'waste_id' => 14,
                'product_id' => 203,
                'qty' => 1,
                'unit_price' => 2095.0,
                'subtotal' => 2095.0,
                'created_at' => '2025-04-13 20:16:02',
                'updated_at' => '2025-04-13 20:16:02',
            ),
            27 => 
            array (
                'id' => 45,
                'waste_id' => 15,
                'product_id' => 649,
                'qty' => 1,
                'unit_price' => 2095.0,
                'subtotal' => 2095.0,
                'created_at' => '2025-04-14 19:33:41',
                'updated_at' => '2025-04-14 19:33:41',
            ),
            28 => 
            array (
                'id' => 46,
                'waste_id' => 15,
                'product_id' => 1020,
                'qty' => 1,
                'unit_price' => 2095.0,
                'subtotal' => 2095.0,
                'created_at' => '2025-04-14 19:33:41',
                'updated_at' => '2025-04-14 19:33:41',
            ),
            29 => 
            array (
                'id' => 47,
                'waste_id' => 15,
                'product_id' => 693,
                'qty' => 1,
                'unit_price' => 895.0,
                'subtotal' => 895.0,
                'created_at' => '2025-04-14 19:33:41',
                'updated_at' => '2025-04-14 19:33:41',
            ),
            30 => 
            array (
                'id' => 48,
                'waste_id' => 16,
                'product_id' => 1021,
                'qty' => 1,
                'unit_price' => 2095.0,
                'subtotal' => 2095.0,
                'created_at' => '2025-04-14 20:00:12',
                'updated_at' => '2025-04-14 20:00:12',
            ),
            31 => 
            array (
                'id' => 49,
                'waste_id' => 17,
                'product_id' => 1096,
                'qty' => 1,
                'unit_price' => 995.0,
                'subtotal' => 995.0,
                'created_at' => '2025-05-03 15:24:16',
                'updated_at' => '2025-05-03 15:24:16',
            ),
            32 => 
            array (
                'id' => 50,
                'waste_id' => 19,
                'product_id' => 993,
                'qty' => 1,
                'unit_price' => 2195.0,
                'subtotal' => 2195.0,
                'created_at' => '2025-10-02 08:35:24',
                'updated_at' => '2025-10-02 08:35:24',
            ),
            33 => 
            array (
                'id' => 51,
                'waste_id' => 19,
                'product_id' => 780,
                'qty' => 1,
                'unit_price' => 1150.0,
                'subtotal' => 1150.0,
                'created_at' => '2025-10-02 08:35:24',
                'updated_at' => '2025-10-02 08:35:24',
            ),
            34 => 
            array (
                'id' => 53,
                'waste_id' => 21,
                'product_id' => 993,
                'qty' => 1,
                'unit_price' => 2195.0,
                'subtotal' => 2195.0,
                'created_at' => '2025-10-05 05:19:31',
                'updated_at' => '2025-10-05 05:19:31',
            ),
            35 => 
            array (
                'id' => 54,
                'waste_id' => 22,
                'product_id' => 780,
                'qty' => 1,
                'unit_price' => 1150.0,
                'subtotal' => 1150.0,
                'created_at' => '2025-10-05 05:20:45',
                'updated_at' => '2025-10-05 05:20:45',
            ),
        ));
        
        
    }
}