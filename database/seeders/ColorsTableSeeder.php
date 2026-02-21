<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('colors')->delete();
        
        \DB::table('colors')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Red',
                'code' => NULL,
                'created_at' => '2025-01-04 18:54:17',
                'updated_at' => '2025-01-19 17:57:08',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Green',
                'code' => NULL,
                'created_at' => '2025-01-04 18:54:17',
                'updated_at' => '2025-01-19 17:59:44',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Pink',
                'code' => NULL,
                'created_at' => '2025-01-05 08:46:54',
                'updated_at' => '2025-01-12 11:36:18',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Black',
                'code' => NULL,
                'created_at' => '2025-01-05 08:46:54',
                'updated_at' => '2025-01-07 09:21:22',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'BK',
                'code' => NULL,
                'created_at' => '2025-01-06 11:02:57',
                'updated_at' => '2025-01-06 11:30:29',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'CH',
                'code' => NULL,
                'created_at' => '2025-01-06 11:02:57',
                'updated_at' => '2025-01-06 11:02:57',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 're',
                'code' => NULL,
                'created_at' => '2025-01-06 18:38:59',
                'updated_at' => '2025-01-06 18:38:59',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'MR',
                'code' => NULL,
                'created_at' => '2025-01-08 05:42:05',
                'updated_at' => '2025-01-08 05:42:05',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'SY',
                'code' => NULL,
                'created_at' => '2025-01-08 10:40:11',
                'updated_at' => '2025-01-08 10:40:11',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'AS',
                'code' => NULL,
                'created_at' => '2025-01-08 10:40:11',
                'updated_at' => '2025-01-08 10:40:11',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'BR',
                'code' => NULL,
                'created_at' => '2025-01-08 10:55:25',
                'updated_at' => '2025-01-08 10:55:25',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'BL',
                'code' => NULL,
                'created_at' => '2025-01-08 10:59:20',
                'updated_at' => '2025-01-08 10:59:20',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'BLK',
                'code' => NULL,
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'SN',
                'code' => NULL,
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'SK',
                'code' => NULL,
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'SKN',
                'code' => NULL,
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'SKIN',
                'code' => NULL,
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Wi-L',
                'code' => NULL,
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Wi-S',
                'code' => NULL,
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Grey',
                'code' => NULL,
                'created_at' => '2025-01-12 11:05:38',
                'updated_at' => '2025-01-12 11:05:38',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Brown',
                'code' => NULL,
                'created_at' => '2025-01-12 11:17:52',
                'updated_at' => '2025-01-12 11:17:52',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Wi',
                'code' => NULL,
                'created_at' => '2025-01-19 13:52:20',
                'updated_at' => '2025-01-19 13:52:20',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => '41',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 25,
                'name' => 'AS-BK',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 26,
                'name' => 'AS-BL',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 27,
                'name' => 'Apricot',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 28,
                'name' => 'BE',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 30,
                'name' => 'BK Wi',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 31,
                'name' => 'BK-AS',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 32,
                'name' => 'BK-BL',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 34,
                'name' => 'BL-AS',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 40,
                'name' => 'Blue',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 43,
                'name' => 'CM',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 44,
                'name' => 'Chocolate',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 46,
                'name' => 'Coffe',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 47,
                'name' => 'Coffee',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 48,
                'name' => 'Cream',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 49,
                'name' => 'Golden',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 50,
                'name' => 'Gray',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 54,
                'name' => 'Maroon',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 55,
                'name' => 'Master',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 57,
                'name' => 'NAVY',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 58,
                'name' => 'Off Wi',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 59,
                'name' => 'Olive',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 60,
                'name' => 'Orng',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 62,
                'name' => 'PNK',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 63,
                'name' => 'PUR',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 65,
                'name' => 'Purple',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 71,
                'name' => 'SL',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 74,
                'name' => 'White',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 75,
                'name' => 'Whiteee',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 77,
                'name' => 'Wi BL',
                'code' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 78,
                'name' => 'Cyan',
                'code' => NULL,
                'created_at' => '2025-01-22 10:00:12',
                'updated_at' => '2025-01-22 10:00:12',
            ),
            53 => 
            array (
                'id' => 79,
                'name' => 'Silver',
                'code' => NULL,
                'created_at' => '2025-02-17 17:38:26',
                'updated_at' => '2025-02-17 17:38:26',
            ),
            54 => 
            array (
                'id' => 80,
                'name' => 'Sky Blue',
                'code' => NULL,
                'created_at' => '2025-05-27 15:59:05',
                'updated_at' => '2025-05-27 15:59:05',
            ),
        ));
        
        
    }
}