<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VariantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('variants')->delete();
        
        \DB::table('variants')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '26/Red',
                'created_at' => '2024-12-11 00:04:36',
                'updated_at' => '2024-12-11 00:04:36',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Red/26',
                'created_at' => '2024-12-11 00:06:25',
                'updated_at' => '2024-12-11 00:06:25',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Red/28',
                'created_at' => '2024-12-11 00:06:25',
                'updated_at' => '2024-12-11 00:06:25',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Green/26',
                'created_at' => '2024-12-11 00:06:25',
                'updated_at' => '2024-12-11 00:06:25',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Green/28',
                'created_at' => '2024-12-11 00:06:25',
                'updated_at' => '2024-12-11 00:06:25',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Brown/40',
                'created_at' => '2024-12-11 22:55:50',
                'updated_at' => '2024-12-11 22:55:50',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Brown/41',
                'created_at' => '2024-12-11 22:55:50',
                'updated_at' => '2024-12-11 22:55:50',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Brown/42',
                'created_at' => '2024-12-11 22:55:50',
                'updated_at' => '2024-12-11 22:55:50',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Brown/43',
                'created_at' => '2024-12-11 22:55:50',
                'updated_at' => '2024-12-11 22:55:50',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Brown/44',
                'created_at' => '2024-12-11 22:55:50',
                'updated_at' => '2024-12-11 22:55:50',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Green/40',
                'created_at' => '2024-12-11 23:06:22',
                'updated_at' => '2024-12-11 23:06:22',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Green/41',
                'created_at' => '2024-12-11 23:06:22',
                'updated_at' => '2024-12-11 23:06:22',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Green/42',
                'created_at' => '2024-12-11 23:06:22',
                'updated_at' => '2024-12-11 23:06:22',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Green/43',
                'created_at' => '2024-12-11 23:06:22',
                'updated_at' => '2024-12-11 23:06:22',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Green/44',
                'created_at' => '2024-12-11 23:06:22',
                'updated_at' => '2024-12-11 23:06:22',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Black/40',
                'created_at' => '2024-12-11 23:40:50',
                'updated_at' => '2025-01-19 18:02:38',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Black/41',
                'created_at' => '2024-12-11 23:40:50',
                'updated_at' => '2025-01-19 18:02:38',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Black/42',
                'created_at' => '2024-12-11 23:40:50',
                'updated_at' => '2025-01-01 00:04:54',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Black/43',
                'created_at' => '2024-12-11 23:40:50',
                'updated_at' => '2025-01-01 00:04:54',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Black/44',
                'created_at' => '2024-12-11 23:40:50',
                'updated_at' => '2025-01-01 00:04:54',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'White/40',
                'created_at' => '2024-12-11 23:47:39',
                'updated_at' => '2024-12-11 23:47:39',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'White/41',
                'created_at' => '2024-12-11 23:47:39',
                'updated_at' => '2024-12-11 23:47:39',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'White/42',
                'created_at' => '2024-12-11 23:47:39',
                'updated_at' => '2024-12-11 23:47:39',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'White/43',
                'created_at' => '2024-12-11 23:47:39',
                'updated_at' => '2024-12-11 23:47:39',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'White/44',
                'created_at' => '2024-12-11 23:47:39',
                'updated_at' => '2024-12-11 23:47:39',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Black/39',
                'created_at' => '2024-12-11 23:52:22',
                'updated_at' => '2025-01-19 18:02:38',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Olive/39',
                'created_at' => '2024-12-11 23:55:37',
                'updated_at' => '2024-12-11 23:55:37',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Olive/40',
                'created_at' => '2024-12-11 23:55:37',
                'updated_at' => '2024-12-11 23:55:37',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Olive/41',
                'created_at' => '2024-12-11 23:55:37',
                'updated_at' => '2024-12-11 23:55:37',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Olive/42',
                'created_at' => '2024-12-11 23:55:37',
                'updated_at' => '2024-12-11 23:55:37',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Olive/43',
                'created_at' => '2024-12-11 23:55:37',
                'updated_at' => '2024-12-11 23:55:37',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Grey/41',
                'created_at' => '2024-12-11 23:59:06',
                'updated_at' => '2024-12-11 23:59:06',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Grey/42',
                'created_at' => '2024-12-11 23:59:06',
                'updated_at' => '2024-12-11 23:59:06',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Grey/43',
                'created_at' => '2024-12-11 23:59:06',
                'updated_at' => '2024-12-11 23:59:06',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Grey/44',
                'created_at' => '2024-12-11 23:59:06',
                'updated_at' => '2024-12-11 23:59:06',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Grey/40',
                'created_at' => '2024-12-11 23:59:06',
                'updated_at' => '2024-12-11 23:59:06',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'White/.42',
                'created_at' => '2024-12-12 00:39:48',
                'updated_at' => '2024-12-12 00:39:48',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Pink/36',
                'created_at' => '2024-12-12 01:05:07',
                'updated_at' => '2025-01-12 13:33:35',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Pink/37',
                'created_at' => '2024-12-12 01:05:07',
                'updated_at' => '2025-01-12 13:33:35',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Pink/38',
                'created_at' => '2024-12-12 01:05:07',
                'updated_at' => '2025-01-12 13:33:35',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Pink/39',
                'created_at' => '2024-12-12 01:05:07',
                'updated_at' => '2025-01-12 13:33:35',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Pink/40',
                'created_at' => '2024-12-12 01:05:07',
                'updated_at' => '2025-01-12 13:33:35',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Purple/36',
                'created_at' => '2024-12-12 01:11:24',
                'updated_at' => '2024-12-12 01:11:24',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Purple/37',
                'created_at' => '2024-12-12 01:11:24',
                'updated_at' => '2024-12-12 01:11:24',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Purple/38',
                'created_at' => '2024-12-12 01:11:24',
                'updated_at' => '2024-12-12 01:11:24',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Purple/39',
                'created_at' => '2024-12-12 01:11:24',
                'updated_at' => '2024-12-12 01:11:24',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Purple/40',
                'created_at' => '2024-12-12 01:11:24',
                'updated_at' => '2024-12-12 01:11:24',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'PL/36',
                'created_at' => '2024-12-12 01:34:09',
                'updated_at' => '2024-12-12 01:34:09',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'PL/37',
                'created_at' => '2024-12-12 01:34:09',
                'updated_at' => '2024-12-12 01:34:09',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'PL/38',
                'created_at' => '2024-12-12 01:34:09',
                'updated_at' => '2024-12-12 01:34:09',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'PL/39',
                'created_at' => '2024-12-12 01:34:09',
                'updated_at' => '2024-12-12 01:34:09',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'PL/40',
                'created_at' => '2024-12-12 01:34:09',
                'updated_at' => '2024-12-12 01:34:09',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Black/36',
                'created_at' => '2024-12-12 01:35:41',
                'updated_at' => '2024-12-12 01:35:41',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'Black/37',
                'created_at' => '2024-12-12 01:35:41',
                'updated_at' => '2024-12-12 01:35:41',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'Black/38',
                'created_at' => '2024-12-12 01:35:41',
                'updated_at' => '2024-12-12 01:35:41',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'White/37',
                'created_at' => '2024-12-12 01:47:45',
                'updated_at' => '2024-12-12 01:47:45',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'White/38',
                'created_at' => '2024-12-12 01:47:45',
                'updated_at' => '2024-12-12 01:47:45',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'White/39',
                'created_at' => '2024-12-12 01:47:45',
                'updated_at' => '2024-12-12 01:47:45',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'Pink/41',
                'created_at' => '2024-12-12 02:09:45',
                'updated_at' => '2024-12-22 22:26:07',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'White/36',
                'created_at' => '2024-12-12 02:13:56',
                'updated_at' => '2024-12-12 02:13:56',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'Brown/36',
                'created_at' => '2024-12-12 02:18:00',
                'updated_at' => '2024-12-12 02:18:00',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'Brown/37',
                'created_at' => '2024-12-12 02:18:00',
                'updated_at' => '2024-12-12 02:18:00',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'Brown/38',
                'created_at' => '2024-12-12 02:18:00',
                'updated_at' => '2024-12-12 02:18:00',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'Brown/39',
                'created_at' => '2024-12-12 02:18:00',
                'updated_at' => '2024-12-12 02:18:00',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'Cream/36',
                'created_at' => '2024-12-12 02:21:59',
                'updated_at' => '2024-12-12 02:21:59',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'Cream/37',
                'created_at' => '2024-12-12 02:21:59',
                'updated_at' => '2024-12-12 02:21:59',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'Cream/38',
                'created_at' => '2024-12-12 02:21:59',
                'updated_at' => '2024-12-12 02:21:59',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'Cream/39',
                'created_at' => '2024-12-12 02:21:59',
                'updated_at' => '2024-12-12 02:21:59',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'Cream/40',
                'created_at' => '2024-12-12 02:21:59',
                'updated_at' => '2024-12-12 02:21:59',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'Cream/41',
                'created_at' => '2024-12-12 02:21:59',
                'updated_at' => '2024-12-12 02:21:59',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'Blue/40',
                'created_at' => '2024-12-12 02:30:48',
                'updated_at' => '2024-12-12 02:30:48',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'Blue/41',
                'created_at' => '2024-12-12 02:30:48',
                'updated_at' => '2024-12-12 02:30:48',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'Blue/42',
                'created_at' => '2024-12-12 02:30:48',
                'updated_at' => '2024-12-12 02:30:48',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'Blue/43',
                'created_at' => '2024-12-12 02:30:48',
                'updated_at' => '2024-12-12 02:30:48',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'Blue/44',
                'created_at' => '2024-12-12 02:30:48',
                'updated_at' => '2024-12-12 02:30:48',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'Red/36',
                'created_at' => '2024-12-12 03:01:27',
                'updated_at' => '2025-01-19 17:57:23',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'Red/37',
                'created_at' => '2024-12-12 03:01:27',
                'updated_at' => '2025-01-19 17:57:23',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'Red/38',
                'created_at' => '2024-12-12 03:01:27',
                'updated_at' => '2024-12-18 06:26:50',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'Red/39',
                'created_at' => '2024-12-12 03:01:27',
                'updated_at' => '2024-12-18 06:26:50',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'Red/40',
                'created_at' => '2024-12-12 03:01:27',
                'updated_at' => '2025-01-19 17:57:23',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'Blue/36',
                'created_at' => '2024-12-12 03:57:52',
                'updated_at' => '2024-12-12 03:57:52',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'Blue/37',
                'created_at' => '2024-12-12 03:57:52',
                'updated_at' => '2024-12-12 03:57:52',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'Blue/38',
                'created_at' => '2024-12-12 03:57:52',
                'updated_at' => '2024-12-12 03:57:52',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'Blue/39',
                'created_at' => '2024-12-12 03:57:52',
                'updated_at' => '2024-12-12 03:57:52',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'Brown/27',
                'created_at' => '2024-12-12 04:13:10',
                'updated_at' => '2024-12-12 04:13:10',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'Brown/28',
                'created_at' => '2024-12-12 04:13:10',
                'updated_at' => '2024-12-12 04:13:10',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'Brown/29',
                'created_at' => '2024-12-12 04:13:10',
                'updated_at' => '2024-12-12 04:13:10',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'Brown/30',
                'created_at' => '2024-12-12 04:13:10',
                'updated_at' => '2024-12-12 04:13:10',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'Brown/31',
                'created_at' => '2024-12-12 04:13:10',
                'updated_at' => '2024-12-12 04:13:10',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'Blue/27',
                'created_at' => '2024-12-12 04:15:15',
                'updated_at' => '2024-12-12 04:15:15',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'Blue/28',
                'created_at' => '2024-12-12 04:15:15',
                'updated_at' => '2024-12-12 04:15:15',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'Blue/29',
                'created_at' => '2024-12-12 04:15:15',
                'updated_at' => '2024-12-12 04:15:15',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'Blue/30',
                'created_at' => '2024-12-12 04:15:15',
                'updated_at' => '2024-12-12 04:15:15',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'Blue/31',
                'created_at' => '2024-12-12 04:15:15',
                'updated_at' => '2024-12-12 04:15:15',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'Brown/33',
                'created_at' => '2024-12-12 04:18:10',
                'updated_at' => '2024-12-12 04:18:10',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'Brown/34',
                'created_at' => '2024-12-12 04:18:10',
                'updated_at' => '2024-12-12 04:18:10',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'Brown/35',
                'created_at' => '2024-12-12 04:18:10',
                'updated_at' => '2024-12-12 04:18:10',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'Black/33',
                'created_at' => '2024-12-12 04:19:26',
                'updated_at' => '2024-12-12 04:19:26',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'Black/34',
                'created_at' => '2024-12-12 04:19:26',
                'updated_at' => '2024-12-12 04:19:26',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'Black/35',
                'created_at' => '2024-12-12 04:19:26',
                'updated_at' => '2024-12-12 04:19:26',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'Black/32',
                'created_at' => '2024-12-12 04:27:09',
                'updated_at' => '2024-12-12 04:27:09',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'Blue/32',
                'created_at' => '2024-12-12 04:31:05',
                'updated_at' => '2024-12-12 04:31:05',
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'Blue/33',
                'created_at' => '2024-12-12 04:31:05',
                'updated_at' => '2024-12-12 04:31:05',
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'Blue/34',
                'created_at' => '2024-12-12 04:31:05',
                'updated_at' => '2024-12-12 04:31:05',
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'Blue/35',
                'created_at' => '2024-12-12 04:31:05',
                'updated_at' => '2024-12-12 04:31:05',
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'Green/36',
                'created_at' => '2024-12-12 04:36:04',
                'updated_at' => '2024-12-12 04:36:04',
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'Green/37',
                'created_at' => '2024-12-12 04:36:04',
                'updated_at' => '2024-12-12 04:36:04',
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'Green/38',
                'created_at' => '2024-12-12 04:36:04',
                'updated_at' => '2024-12-12 04:36:04',
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'Green/39',
                'created_at' => '2024-12-12 04:36:04',
                'updated_at' => '2024-12-12 04:36:04',
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'Orange/36',
                'created_at' => '2024-12-12 04:38:03',
                'updated_at' => '2024-12-12 04:38:03',
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'Orange/37',
                'created_at' => '2024-12-12 04:38:03',
                'updated_at' => '2024-12-12 04:38:03',
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'Orange/38',
                'created_at' => '2024-12-12 04:38:03',
                'updated_at' => '2024-12-12 04:38:03',
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'Orange/39',
                'created_at' => '2024-12-12 04:38:03',
                'updated_at' => '2024-12-12 04:38:03',
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'Orange/40',
                'created_at' => '2024-12-12 04:38:03',
                'updated_at' => '2024-12-12 04:38:03',
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'Orng/36',
                'created_at' => '2024-12-12 04:39:35',
                'updated_at' => '2024-12-12 04:39:35',
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'Orng/37',
                'created_at' => '2024-12-12 04:39:35',
                'updated_at' => '2024-12-12 04:39:35',
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'Orng/38',
                'created_at' => '2024-12-12 04:39:35',
                'updated_at' => '2024-12-12 04:39:35',
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'Orng/39',
                'created_at' => '2024-12-12 04:39:35',
                'updated_at' => '2024-12-12 04:39:35',
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'Orng/40',
                'created_at' => '2024-12-12 04:39:35',
                'updated_at' => '2024-12-12 04:39:35',
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'Olive/26',
                'created_at' => '2024-12-12 04:41:44',
                'updated_at' => '2024-12-12 04:41:44',
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'Olive/27',
                'created_at' => '2024-12-12 04:41:44',
                'updated_at' => '2024-12-12 04:41:44',
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'Olive/28',
                'created_at' => '2024-12-12 04:41:44',
                'updated_at' => '2024-12-12 04:41:44',
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'Olive/29',
                'created_at' => '2024-12-12 04:41:44',
                'updated_at' => '2024-12-12 04:41:44',
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'Olive/30',
                'created_at' => '2024-12-12 04:41:44',
                'updated_at' => '2024-12-12 04:41:44',
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'Brown/26',
                'created_at' => '2024-12-12 04:43:18',
                'updated_at' => '2024-12-12 04:43:18',
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'Green/33',
                'created_at' => '2024-12-17 00:09:24',
                'updated_at' => '2024-12-17 00:09:24',
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'Whiteee/33',
                'created_at' => '2024-12-17 00:09:24',
                'updated_at' => '2024-12-17 00:09:24',
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'Olive/36',
                'created_at' => '2024-12-17 00:28:35',
                'updated_at' => '2024-12-17 00:28:35',
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'Olive/37',
                'created_at' => '2024-12-17 00:28:35',
                'updated_at' => '2024-12-17 00:28:35',
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'Olive/38',
                'created_at' => '2024-12-17 00:28:35',
                'updated_at' => '2024-12-17 00:28:35',
            ),
            130 => 
            array (
                'id' => 131,
                'name' => '40',
                'created_at' => '2024-12-18 01:00:25',
                'updated_at' => '2024-12-18 01:00:25',
            ),
            131 => 
            array (
                'id' => 132,
                'name' => '41',
                'created_at' => '2024-12-18 01:00:25',
                'updated_at' => '2024-12-18 01:00:25',
            ),
            132 => 
            array (
                'id' => 133,
                'name' => '42',
                'created_at' => '2024-12-18 01:00:25',
                'updated_at' => '2024-12-18 01:00:25',
            ),
            133 => 
            array (
                'id' => 134,
                'name' => '43',
                'created_at' => '2024-12-18 01:00:25',
                'updated_at' => '2024-12-18 01:00:25',
            ),
            134 => 
            array (
                'id' => 135,
                'name' => '44',
                'created_at' => '2024-12-18 01:00:25',
                'updated_at' => '2024-12-18 01:00:25',
            ),
            135 => 
            array (
                'id' => 136,
                'name' => '45',
                'created_at' => '2024-12-18 01:00:25',
                'updated_at' => '2024-12-18 01:00:25',
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'greengreengreen/38',
                'created_at' => '2024-12-18 06:30:54',
                'updated_at' => '2024-12-18 06:30:54',
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'greengreengreen/39',
                'created_at' => '2024-12-18 06:30:54',
                'updated_at' => '2024-12-18 06:30:54',
            ),
            138 => 
            array (
                'id' => 139,
                'name' => '34',
                'created_at' => '2024-12-19 05:40:56',
                'updated_at' => '2024-12-19 05:40:56',
            ),
            139 => 
            array (
                'id' => 140,
                'name' => '35',
                'created_at' => '2024-12-19 05:40:56',
                'updated_at' => '2024-12-19 05:40:56',
            ),
            140 => 
            array (
                'id' => 141,
                'name' => '36',
                'created_at' => '2024-12-19 05:40:56',
                'updated_at' => '2024-12-19 05:40:56',
            ),
            141 => 
            array (
                'id' => 142,
                'name' => '37',
                'created_at' => '2024-12-19 05:40:56',
                'updated_at' => '2024-12-19 05:40:56',
            ),
            142 => 
            array (
                'id' => 143,
                'name' => '38',
                'created_at' => '2024-12-19 05:40:56',
                'updated_at' => '2024-12-19 05:40:56',
            ),
            143 => 
            array (
                'id' => 144,
                'name' => '39',
                'created_at' => '2024-12-19 05:40:56',
                'updated_at' => '2024-12-19 05:40:56',
            ),
            144 => 
            array (
                'id' => 145,
                'name' => '29',
                'created_at' => '2024-12-19 05:40:56',
                'updated_at' => '2024-12-19 05:40:56',
            ),
            145 => 
            array (
                'id' => 146,
                'name' => '30',
                'created_at' => '2024-12-19 05:40:57',
                'updated_at' => '2024-12-19 05:40:57',
            ),
            146 => 
            array (
                'id' => 147,
                'name' => '31',
                'created_at' => '2024-12-19 05:40:57',
                'updated_at' => '2024-12-19 05:40:57',
            ),
            147 => 
            array (
                'id' => 148,
                'name' => '32',
                'created_at' => '2024-12-19 05:40:57',
                'updated_at' => '2024-12-19 05:40:57',
            ),
            148 => 
            array (
                'id' => 149,
                'name' => '33',
                'created_at' => '2024-12-19 05:40:57',
                'updated_at' => '2024-12-19 05:40:57',
            ),
            149 => 
            array (
                'id' => 150,
                'name' => '41/black',
                'created_at' => '2024-12-19 06:09:35',
                'updated_at' => '2024-12-19 06:09:35',
            ),
            150 => 
            array (
                'id' => 151,
                'name' => 'Red/29',
                'created_at' => '2024-12-21 00:45:00',
                'updated_at' => '2024-12-21 00:45:00',
            ),
            151 => 
            array (
                'id' => 152,
                'name' => 'White/26',
                'created_at' => '2024-12-21 00:45:00',
                'updated_at' => '2024-12-21 00:45:00',
            ),
            152 => 
            array (
                'id' => 153,
                'name' => 'White/28',
                'created_at' => '2024-12-21 00:45:00',
                'updated_at' => '2024-12-21 00:45:00',
            ),
            153 => 
            array (
                'id' => 154,
                'name' => 'White/29',
                'created_at' => '2024-12-21 00:45:00',
                'updated_at' => '2024-12-21 00:45:00',
            ),
            154 => 
            array (
                'id' => 155,
                'name' => 'Red/27',
                'created_at' => '2024-12-21 05:21:07',
                'updated_at' => '2024-12-21 05:21:07',
            ),
            155 => 
            array (
                'id' => 156,
                'name' => 'Green/27',
                'created_at' => '2024-12-21 05:21:08',
                'updated_at' => '2024-12-21 05:21:08',
            ),
            156 => 
            array (
                'id' => 157,
                'name' => 'Green/29',
                'created_at' => '2024-12-21 05:21:08',
                'updated_at' => '2024-12-21 05:21:08',
            ),
            157 => 
            array (
                'id' => 158,
                'name' => 'Blue/26',
                'created_at' => '2024-12-21 05:21:08',
                'updated_at' => '2024-12-21 05:21:08',
            ),
            158 => 
            array (
                'id' => 159,
                'name' => 'Golden/36',
                'created_at' => '2024-12-22 22:27:25',
                'updated_at' => '2024-12-22 22:27:25',
            ),
            159 => 
            array (
                'id' => 160,
                'name' => 'Golden/37',
                'created_at' => '2024-12-22 22:27:25',
                'updated_at' => '2024-12-22 22:27:25',
            ),
            160 => 
            array (
                'id' => 161,
                'name' => 'Golden/38',
                'created_at' => '2024-12-22 22:27:25',
                'updated_at' => '2024-12-22 22:27:25',
            ),
            161 => 
            array (
                'id' => 162,
                'name' => 'Golden/39',
                'created_at' => '2024-12-22 22:27:25',
                'updated_at' => '2024-12-22 22:27:25',
            ),
            162 => 
            array (
                'id' => 163,
                'name' => 'Golden/40',
                'created_at' => '2024-12-22 22:27:25',
                'updated_at' => '2024-12-22 22:27:25',
            ),
            163 => 
            array (
                'id' => 164,
                'name' => 'Golden/41',
                'created_at' => '2024-12-22 22:27:25',
                'updated_at' => '2024-12-22 22:27:25',
            ),
            164 => 
            array (
                'id' => 165,
                'name' => 'Apricot/36',
                'created_at' => '2024-12-22 22:38:02',
                'updated_at' => '2024-12-22 22:38:02',
            ),
            165 => 
            array (
                'id' => 166,
                'name' => 'Apricot/37',
                'created_at' => '2024-12-22 22:38:02',
                'updated_at' => '2024-12-22 22:38:02',
            ),
            166 => 
            array (
                'id' => 167,
                'name' => 'Apricot/38',
                'created_at' => '2024-12-22 22:38:02',
                'updated_at' => '2024-12-22 22:38:02',
            ),
            167 => 
            array (
                'id' => 168,
                'name' => 'Apricot/39',
                'created_at' => '2024-12-22 22:38:02',
                'updated_at' => '2024-12-22 22:38:02',
            ),
            168 => 
            array (
                'id' => 169,
                'name' => 'Apricot/40',
                'created_at' => '2024-12-22 22:38:02',
                'updated_at' => '2024-12-22 22:38:02',
            ),
            169 => 
            array (
                'id' => 170,
                'name' => 'Apricot/41',
                'created_at' => '2024-12-22 22:38:02',
                'updated_at' => '2024-12-22 22:38:02',
            ),
            170 => 
            array (
                'id' => 171,
                'name' => 'Coffe/36',
                'created_at' => '2024-12-22 22:40:46',
                'updated_at' => '2024-12-22 22:40:46',
            ),
            171 => 
            array (
                'id' => 172,
                'name' => 'Coffe/37',
                'created_at' => '2024-12-22 22:40:46',
                'updated_at' => '2024-12-22 22:40:46',
            ),
            172 => 
            array (
                'id' => 173,
                'name' => 'Coffe/38',
                'created_at' => '2024-12-22 22:40:46',
                'updated_at' => '2024-12-22 22:40:46',
            ),
            173 => 
            array (
                'id' => 174,
                'name' => 'Coffe/39',
                'created_at' => '2024-12-22 22:40:46',
                'updated_at' => '2024-12-22 22:40:46',
            ),
            174 => 
            array (
                'id' => 175,
                'name' => 'Coffe/40',
                'created_at' => '2024-12-22 22:40:46',
                'updated_at' => '2024-12-22 22:40:46',
            ),
            175 => 
            array (
                'id' => 176,
                'name' => 'Coffe/41',
                'created_at' => '2024-12-22 22:40:46',
                'updated_at' => '2024-12-22 22:40:46',
            ),
            176 => 
            array (
                'id' => 177,
                'name' => 'Purple/41',
                'created_at' => '2024-12-22 22:53:23',
                'updated_at' => '2024-12-22 22:53:23',
            ),
            177 => 
            array (
                'id' => 178,
                'name' => 'Coffee/36',
                'created_at' => '2024-12-22 22:55:32',
                'updated_at' => '2024-12-22 22:55:32',
            ),
            178 => 
            array (
                'id' => 179,
                'name' => 'Coffee/37',
                'created_at' => '2024-12-22 22:55:32',
                'updated_at' => '2024-12-22 22:55:32',
            ),
            179 => 
            array (
                'id' => 180,
                'name' => 'Coffee/38',
                'created_at' => '2024-12-22 22:55:32',
                'updated_at' => '2024-12-22 22:55:32',
            ),
            180 => 
            array (
                'id' => 181,
                'name' => 'Coffee/39',
                'created_at' => '2024-12-22 22:55:32',
                'updated_at' => '2024-12-22 22:55:32',
            ),
            181 => 
            array (
                'id' => 182,
                'name' => 'Coffee/40',
                'created_at' => '2024-12-22 22:55:32',
                'updated_at' => '2024-12-22 22:55:32',
            ),
            182 => 
            array (
                'id' => 183,
                'name' => 'Coffee/41',
                'created_at' => '2024-12-22 22:55:32',
                'updated_at' => '2024-12-22 22:55:32',
            ),
            183 => 
            array (
                'id' => 184,
                'name' => 'Master/35',
                'created_at' => '2024-12-22 23:13:42',
                'updated_at' => '2024-12-22 23:13:42',
            ),
            184 => 
            array (
                'id' => 185,
                'name' => 'Master/36',
                'created_at' => '2024-12-22 23:13:42',
                'updated_at' => '2024-12-22 23:13:42',
            ),
            185 => 
            array (
                'id' => 186,
                'name' => 'Master/37',
                'created_at' => '2024-12-22 23:13:42',
                'updated_at' => '2024-12-22 23:13:42',
            ),
            186 => 
            array (
                'id' => 187,
                'name' => 'Master/38',
                'created_at' => '2024-12-22 23:13:42',
                'updated_at' => '2024-12-22 23:13:42',
            ),
            187 => 
            array (
                'id' => 188,
                'name' => 'Master/39',
                'created_at' => '2024-12-22 23:13:42',
                'updated_at' => '2024-12-22 23:13:42',
            ),
            188 => 
            array (
                'id' => 189,
                'name' => 'Master/40',
                'created_at' => '2024-12-22 23:13:42',
                'updated_at' => '2024-12-22 23:13:42',
            ),
            189 => 
            array (
                'id' => 190,
                'name' => 'Black/369',
                'created_at' => '2024-12-22 23:17:22',
                'updated_at' => '2024-12-22 23:17:22',
            ),
            190 => 
            array (
                'id' => 191,
                'name' => 'Black/6',
                'created_at' => '2024-12-23 00:17:33',
                'updated_at' => '2024-12-31 23:54:36',
            ),
            191 => 
            array (
                'id' => 192,
                'name' => 'Black/7',
                'created_at' => '2024-12-23 00:17:33',
                'updated_at' => '2024-12-31 23:54:36',
            ),
            192 => 
            array (
                'id' => 193,
                'name' => 'Black/8',
                'created_at' => '2024-12-23 00:17:33',
                'updated_at' => '2024-12-31 23:54:36',
            ),
            193 => 
            array (
                'id' => 194,
                'name' => 'Black/9',
                'created_at' => '2024-12-23 00:17:33',
                'updated_at' => '2024-12-31 23:54:36',
            ),
            194 => 
            array (
                'id' => 195,
                'name' => 'Black/10',
                'created_at' => '2024-12-23 00:17:33',
                'updated_at' => '2025-01-19 18:02:54',
            ),
            195 => 
            array (
                'id' => 196,
                'name' => 'Black/11',
                'created_at' => '2024-12-23 00:17:33',
                'updated_at' => '2024-12-23 00:17:33',
            ),
            196 => 
            array (
                'id' => 197,
                'name' => 'Gray/36',
                'created_at' => '2024-12-23 00:33:12',
                'updated_at' => '2024-12-23 00:33:12',
            ),
            197 => 
            array (
                'id' => 198,
                'name' => 'Gray/37',
                'created_at' => '2024-12-23 00:33:12',
                'updated_at' => '2024-12-23 00:33:12',
            ),
            198 => 
            array (
                'id' => 199,
                'name' => 'Gray/38',
                'created_at' => '2024-12-23 00:33:12',
                'updated_at' => '2024-12-23 00:33:12',
            ),
            199 => 
            array (
                'id' => 200,
                'name' => 'Gray/39',
                'created_at' => '2024-12-23 00:33:12',
                'updated_at' => '2024-12-23 00:33:12',
            ),
            200 => 
            array (
                'id' => 201,
                'name' => 'Gray/40',
                'created_at' => '2024-12-23 00:33:12',
                'updated_at' => '2024-12-23 00:33:12',
            ),
            201 => 
            array (
                'id' => 202,
                'name' => 'Coffee/35',
                'created_at' => '2024-12-23 00:34:20',
                'updated_at' => '2024-12-23 00:34:20',
            ),
            202 => 
            array (
                'id' => 203,
                'name' => 'Gray/42',
                'created_at' => '2024-12-23 00:37:59',
                'updated_at' => '2024-12-23 00:37:59',
            ),
            203 => 
            array (
                'id' => 204,
                'name' => 'Gray/43',
                'created_at' => '2024-12-23 00:37:59',
                'updated_at' => '2024-12-23 00:37:59',
            ),
            204 => 
            array (
                'id' => 205,
                'name' => 'Gray/44',
                'created_at' => '2024-12-23 00:37:59',
                'updated_at' => '2024-12-23 00:37:59',
            ),
            205 => 
            array (
                'id' => 206,
                'name' => 'Master/42',
                'created_at' => '2024-12-23 00:39:18',
                'updated_at' => '2024-12-23 00:39:18',
            ),
            206 => 
            array (
                'id' => 207,
                'name' => 'Master/43',
                'created_at' => '2024-12-23 00:39:18',
                'updated_at' => '2024-12-23 00:39:18',
            ),
            207 => 
            array (
                'id' => 208,
                'name' => 'Master/44',
                'created_at' => '2024-12-23 00:39:18',
                'updated_at' => '2024-12-23 00:39:18',
            ),
            208 => 
            array (
                'id' => 209,
                'name' => 'Master/41',
                'created_at' => '2024-12-23 00:44:37',
                'updated_at' => '2024-12-23 00:44:37',
            ),
            209 => 
            array (
                'id' => 210,
                'name' => 'Gray/41',
                'created_at' => '2024-12-23 00:45:23',
                'updated_at' => '2024-12-23 00:45:23',
            ),
            210 => 
            array (
                'id' => 211,
                'name' => 'Cream/6',
                'created_at' => '2024-12-23 00:48:28',
                'updated_at' => '2024-12-23 00:48:28',
            ),
            211 => 
            array (
                'id' => 212,
                'name' => 'Cream/7',
                'created_at' => '2024-12-23 00:48:28',
                'updated_at' => '2024-12-23 00:48:28',
            ),
            212 => 
            array (
                'id' => 213,
                'name' => 'Cream/8',
                'created_at' => '2024-12-23 00:48:28',
                'updated_at' => '2024-12-23 00:48:28',
            ),
            213 => 
            array (
                'id' => 214,
                'name' => 'Cream/9',
                'created_at' => '2024-12-23 00:48:28',
                'updated_at' => '2024-12-23 00:48:28',
            ),
            214 => 
            array (
                'id' => 215,
                'name' => 'Cream/10',
                'created_at' => '2024-12-23 00:48:28',
                'updated_at' => '2024-12-23 00:48:28',
            ),
            215 => 
            array (
                'id' => 216,
                'name' => 'Cream/11',
                'created_at' => '2024-12-23 00:48:28',
                'updated_at' => '2024-12-23 00:48:28',
            ),
            216 => 
            array (
                'id' => 217,
                'name' => 'Pink/6',
                'created_at' => '2024-12-23 00:49:09',
                'updated_at' => '2024-12-23 00:49:09',
            ),
            217 => 
            array (
                'id' => 218,
                'name' => 'Pink/7',
                'created_at' => '2024-12-23 00:49:09',
                'updated_at' => '2024-12-23 00:49:09',
            ),
            218 => 
            array (
                'id' => 219,
                'name' => 'Pink/8',
                'created_at' => '2024-12-23 00:49:09',
                'updated_at' => '2024-12-23 00:49:09',
            ),
            219 => 
            array (
                'id' => 220,
                'name' => 'Pink/9',
                'created_at' => '2024-12-23 00:49:09',
                'updated_at' => '2024-12-23 00:49:09',
            ),
            220 => 
            array (
                'id' => 221,
                'name' => 'Pink/10',
                'created_at' => '2024-12-23 00:49:09',
                'updated_at' => '2025-01-19 18:01:45',
            ),
            221 => 
            array (
                'id' => 222,
                'name' => 'Pink/11',
                'created_at' => '2024-12-23 00:49:09',
                'updated_at' => '2024-12-23 00:49:09',
            ),
            222 => 
            array (
                'id' => 223,
                'name' => 'Coffee/6',
                'created_at' => '2024-12-23 00:53:18',
                'updated_at' => '2024-12-23 00:53:18',
            ),
            223 => 
            array (
                'id' => 224,
                'name' => 'Coffee/7',
                'created_at' => '2024-12-23 00:53:18',
                'updated_at' => '2024-12-23 00:53:18',
            ),
            224 => 
            array (
                'id' => 225,
                'name' => 'Coffee/8',
                'created_at' => '2024-12-23 00:53:18',
                'updated_at' => '2024-12-23 00:53:18',
            ),
            225 => 
            array (
                'id' => 226,
                'name' => 'Coffee/9',
                'created_at' => '2024-12-23 00:53:18',
                'updated_at' => '2024-12-23 00:53:18',
            ),
            226 => 
            array (
                'id' => 227,
                'name' => 'Coffee/10',
                'created_at' => '2024-12-23 00:53:18',
                'updated_at' => '2024-12-23 00:53:18',
            ),
            227 => 
            array (
                'id' => 228,
                'name' => 'Master/5',
                'created_at' => '2024-12-23 00:56:19',
                'updated_at' => '2024-12-23 00:56:19',
            ),
            228 => 
            array (
                'id' => 229,
                'name' => 'Master/7',
                'created_at' => '2024-12-23 00:56:19',
                'updated_at' => '2024-12-23 00:56:19',
            ),
            229 => 
            array (
                'id' => 230,
                'name' => 'Master/6',
                'created_at' => '2024-12-23 00:56:19',
                'updated_at' => '2024-12-23 00:56:19',
            ),
            230 => 
            array (
                'id' => 231,
                'name' => 'Master/8',
                'created_at' => '2024-12-23 00:56:19',
                'updated_at' => '2024-12-23 00:56:19',
            ),
            231 => 
            array (
                'id' => 232,
                'name' => 'Master/9',
                'created_at' => '2024-12-23 00:56:19',
                'updated_at' => '2024-12-23 00:56:19',
            ),
            232 => 
            array (
                'id' => 233,
                'name' => 'Master/10',
                'created_at' => '2024-12-23 00:56:19',
                'updated_at' => '2024-12-23 00:56:19',
            ),
            233 => 
            array (
                'id' => 234,
                'name' => 'Brown/7',
                'created_at' => '2024-12-23 01:48:34',
                'updated_at' => '2024-12-23 01:48:34',
            ),
            234 => 
            array (
                'id' => 235,
                'name' => 'Brown/8',
                'created_at' => '2024-12-23 01:48:34',
                'updated_at' => '2024-12-23 01:48:34',
            ),
            235 => 
            array (
                'id' => 236,
                'name' => 'Brown/9',
                'created_at' => '2024-12-23 01:48:34',
                'updated_at' => '2024-12-23 01:48:34',
            ),
            236 => 
            array (
                'id' => 237,
                'name' => 'Brown/10',
                'created_at' => '2024-12-23 01:48:34',
                'updated_at' => '2024-12-23 01:48:34',
            ),
            237 => 
            array (
                'id' => 238,
                'name' => 'Brown/6',
                'created_at' => '2024-12-23 01:48:34',
                'updated_at' => '2024-12-23 01:48:34',
            ),
            238 => 
            array (
                'id' => 239,
                'name' => 'Maroon/36',
                'created_at' => '2024-12-23 02:03:08',
                'updated_at' => '2024-12-23 02:03:08',
            ),
            239 => 
            array (
                'id' => 240,
                'name' => 'Maroon/37',
                'created_at' => '2024-12-23 02:03:08',
                'updated_at' => '2024-12-23 02:03:08',
            ),
            240 => 
            array (
                'id' => 241,
                'name' => 'Maroon/38',
                'created_at' => '2024-12-23 02:03:08',
                'updated_at' => '2024-12-23 02:03:08',
            ),
            241 => 
            array (
                'id' => 242,
                'name' => 'Maroon/39',
                'created_at' => '2024-12-23 02:03:08',
                'updated_at' => '2024-12-23 02:03:08',
            ),
            242 => 
            array (
                'id' => 243,
                'name' => 'Maroon/40',
                'created_at' => '2024-12-23 02:03:08',
                'updated_at' => '2024-12-23 02:03:08',
            ),
            243 => 
            array (
                'id' => 244,
                'name' => 'Maroon/41',
                'created_at' => '2024-12-23 02:03:08',
                'updated_at' => '2024-12-23 02:03:08',
            ),
            244 => 
            array (
                'id' => 245,
                'name' => 'Chocolate/39',
                'created_at' => '2024-12-23 02:19:40',
                'updated_at' => '2024-12-23 02:19:40',
            ),
            245 => 
            array (
                'id' => 246,
                'name' => 'Chocolate/40',
                'created_at' => '2024-12-23 02:19:40',
                'updated_at' => '2024-12-23 06:38:20',
            ),
            246 => 
            array (
                'id' => 247,
                'name' => 'Chocolate/41',
                'created_at' => '2024-12-23 02:19:40',
                'updated_at' => '2024-12-23 06:38:20',
            ),
            247 => 
            array (
                'id' => 248,
                'name' => 'Chocolate/42',
                'created_at' => '2024-12-23 02:19:40',
                'updated_at' => '2024-12-23 06:38:20',
            ),
            248 => 
            array (
                'id' => 249,
                'name' => 'Chocolate/43',
                'created_at' => '2024-12-23 02:19:40',
                'updated_at' => '2024-12-23 06:38:20',
            ),
            249 => 
            array (
                'id' => 250,
                'name' => 'Chocolate/44',
                'created_at' => '2024-12-23 02:19:40',
                'updated_at' => '2024-12-23 02:19:40',
            ),
            250 => 
            array (
                'id' => 251,
                'name' => 'Coffee/11',
                'created_at' => '2024-12-23 03:46:10',
                'updated_at' => '2024-12-23 03:46:10',
            ),
            251 => 
            array (
                'id' => 252,
                'name' => 'Golden/5',
                'created_at' => '2024-12-23 04:29:32',
                'updated_at' => '2024-12-23 04:29:32',
            ),
            252 => 
            array (
                'id' => 253,
                'name' => 'Golden/6',
                'created_at' => '2024-12-23 04:29:32',
                'updated_at' => '2024-12-23 04:29:32',
            ),
            253 => 
            array (
                'id' => 254,
                'name' => 'Golden/7',
                'created_at' => '2024-12-23 04:29:32',
                'updated_at' => '2024-12-23 04:29:32',
            ),
            254 => 
            array (
                'id' => 255,
                'name' => 'Golden/8',
                'created_at' => '2024-12-23 04:29:32',
                'updated_at' => '2024-12-23 04:29:32',
            ),
            255 => 
            array (
                'id' => 256,
                'name' => 'Golden/9',
                'created_at' => '2024-12-23 04:29:32',
                'updated_at' => '2024-12-23 04:29:32',
            ),
            256 => 
            array (
                'id' => 257,
                'name' => 'Golden/10',
                'created_at' => '2024-12-23 04:29:32',
                'updated_at' => '2024-12-23 04:29:32',
            ),
            257 => 
            array (
                'id' => 258,
                'name' => 'Chocolate/35',
                'created_at' => '2024-12-23 06:24:37',
                'updated_at' => '2024-12-23 06:24:37',
            ),
            258 => 
            array (
                'id' => 259,
                'name' => 'Chocolate/36',
                'created_at' => '2024-12-23 06:24:37',
                'updated_at' => '2024-12-23 06:24:37',
            ),
            259 => 
            array (
                'id' => 260,
                'name' => 'Chocolate/37',
                'created_at' => '2024-12-23 06:24:37',
                'updated_at' => '2024-12-23 06:24:37',
            ),
            260 => 
            array (
                'id' => 261,
                'name' => 'Chocolate/38',
                'created_at' => '2024-12-23 06:24:37',
                'updated_at' => '2024-12-23 06:24:37',
            ),
            261 => 
            array (
                'id' => 262,
                'name' => 'Black/5',
                'created_at' => '2024-12-23 06:39:55',
                'updated_at' => '2024-12-23 06:39:55',
            ),
            262 => 
            array (
                'id' => 263,
                'name' => 'Black/12',
                'created_at' => '2024-12-23 08:16:26',
                'updated_at' => '2025-01-19 18:02:54',
            ),
            263 => 
            array (
                'id' => 264,
                'name' => 'Black/13',
                'created_at' => '2024-12-23 08:16:26',
                'updated_at' => '2024-12-23 08:16:26',
            ),
            264 => 
            array (
                'id' => 265,
                'name' => 'Black/14',
                'created_at' => '2024-12-23 08:16:26',
                'updated_at' => '2024-12-23 08:16:26',
            ),
            265 => 
            array (
                'id' => 266,
                'name' => 'Black/15',
                'created_at' => '2024-12-23 08:16:26',
                'updated_at' => '2024-12-23 08:16:26',
            ),
            266 => 
            array (
                'id' => 267,
                'name' => 'Chocolate/10',
                'created_at' => '2024-12-23 08:37:39',
                'updated_at' => '2024-12-23 08:37:39',
            ),
            267 => 
            array (
                'id' => 268,
                'name' => 'Chocolate/11',
                'created_at' => '2024-12-23 08:37:39',
                'updated_at' => '2024-12-23 08:37:39',
            ),
            268 => 
            array (
                'id' => 269,
                'name' => 'Chocolate/12',
                'created_at' => '2024-12-23 08:37:39',
                'updated_at' => '2024-12-23 08:37:39',
            ),
            269 => 
            array (
                'id' => 270,
                'name' => 'Chocolate/13',
                'created_at' => '2024-12-23 08:37:39',
                'updated_at' => '2024-12-23 08:37:39',
            ),
            270 => 
            array (
                'id' => 271,
                'name' => 'Chocolate/14',
                'created_at' => '2024-12-23 08:37:39',
                'updated_at' => '2024-12-23 08:37:39',
            ),
            271 => 
            array (
                'id' => 272,
                'name' => 'Chocolate/15',
                'created_at' => '2024-12-23 08:37:39',
                'updated_at' => '2024-12-23 08:37:39',
            ),
            272 => 
            array (
                'id' => 273,
                'name' => 'Black/1',
                'created_at' => '2024-12-23 08:45:21',
                'updated_at' => '2024-12-23 08:45:21',
            ),
            273 => 
            array (
                'id' => 274,
                'name' => 'Black/2',
                'created_at' => '2024-12-23 08:45:21',
                'updated_at' => '2024-12-23 08:45:21',
            ),
            274 => 
            array (
                'id' => 275,
                'name' => 'Black/3',
                'created_at' => '2024-12-23 08:45:21',
                'updated_at' => '2024-12-23 08:45:21',
            ),
            275 => 
            array (
                'id' => 276,
                'name' => 'Black/4',
                'created_at' => '2024-12-23 08:45:21',
                'updated_at' => '2024-12-23 08:45:21',
            ),
            276 => 
            array (
                'id' => 277,
                'name' => 'Chocolate/6',
                'created_at' => '2024-12-23 09:17:56',
                'updated_at' => '2024-12-23 09:17:56',
            ),
            277 => 
            array (
                'id' => 278,
                'name' => 'Chocolate/7',
                'created_at' => '2024-12-23 09:17:56',
                'updated_at' => '2024-12-23 09:17:56',
            ),
            278 => 
            array (
                'id' => 279,
                'name' => 'Chocolate/8',
                'created_at' => '2024-12-23 09:17:56',
                'updated_at' => '2024-12-23 09:17:56',
            ),
            279 => 
            array (
                'id' => 280,
                'name' => 'Chocolate/9',
                'created_at' => '2024-12-23 09:17:56',
                'updated_at' => '2024-12-23 09:17:56',
            ),
            280 => 
            array (
                'id' => 281,
                'name' => 'Grey/27',
                'created_at' => '2024-12-24 07:40:45',
                'updated_at' => '2024-12-24 07:40:45',
            ),
            281 => 
            array (
                'id' => 282,
                'name' => 'Grey/28',
                'created_at' => '2024-12-24 07:40:45',
                'updated_at' => '2024-12-24 07:40:45',
            ),
            282 => 
            array (
                'id' => 283,
                'name' => 'Grey/29',
                'created_at' => '2024-12-24 07:40:45',
                'updated_at' => '2024-12-24 07:40:45',
            ),
            283 => 
            array (
                'id' => 284,
                'name' => 'Grey/30',
                'created_at' => '2024-12-24 07:40:45',
                'updated_at' => '2024-12-24 07:40:45',
            ),
            284 => 
            array (
                'id' => 285,
                'name' => 'Grey/32',
                'created_at' => '2024-12-24 07:40:45',
                'updated_at' => '2024-12-24 07:40:45',
            ),
            285 => 
            array (
                'id' => 286,
                'name' => 'CM/39',
                'created_at' => '2024-12-31 00:51:20',
                'updated_at' => '2025-01-19 18:06:27',
            ),
            286 => 
            array (
                'id' => 287,
                'name' => 'CM/40',
                'created_at' => '2024-12-31 00:51:20',
                'updated_at' => '2025-01-19 18:06:27',
            ),
            287 => 
            array (
                'id' => 288,
                'name' => 'CM/41',
                'created_at' => '2024-12-31 00:51:20',
                'updated_at' => '2025-01-19 18:06:27',
            ),
            288 => 
            array (
                'id' => 289,
                'name' => 'CM/42',
                'created_at' => '2024-12-31 00:51:20',
                'updated_at' => '2025-01-19 18:06:27',
            ),
            289 => 
            array (
                'id' => 290,
                'name' => 'CM/43',
                'created_at' => '2024-12-31 00:51:20',
                'updated_at' => '2025-01-19 18:06:27',
            ),
            290 => 
            array (
                'id' => 291,
                'name' => 'MR/39',
                'created_at' => '2024-12-31 00:59:36',
                'updated_at' => '2025-01-19 18:04:34',
            ),
            291 => 
            array (
                'id' => 292,
                'name' => 'MR/40',
                'created_at' => '2024-12-31 00:59:36',
                'updated_at' => '2024-12-31 01:48:59',
            ),
            292 => 
            array (
                'id' => 293,
                'name' => 'MR/41',
                'created_at' => '2024-12-31 00:59:36',
                'updated_at' => '2024-12-31 01:48:59',
            ),
            293 => 
            array (
                'id' => 294,
                'name' => 'MR/42',
                'created_at' => '2024-12-31 00:59:36',
                'updated_at' => '2024-12-31 01:48:59',
            ),
            294 => 
            array (
                'id' => 295,
                'name' => 'MR/43',
                'created_at' => '2024-12-31 00:59:36',
                'updated_at' => '2024-12-31 01:48:59',
            ),
            295 => 
            array (
                'id' => 296,
                'name' => 'AS/40',
                'created_at' => '2024-12-31 01:10:59',
                'updated_at' => '2024-12-31 01:10:59',
            ),
            296 => 
            array (
                'id' => 297,
                'name' => 'AS/41',
                'created_at' => '2024-12-31 01:10:59',
                'updated_at' => '2024-12-31 01:10:59',
            ),
            297 => 
            array (
                'id' => 298,
                'name' => 'AS/42',
                'created_at' => '2024-12-31 01:10:59',
                'updated_at' => '2024-12-31 01:10:59',
            ),
            298 => 
            array (
                'id' => 299,
                'name' => 'AS/43',
                'created_at' => '2024-12-31 01:10:59',
                'updated_at' => '2024-12-31 01:10:59',
            ),
            299 => 
            array (
                'id' => 300,
                'name' => 'MR/44',
                'created_at' => '2024-12-31 01:48:59',
                'updated_at' => '2024-12-31 01:48:59',
            ),
            300 => 
            array (
                'id' => 301,
                'name' => 'Wi/39',
                'created_at' => '2024-12-31 01:59:17',
                'updated_at' => '2025-01-01 05:23:28',
            ),
            301 => 
            array (
                'id' => 302,
                'name' => 'Wi/40',
                'created_at' => '2024-12-31 01:59:17',
                'updated_at' => '2025-01-01 05:23:28',
            ),
            302 => 
            array (
                'id' => 303,
                'name' => 'Wi/41',
                'created_at' => '2024-12-31 01:59:17',
                'updated_at' => '2025-01-01 08:51:42',
            ),
            303 => 
            array (
                'id' => 304,
                'name' => 'Wi/42',
                'created_at' => '2024-12-31 01:59:17',
                'updated_at' => '2025-01-01 08:51:42',
            ),
            304 => 
            array (
                'id' => 305,
                'name' => 'Wi/43',
                'created_at' => '2024-12-31 01:59:17',
                'updated_at' => '2025-01-01 08:51:42',
            ),
            305 => 
            array (
                'id' => 306,
                'name' => 'Wi/44',
                'created_at' => '2024-12-31 01:59:17',
                'updated_at' => '2025-01-01 08:51:42',
            ),
            306 => 
            array (
                'id' => 307,
                'name' => 'CH/39',
                'created_at' => '2024-12-31 02:55:16',
                'updated_at' => '2024-12-31 02:55:16',
            ),
            307 => 
            array (
                'id' => 308,
                'name' => 'CH/40',
                'created_at' => '2024-12-31 02:55:16',
                'updated_at' => '2024-12-31 02:55:16',
            ),
            308 => 
            array (
                'id' => 309,
                'name' => 'CH/41',
                'created_at' => '2024-12-31 02:55:16',
                'updated_at' => '2024-12-31 02:55:16',
            ),
            309 => 
            array (
                'id' => 310,
                'name' => 'CH/42',
                'created_at' => '2024-12-31 02:55:16',
                'updated_at' => '2024-12-31 02:55:16',
            ),
            310 => 
            array (
                'id' => 311,
                'name' => 'CH/43',
                'created_at' => '2024-12-31 02:55:16',
                'updated_at' => '2024-12-31 02:55:16',
            ),
            311 => 
            array (
                'id' => 312,
                'name' => 'CH/44',
                'created_at' => '2024-12-31 03:21:16',
                'updated_at' => '2024-12-31 03:21:16',
            ),
            312 => 
            array (
                'id' => 313,
                'name' => 'Black/45',
                'created_at' => '2024-12-31 06:53:12',
                'updated_at' => '2025-01-19 18:02:38',
            ),
            313 => 
            array (
                'id' => 314,
                'name' => 'Black/46',
                'created_at' => '2024-12-31 06:53:12',
                'updated_at' => '2025-01-19 18:02:38',
            ),
            314 => 
            array (
                'id' => 315,
                'name' => 'Pink/12',
                'created_at' => '2025-01-01 00:58:36',
                'updated_at' => '2025-01-01 00:58:36',
            ),
            315 => 
            array (
                'id' => 316,
                'name' => 'Pink/13',
                'created_at' => '2025-01-01 00:58:36',
                'updated_at' => '2025-01-01 00:58:36',
            ),
            316 => 
            array (
                'id' => 317,
                'name' => 'Pink/1',
                'created_at' => '2025-01-01 00:58:36',
                'updated_at' => '2025-01-01 00:58:36',
            ),
            317 => 
            array (
                'id' => 318,
                'name' => 'Pink/2',
                'created_at' => '2025-01-01 00:58:36',
                'updated_at' => '2025-01-01 00:58:36',
            ),
            318 => 
            array (
                'id' => 319,
                'name' => 'Pink/3',
                'created_at' => '2025-01-01 00:58:36',
                'updated_at' => '2025-01-01 00:58:36',
            ),
            319 => 
            array (
                'id' => 320,
                'name' => 'Pink/4',
                'created_at' => '2025-01-01 00:58:36',
                'updated_at' => '2025-01-01 00:58:36',
            ),
            320 => 
            array (
                'id' => 321,
                'name' => 'CM/12',
                'created_at' => '2025-01-01 01:06:47',
                'updated_at' => '2025-01-01 01:06:47',
            ),
            321 => 
            array (
                'id' => 322,
                'name' => 'CM/13',
                'created_at' => '2025-01-01 01:06:47',
                'updated_at' => '2025-01-01 01:06:47',
            ),
            322 => 
            array (
                'id' => 323,
                'name' => 'CM/1',
                'created_at' => '2025-01-01 01:06:47',
                'updated_at' => '2025-01-01 01:06:47',
            ),
            323 => 
            array (
                'id' => 324,
                'name' => 'CM/2',
                'created_at' => '2025-01-01 01:06:47',
                'updated_at' => '2025-01-01 01:06:47',
            ),
            324 => 
            array (
                'id' => 325,
                'name' => 'CM/3',
                'created_at' => '2025-01-01 01:06:47',
                'updated_at' => '2025-01-01 01:06:47',
            ),
            325 => 
            array (
                'id' => 326,
                'name' => 'CM/4',
                'created_at' => '2025-01-01 01:06:47',
                'updated_at' => '2025-01-01 01:06:47',
            ),
            326 => 
            array (
                'id' => 327,
                'name' => 'Pink/30',
                'created_at' => '2025-01-01 01:33:59',
                'updated_at' => '2025-01-01 01:33:59',
            ),
            327 => 
            array (
                'id' => 328,
                'name' => 'Pink/31',
                'created_at' => '2025-01-01 01:33:59',
                'updated_at' => '2025-01-01 01:33:59',
            ),
            328 => 
            array (
                'id' => 329,
                'name' => 'Pink/32',
                'created_at' => '2025-01-01 01:33:59',
                'updated_at' => '2025-01-01 01:33:59',
            ),
            329 => 
            array (
                'id' => 330,
                'name' => 'Pink/33',
                'created_at' => '2025-01-01 01:33:59',
                'updated_at' => '2025-01-01 01:33:59',
            ),
            330 => 
            array (
                'id' => 331,
                'name' => 'Pink/34',
                'created_at' => '2025-01-01 01:33:59',
                'updated_at' => '2025-01-01 01:33:59',
            ),
            331 => 
            array (
                'id' => 332,
                'name' => 'CM/30',
                'created_at' => '2025-01-01 01:42:29',
                'updated_at' => '2025-01-01 01:42:29',
            ),
            332 => 
            array (
                'id' => 333,
                'name' => 'CM/31',
                'created_at' => '2025-01-01 01:42:29',
                'updated_at' => '2025-01-01 01:42:29',
            ),
            333 => 
            array (
                'id' => 334,
                'name' => 'CM/32',
                'created_at' => '2025-01-01 01:42:29',
                'updated_at' => '2025-01-01 01:42:29',
            ),
            334 => 
            array (
                'id' => 335,
                'name' => 'CM/33',
                'created_at' => '2025-01-01 01:42:29',
                'updated_at' => '2025-01-01 01:42:29',
            ),
            335 => 
            array (
                'id' => 336,
                'name' => 'CM/34',
                'created_at' => '2025-01-01 01:42:29',
                'updated_at' => '2025-01-01 01:42:29',
            ),
            336 => 
            array (
                'id' => 337,
                'name' => 'Pink/35',
                'created_at' => '2025-01-01 01:51:30',
                'updated_at' => '2025-01-01 01:51:30',
            ),
            337 => 
            array (
                'id' => 338,
                'name' => 'Wi/36',
                'created_at' => '2025-01-01 05:23:28',
                'updated_at' => '2025-01-01 05:23:28',
            ),
            338 => 
            array (
                'id' => 339,
                'name' => 'Wi/37',
                'created_at' => '2025-01-01 05:23:28',
                'updated_at' => '2025-01-01 05:23:28',
            ),
            339 => 
            array (
                'id' => 340,
                'name' => 'Wi/38',
                'created_at' => '2025-01-01 05:23:28',
                'updated_at' => '2025-01-01 05:23:28',
            ),
            340 => 
            array (
                'id' => 341,
                'name' => 'Off Wi/36',
                'created_at' => '2025-01-01 05:33:44',
                'updated_at' => '2025-01-01 05:33:44',
            ),
            341 => 
            array (
                'id' => 342,
                'name' => 'Off Wi/37',
                'created_at' => '2025-01-01 05:33:44',
                'updated_at' => '2025-01-01 05:33:44',
            ),
            342 => 
            array (
                'id' => 343,
                'name' => 'Off Wi/38',
                'created_at' => '2025-01-01 05:33:44',
                'updated_at' => '2025-01-01 05:33:44',
            ),
            343 => 
            array (
                'id' => 344,
                'name' => 'Off Wi/39',
                'created_at' => '2025-01-01 05:33:44',
                'updated_at' => '2025-01-01 05:33:44',
            ),
            344 => 
            array (
                'id' => 345,
                'name' => 'Off Wi/40',
                'created_at' => '2025-01-01 05:33:44',
                'updated_at' => '2025-01-01 05:33:44',
            ),
            345 => 
            array (
                'id' => 346,
                'name' => 'PUR/36',
                'created_at' => '2025-01-01 05:44:56',
                'updated_at' => '2025-01-01 05:44:56',
            ),
            346 => 
            array (
                'id' => 347,
                'name' => 'PUR/37',
                'created_at' => '2025-01-01 05:44:56',
                'updated_at' => '2025-01-01 05:44:56',
            ),
            347 => 
            array (
                'id' => 348,
                'name' => 'PUR/38',
                'created_at' => '2025-01-01 05:44:56',
                'updated_at' => '2025-01-01 05:44:56',
            ),
            348 => 
            array (
                'id' => 349,
                'name' => 'PUR/39',
                'created_at' => '2025-01-01 05:44:56',
                'updated_at' => '2025-01-01 05:44:56',
            ),
            349 => 
            array (
                'id' => 350,
                'name' => 'PUR/40',
                'created_at' => '2025-01-01 05:44:56',
                'updated_at' => '2025-01-01 05:44:56',
            ),
            350 => 
            array (
                'id' => 351,
                'name' => 'BK/36',
                'created_at' => '2025-01-01 05:48:19',
                'updated_at' => '2025-01-01 05:48:19',
            ),
            351 => 
            array (
                'id' => 352,
                'name' => 'BK/37',
                'created_at' => '2025-01-01 05:48:19',
                'updated_at' => '2025-01-01 05:48:19',
            ),
            352 => 
            array (
                'id' => 353,
                'name' => 'BK/38',
                'created_at' => '2025-01-01 05:48:19',
                'updated_at' => '2025-01-01 05:48:19',
            ),
            353 => 
            array (
                'id' => 354,
                'name' => 'BK/39',
                'created_at' => '2025-01-01 05:48:19',
                'updated_at' => '2025-01-01 05:48:19',
            ),
            354 => 
            array (
                'id' => 355,
                'name' => 'BK/40',
                'created_at' => '2025-01-01 05:48:19',
                'updated_at' => '2025-01-01 05:48:19',
            ),
            355 => 
            array (
                'id' => 356,
                'name' => 'NAVY/36',
                'created_at' => '2025-01-01 06:02:56',
                'updated_at' => '2025-01-01 06:02:56',
            ),
            356 => 
            array (
                'id' => 357,
                'name' => 'NAVY/37',
                'created_at' => '2025-01-01 06:02:56',
                'updated_at' => '2025-01-01 06:02:56',
            ),
            357 => 
            array (
                'id' => 358,
                'name' => 'NAVY/38',
                'created_at' => '2025-01-01 06:02:56',
                'updated_at' => '2025-01-01 06:02:56',
            ),
            358 => 
            array (
                'id' => 359,
                'name' => 'NAVY/39',
                'created_at' => '2025-01-01 06:02:56',
                'updated_at' => '2025-01-01 06:02:56',
            ),
            359 => 
            array (
                'id' => 360,
                'name' => 'NAVY/40',
                'created_at' => '2025-01-01 06:02:56',
                'updated_at' => '2025-01-01 06:02:56',
            ),
            360 => 
            array (
                'id' => 361,
                'name' => 'MR/36',
                'created_at' => '2025-01-01 06:59:54',
                'updated_at' => '2025-01-01 06:59:54',
            ),
            361 => 
            array (
                'id' => 362,
                'name' => 'MR/37',
                'created_at' => '2025-01-01 06:59:54',
                'updated_at' => '2025-01-01 06:59:54',
            ),
            362 => 
            array (
                'id' => 363,
                'name' => 'MR/38',
                'created_at' => '2025-01-01 06:59:54',
                'updated_at' => '2025-01-01 06:59:54',
            ),
            363 => 
            array (
                'id' => 364,
                'name' => 'BE/36',
                'created_at' => '2025-01-01 08:31:35',
                'updated_at' => '2025-01-01 08:31:35',
            ),
            364 => 
            array (
                'id' => 365,
                'name' => 'BE/37',
                'created_at' => '2025-01-01 08:31:35',
                'updated_at' => '2025-01-01 08:31:35',
            ),
            365 => 
            array (
                'id' => 366,
                'name' => 'BE/38',
                'created_at' => '2025-01-01 08:31:35',
                'updated_at' => '2025-01-01 08:31:35',
            ),
            366 => 
            array (
                'id' => 367,
                'name' => 'BE/39',
                'created_at' => '2025-01-01 08:31:35',
                'updated_at' => '2025-01-01 08:31:35',
            ),
            367 => 
            array (
                'id' => 368,
                'name' => 'BE/40',
                'created_at' => '2025-01-01 08:31:35',
                'updated_at' => '2025-01-01 08:31:35',
            ),
            368 => 
            array (
                'id' => 369,
                'name' => 'BK Wi/40',
                'created_at' => '2025-01-01 08:55:38',
                'updated_at' => '2025-01-01 08:55:38',
            ),
            369 => 
            array (
                'id' => 370,
                'name' => 'BK Wi/41',
                'created_at' => '2025-01-01 08:55:38',
                'updated_at' => '2025-01-01 08:55:38',
            ),
            370 => 
            array (
                'id' => 371,
                'name' => 'BK Wi/42',
                'created_at' => '2025-01-01 08:55:38',
                'updated_at' => '2025-01-01 08:55:38',
            ),
            371 => 
            array (
                'id' => 372,
                'name' => 'BK Wi/43',
                'created_at' => '2025-01-01 08:55:38',
                'updated_at' => '2025-01-01 08:55:38',
            ),
            372 => 
            array (
                'id' => 373,
                'name' => 'BK Wi/44',
                'created_at' => '2025-01-01 08:55:38',
                'updated_at' => '2025-01-01 08:55:38',
            ),
            373 => 
            array (
                'id' => 374,
                'name' => 'Wi BL/40',
                'created_at' => '2025-01-01 09:00:39',
                'updated_at' => '2025-01-01 09:00:39',
            ),
            374 => 
            array (
                'id' => 375,
                'name' => 'Wi BL/41',
                'created_at' => '2025-01-01 09:00:39',
                'updated_at' => '2025-01-01 09:00:39',
            ),
            375 => 
            array (
                'id' => 376,
                'name' => 'Wi BL/42',
                'created_at' => '2025-01-01 09:00:39',
                'updated_at' => '2025-01-01 09:00:39',
            ),
            376 => 
            array (
                'id' => 377,
                'name' => 'Wi BL/43',
                'created_at' => '2025-01-01 09:00:39',
                'updated_at' => '2025-01-01 09:00:39',
            ),
            377 => 
            array (
                'id' => 378,
                'name' => 'Wi BL/44',
                'created_at' => '2025-01-01 09:00:39',
                'updated_at' => '2025-01-01 09:00:39',
            ),
            378 => 
            array (
                'id' => 379,
                'name' => 'Wi/27',
                'created_at' => '2025-01-01 09:35:55',
                'updated_at' => '2025-01-01 09:35:55',
            ),
            379 => 
            array (
                'id' => 380,
                'name' => 'Wi/28',
                'created_at' => '2025-01-01 09:35:55',
                'updated_at' => '2025-01-01 09:35:55',
            ),
            380 => 
            array (
                'id' => 381,
                'name' => 'Wi/29',
                'created_at' => '2025-01-01 09:35:55',
                'updated_at' => '2025-01-01 09:35:55',
            ),
            381 => 
            array (
                'id' => 382,
                'name' => 'Wi/30',
                'created_at' => '2025-01-01 09:35:55',
                'updated_at' => '2025-01-01 09:35:55',
            ),
            382 => 
            array (
                'id' => 383,
                'name' => 'Wi/31',
                'created_at' => '2025-01-01 09:40:45',
                'updated_at' => '2025-01-01 09:40:45',
            ),
            383 => 
            array (
                'id' => 384,
                'name' => 'Wi/32',
                'created_at' => '2025-01-01 09:40:45',
                'updated_at' => '2025-01-01 09:40:45',
            ),
            384 => 
            array (
                'id' => 385,
                'name' => 'Wi/33',
                'created_at' => '2025-01-01 09:40:45',
                'updated_at' => '2025-01-01 09:40:45',
            ),
            385 => 
            array (
                'id' => 386,
                'name' => 'Wi/34',
                'created_at' => '2025-01-01 09:40:45',
                'updated_at' => '2025-01-01 09:40:45',
            ),
            386 => 
            array (
                'id' => 387,
                'name' => 'Wi/35',
                'created_at' => '2025-01-01 09:40:45',
                'updated_at' => '2025-01-01 09:40:45',
            ),
            387 => 
            array (
                'id' => 388,
                'name' => 'BK/41',
                'created_at' => '2025-01-02 05:46:13',
                'updated_at' => '2025-01-02 05:46:13',
            ),
            388 => 
            array (
                'id' => 389,
                'name' => 'BK/42',
                'created_at' => '2025-01-02 05:46:13',
                'updated_at' => '2025-01-02 05:46:13',
            ),
            389 => 
            array (
                'id' => 390,
                'name' => 'BK/43',
                'created_at' => '2025-01-02 05:46:13',
                'updated_at' => '2025-01-02 05:46:13',
            ),
            390 => 
            array (
                'id' => 391,
                'name' => 'BK/44',
                'created_at' => '2025-01-02 05:46:13',
                'updated_at' => '2025-01-02 05:46:13',
            ),
            391 => 
            array (
                'id' => 392,
                'name' => 'SL/230',
                'created_at' => '2025-01-02 13:47:23',
                'updated_at' => '2025-01-02 13:47:23',
            ),
            392 => 
            array (
                'id' => 393,
                'name' => 'SL/235',
                'created_at' => '2025-01-02 13:47:23',
                'updated_at' => '2025-01-02 13:47:23',
            ),
            393 => 
            array (
                'id' => 394,
                'name' => 'SL/240',
                'created_at' => '2025-01-02 13:47:23',
                'updated_at' => '2025-01-02 13:47:23',
            ),
            394 => 
            array (
                'id' => 395,
                'name' => 'SL/245',
                'created_at' => '2025-01-02 13:47:23',
                'updated_at' => '2025-01-02 13:47:23',
            ),
            395 => 
            array (
                'id' => 396,
                'name' => 'SL/250',
                'created_at' => '2025-01-02 13:47:23',
                'updated_at' => '2025-01-02 13:47:23',
            ),
            396 => 
            array (
                'id' => 397,
                'name' => 'BK/230',
                'created_at' => '2025-01-02 14:01:10',
                'updated_at' => '2025-01-02 14:01:10',
            ),
            397 => 
            array (
                'id' => 398,
                'name' => 'BK/235',
                'created_at' => '2025-01-02 14:01:10',
                'updated_at' => '2025-01-02 14:01:10',
            ),
            398 => 
            array (
                'id' => 399,
                'name' => 'BK/240',
                'created_at' => '2025-01-02 14:01:10',
                'updated_at' => '2025-01-02 14:01:10',
            ),
            399 => 
            array (
                'id' => 400,
                'name' => 'BK/245',
                'created_at' => '2025-01-02 14:01:10',
                'updated_at' => '2025-01-02 14:01:10',
            ),
            400 => 
            array (
                'id' => 401,
                'name' => 'BK/250',
                'created_at' => '2025-01-02 14:01:10',
                'updated_at' => '2025-01-02 14:01:10',
            ),
            401 => 
            array (
                'id' => 402,
                'name' => 'AS/36',
                'created_at' => '2025-01-02 14:36:34',
                'updated_at' => '2025-01-02 14:36:34',
            ),
            402 => 
            array (
                'id' => 403,
                'name' => 'AS/37',
                'created_at' => '2025-01-02 14:36:34',
                'updated_at' => '2025-01-02 14:36:34',
            ),
            403 => 
            array (
                'id' => 404,
                'name' => 'AS/38',
                'created_at' => '2025-01-02 14:36:34',
                'updated_at' => '2025-01-02 14:36:34',
            ),
            404 => 
            array (
                'id' => 405,
                'name' => 'AS/39',
                'created_at' => '2025-01-02 14:36:34',
                'updated_at' => '2025-01-02 14:36:34',
            ),
            405 => 
            array (
                'id' => 406,
                'name' => 'BL/26',
                'created_at' => '2025-01-02 15:26:52',
                'updated_at' => '2025-01-02 15:26:52',
            ),
            406 => 
            array (
                'id' => 407,
                'name' => 'BL/27',
                'created_at' => '2025-01-02 15:26:52',
                'updated_at' => '2025-01-02 15:26:52',
            ),
            407 => 
            array (
                'id' => 408,
                'name' => 'BL/28',
                'created_at' => '2025-01-02 15:26:52',
                'updated_at' => '2025-01-02 15:26:52',
            ),
            408 => 
            array (
                'id' => 409,
                'name' => 'BL/29',
                'created_at' => '2025-01-02 15:26:52',
                'updated_at' => '2025-01-02 15:26:52',
            ),
            409 => 
            array (
                'id' => 410,
                'name' => 'BR/26',
                'created_at' => '2025-01-02 15:30:37',
                'updated_at' => '2025-01-02 15:30:37',
            ),
            410 => 
            array (
                'id' => 411,
                'name' => 'BR/27',
                'created_at' => '2025-01-02 15:30:37',
                'updated_at' => '2025-01-02 15:30:37',
            ),
            411 => 
            array (
                'id' => 412,
                'name' => 'BR/28',
                'created_at' => '2025-01-02 15:30:37',
                'updated_at' => '2025-01-02 15:30:37',
            ),
            412 => 
            array (
                'id' => 413,
                'name' => 'BR/29',
                'created_at' => '2025-01-02 15:30:37',
                'updated_at' => '2025-01-02 15:30:37',
            ),
            413 => 
            array (
                'id' => 414,
                'name' => 'BR/30',
                'created_at' => '2025-01-02 15:30:37',
                'updated_at' => '2025-01-02 15:30:37',
            ),
            414 => 
            array (
                'id' => 415,
                'name' => 'BR/31',
                'created_at' => '2025-01-02 15:53:12',
                'updated_at' => '2025-01-02 15:53:12',
            ),
            415 => 
            array (
                'id' => 416,
                'name' => 'BL/30',
                'created_at' => '2025-01-02 15:59:20',
                'updated_at' => '2025-01-02 15:59:20',
            ),
            416 => 
            array (
                'id' => 417,
                'name' => 'BR/22',
                'created_at' => '2025-01-02 16:07:31',
                'updated_at' => '2025-01-02 16:07:31',
            ),
            417 => 
            array (
                'id' => 418,
                'name' => 'BR/23',
                'created_at' => '2025-01-02 16:07:31',
                'updated_at' => '2025-01-02 16:07:31',
            ),
            418 => 
            array (
                'id' => 419,
                'name' => 'BR/24',
                'created_at' => '2025-01-02 16:07:31',
                'updated_at' => '2025-01-02 16:07:31',
            ),
            419 => 
            array (
                'id' => 420,
                'name' => 'BR/25',
                'created_at' => '2025-01-02 16:07:31',
                'updated_at' => '2025-01-02 16:07:31',
            ),
            420 => 
            array (
                'id' => 421,
                'name' => 'PNK/22',
                'created_at' => '2025-01-02 16:11:28',
                'updated_at' => '2025-01-02 16:11:28',
            ),
            421 => 
            array (
                'id' => 422,
                'name' => 'PNK/23',
                'created_at' => '2025-01-02 16:11:28',
                'updated_at' => '2025-01-02 16:11:28',
            ),
            422 => 
            array (
                'id' => 423,
                'name' => 'PNK/24',
                'created_at' => '2025-01-02 16:11:28',
                'updated_at' => '2025-01-02 16:11:28',
            ),
            423 => 
            array (
                'id' => 424,
                'name' => 'PNK/25',
                'created_at' => '2025-01-02 16:11:28',
                'updated_at' => '2025-01-02 16:11:28',
            ),
            424 => 
            array (
                'id' => 425,
                'name' => 'PNK/26',
                'created_at' => '2025-01-02 16:11:28',
                'updated_at' => '2025-01-02 16:11:28',
            ),
            425 => 
            array (
                'id' => 426,
                'name' => 'AS/44',
                'created_at' => '2025-01-04 06:27:17',
                'updated_at' => '2025-01-04 06:27:17',
            ),
            426 => 
            array (
                'id' => 427,
                'name' => 'BL/40',
                'created_at' => '2025-01-04 06:32:56',
                'updated_at' => '2025-01-04 06:32:56',
            ),
            427 => 
            array (
                'id' => 428,
                'name' => 'BL/41',
                'created_at' => '2025-01-04 06:32:56',
                'updated_at' => '2025-01-04 06:32:56',
            ),
            428 => 
            array (
                'id' => 429,
                'name' => 'BL/42',
                'created_at' => '2025-01-04 06:32:56',
                'updated_at' => '2025-01-04 06:32:56',
            ),
            429 => 
            array (
                'id' => 430,
                'name' => 'BL/43',
                'created_at' => '2025-01-04 06:32:56',
                'updated_at' => '2025-01-04 06:32:56',
            ),
            430 => 
            array (
                'id' => 431,
                'name' => 'BL/44',
                'created_at' => '2025-01-04 06:32:56',
                'updated_at' => '2025-01-04 06:32:56',
            ),
            431 => 
            array (
                'id' => 432,
                'name' => 'BK-AS/40',
                'created_at' => '2025-01-04 08:36:02',
                'updated_at' => '2025-01-04 08:36:02',
            ),
            432 => 
            array (
                'id' => 433,
                'name' => 'BK-AS/41',
                'created_at' => '2025-01-04 08:36:02',
                'updated_at' => '2025-01-04 08:36:02',
            ),
            433 => 
            array (
                'id' => 434,
                'name' => 'BK-AS/42',
                'created_at' => '2025-01-04 08:36:02',
                'updated_at' => '2025-01-04 08:36:02',
            ),
            434 => 
            array (
                'id' => 435,
                'name' => 'BK-AS/43',
                'created_at' => '2025-01-04 08:36:02',
                'updated_at' => '2025-01-04 08:36:02',
            ),
            435 => 
            array (
                'id' => 436,
                'name' => 'BK-AS/44',
                'created_at' => '2025-01-04 08:36:02',
                'updated_at' => '2025-01-04 08:36:02',
            ),
            436 => 
            array (
                'id' => 437,
                'name' => 'BL-AS/40',
                'created_at' => '2025-01-04 08:36:02',
                'updated_at' => '2025-01-04 08:36:02',
            ),
            437 => 
            array (
                'id' => 438,
                'name' => 'BL-AS/41',
                'created_at' => '2025-01-04 08:36:02',
                'updated_at' => '2025-01-04 08:36:02',
            ),
            438 => 
            array (
                'id' => 439,
                'name' => 'BL-AS/42',
                'created_at' => '2025-01-04 08:36:02',
                'updated_at' => '2025-01-04 08:36:02',
            ),
            439 => 
            array (
                'id' => 440,
                'name' => 'BL-AS/43',
                'created_at' => '2025-01-04 08:36:02',
                'updated_at' => '2025-01-04 08:36:02',
            ),
            440 => 
            array (
                'id' => 441,
                'name' => 'BL-AS/44',
                'created_at' => '2025-01-04 08:36:02',
                'updated_at' => '2025-01-04 08:36:02',
            ),
            441 => 
            array (
                'id' => 442,
                'name' => 'BK-BL/40',
                'created_at' => '2025-01-04 08:48:26',
                'updated_at' => '2025-01-04 08:48:26',
            ),
            442 => 
            array (
                'id' => 443,
                'name' => 'BK-BL/41',
                'created_at' => '2025-01-04 08:48:26',
                'updated_at' => '2025-01-04 08:48:26',
            ),
            443 => 
            array (
                'id' => 444,
                'name' => 'BK-BL/42',
                'created_at' => '2025-01-04 08:48:26',
                'updated_at' => '2025-01-04 08:48:26',
            ),
            444 => 
            array (
                'id' => 445,
                'name' => 'BK-BL/43',
                'created_at' => '2025-01-04 08:48:26',
                'updated_at' => '2025-01-04 08:48:26',
            ),
            445 => 
            array (
                'id' => 446,
                'name' => 'BK-BL/44',
                'created_at' => '2025-01-04 08:48:26',
                'updated_at' => '2025-01-04 08:48:26',
            ),
            446 => 
            array (
                'id' => 447,
                'name' => 'AS-BL/40',
                'created_at' => '2025-01-04 08:59:45',
                'updated_at' => '2025-01-04 08:59:45',
            ),
            447 => 
            array (
                'id' => 448,
                'name' => 'AS-BL/41',
                'created_at' => '2025-01-04 08:59:45',
                'updated_at' => '2025-01-04 08:59:45',
            ),
            448 => 
            array (
                'id' => 449,
                'name' => 'AS-BL/42',
                'created_at' => '2025-01-04 08:59:45',
                'updated_at' => '2025-01-04 08:59:45',
            ),
            449 => 
            array (
                'id' => 450,
                'name' => 'AS-BL/43',
                'created_at' => '2025-01-04 08:59:45',
                'updated_at' => '2025-01-04 08:59:45',
            ),
            450 => 
            array (
                'id' => 451,
                'name' => 'AS-BL/44',
                'created_at' => '2025-01-04 08:59:45',
                'updated_at' => '2025-01-04 08:59:45',
            ),
            451 => 
            array (
                'id' => 452,
                'name' => '/43/BK/40',
                'created_at' => '2025-01-04 10:16:40',
                'updated_at' => '2025-01-04 10:16:40',
            ),
            452 => 
            array (
                'id' => 453,
                'name' => '/43/BK/41',
                'created_at' => '2025-01-04 10:16:40',
                'updated_at' => '2025-01-04 10:16:40',
            ),
            453 => 
            array (
                'id' => 454,
                'name' => '/43/BK/42',
                'created_at' => '2025-01-04 10:16:40',
                'updated_at' => '2025-01-04 10:16:40',
            ),
            454 => 
            array (
                'id' => 455,
                'name' => '/43/BK/43',
                'created_at' => '2025-01-04 10:16:40',
                'updated_at' => '2025-01-04 10:16:40',
            ),
            455 => 
            array (
                'id' => 456,
                'name' => '/43/CH/40',
                'created_at' => '2025-01-04 10:16:40',
                'updated_at' => '2025-01-04 10:16:40',
            ),
            456 => 
            array (
                'id' => 457,
                'name' => '/43/CH/41',
                'created_at' => '2025-01-04 10:16:40',
                'updated_at' => '2025-01-04 10:16:40',
            ),
            457 => 
            array (
                'id' => 458,
                'name' => '/43/CH/42',
                'created_at' => '2025-01-04 10:16:40',
                'updated_at' => '2025-01-04 10:16:40',
            ),
            458 => 
            array (
                'id' => 459,
                'name' => '/43/CH/43',
                'created_at' => '2025-01-04 10:16:40',
                'updated_at' => '2025-01-04 10:16:40',
            ),
            459 => 
            array (
                'id' => 460,
                'name' => 'BK/40//',
                'created_at' => '2025-01-04 10:18:44',
                'updated_at' => '2025-01-04 10:18:44',
            ),
            460 => 
            array (
                'id' => 461,
                'name' => 'BK/41//',
                'created_at' => '2025-01-04 10:18:44',
                'updated_at' => '2025-01-04 10:18:44',
            ),
            461 => 
            array (
                'id' => 462,
                'name' => 'BK/42//',
                'created_at' => '2025-01-04 10:18:44',
                'updated_at' => '2025-01-04 10:18:44',
            ),
            462 => 
            array (
                'id' => 463,
                'name' => 'BK/43//',
                'created_at' => '2025-01-04 10:18:44',
                'updated_at' => '2025-01-04 10:18:44',
            ),
            463 => 
            array (
                'id' => 464,
                'name' => 'CH/40//',
                'created_at' => '2025-01-04 10:18:44',
                'updated_at' => '2025-01-04 10:18:44',
            ),
            464 => 
            array (
                'id' => 465,
                'name' => 'CH/41//',
                'created_at' => '2025-01-04 10:18:44',
                'updated_at' => '2025-01-04 10:18:44',
            ),
            465 => 
            array (
                'id' => 466,
                'name' => 'CH/42//',
                'created_at' => '2025-01-04 10:18:44',
                'updated_at' => '2025-01-04 10:18:44',
            ),
            466 => 
            array (
                'id' => 467,
                'name' => 'CH/43//',
                'created_at' => '2025-01-04 10:18:44',
                'updated_at' => '2025-01-04 10:18:44',
            ),
            467 => 
            array (
                'id' => 468,
                'name' => 'AS/40/MR/40',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            468 => 
            array (
                'id' => 469,
                'name' => 'AS/40/MR/41',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            469 => 
            array (
                'id' => 470,
                'name' => 'AS/40/MR/42',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            470 => 
            array (
                'id' => 471,
                'name' => 'AS/40/MR/43',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            471 => 
            array (
                'id' => 472,
                'name' => 'AS/41/MR/40',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            472 => 
            array (
                'id' => 473,
                'name' => 'AS/41/MR/41',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            473 => 
            array (
                'id' => 474,
                'name' => 'AS/41/MR/42',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            474 => 
            array (
                'id' => 475,
                'name' => 'AS/41/MR/43',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            475 => 
            array (
                'id' => 476,
                'name' => 'AS/42/MR/40',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            476 => 
            array (
                'id' => 477,
                'name' => 'AS/42/MR/41',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            477 => 
            array (
                'id' => 478,
                'name' => 'AS/42/MR/42',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            478 => 
            array (
                'id' => 479,
                'name' => 'AS/42/MR/43',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            479 => 
            array (
                'id' => 480,
                'name' => 'AS/43/MR/40',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            480 => 
            array (
                'id' => 481,
                'name' => 'AS/43/MR/41',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            481 => 
            array (
                'id' => 482,
                'name' => 'AS/43/MR/42',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            482 => 
            array (
                'id' => 483,
                'name' => 'AS/43/MR/43',
                'created_at' => '2025-01-04 11:47:56',
                'updated_at' => '2025-01-04 11:47:56',
            ),
            483 => 
            array (
                'id' => 484,
                'name' => 'AS-BK/40',
                'created_at' => '2025-01-04 12:36:02',
                'updated_at' => '2025-01-04 12:36:02',
            ),
            484 => 
            array (
                'id' => 485,
                'name' => 'AS-BK/41',
                'created_at' => '2025-01-04 12:36:02',
                'updated_at' => '2025-01-04 12:36:02',
            ),
            485 => 
            array (
                'id' => 486,
                'name' => 'AS-BK/42',
                'created_at' => '2025-01-04 12:36:02',
                'updated_at' => '2025-01-04 12:36:02',
            ),
            486 => 
            array (
                'id' => 487,
                'name' => 'AS-BK/43',
                'created_at' => '2025-01-04 12:36:02',
                'updated_at' => '2025-01-04 12:36:02',
            ),
            487 => 
            array (
                'id' => 488,
                'name' => 'BK-AS/40/AS-BK/41',
                'created_at' => '2025-01-04 12:39:19',
                'updated_at' => '2025-01-04 12:39:19',
            ),
            488 => 
            array (
                'id' => 489,
                'name' => 'BK-AS/40/AS-BK/42',
                'created_at' => '2025-01-04 12:39:19',
                'updated_at' => '2025-01-04 12:39:19',
            ),
            489 => 
            array (
                'id' => 490,
                'name' => 'BK-AS/40/AS-BK/43',
                'created_at' => '2025-01-04 12:39:19',
                'updated_at' => '2025-01-04 12:39:19',
            ),
            490 => 
            array (
                'id' => 491,
                'name' => 'BK-AS/41/AS-BK/41',
                'created_at' => '2025-01-04 12:39:19',
                'updated_at' => '2025-01-04 12:39:19',
            ),
            491 => 
            array (
                'id' => 492,
                'name' => 'BK-AS/41/AS-BK/42',
                'created_at' => '2025-01-04 12:39:19',
                'updated_at' => '2025-01-04 12:39:19',
            ),
            492 => 
            array (
                'id' => 493,
                'name' => 'BK-AS/41/AS-BK/43',
                'created_at' => '2025-01-04 12:39:19',
                'updated_at' => '2025-01-04 12:39:19',
            ),
            493 => 
            array (
                'id' => 494,
                'name' => 'BK-AS/42/AS-BK/41',
                'created_at' => '2025-01-04 12:39:19',
                'updated_at' => '2025-01-04 12:39:19',
            ),
            494 => 
            array (
                'id' => 495,
                'name' => 'BK-AS/42/AS-BK/42',
                'created_at' => '2025-01-04 12:39:19',
                'updated_at' => '2025-01-04 12:39:19',
            ),
            495 => 
            array (
                'id' => 496,
                'name' => 'BK-AS/42/AS-BK/43',
                'created_at' => '2025-01-04 12:39:19',
                'updated_at' => '2025-01-04 12:39:19',
            ),
            496 => 
            array (
                'id' => 497,
                'name' => 'BK-AS/43/AS-BK/41',
                'created_at' => '2025-01-04 12:39:19',
                'updated_at' => '2025-01-04 12:39:19',
            ),
            497 => 
            array (
                'id' => 498,
                'name' => 'BK-AS/43/AS-BK/42',
                'created_at' => '2025-01-04 12:39:19',
                'updated_at' => '2025-01-04 12:39:19',
            ),
            498 => 
            array (
                'id' => 499,
                'name' => 'BK-AS/43/AS-BK/43',
                'created_at' => '2025-01-04 12:39:19',
                'updated_at' => '2025-01-04 12:39:19',
            ),
            499 => 
            array (
                'id' => 500,
                'name' => 'BK/1',
                'created_at' => '2025-01-04 14:14:22',
                'updated_at' => '2025-01-06 11:30:29',
            ),
        ));
        \DB::table('variants')->insert(array (
            0 => 
            array (
                'id' => 501,
                'name' => 'BK/2',
                'created_at' => '2025-01-04 14:14:22',
                'updated_at' => '2025-01-06 11:30:29',
            ),
            1 => 
            array (
                'id' => 502,
                'name' => 'BK/3',
                'created_at' => '2025-01-04 14:14:22',
                'updated_at' => '2025-01-06 11:30:29',
            ),
            2 => 
            array (
                'id' => 503,
                'name' => 'BK/4',
                'created_at' => '2025-01-04 14:14:22',
                'updated_at' => '2025-01-06 11:30:29',
            ),
            3 => 
            array (
                'id' => 504,
                'name' => 'CH/1',
                'created_at' => '2025-01-04 14:14:22',
                'updated_at' => '2025-01-04 14:14:22',
            ),
            4 => 
            array (
                'id' => 505,
                'name' => 'CH/2',
                'created_at' => '2025-01-04 14:14:22',
                'updated_at' => '2025-01-04 14:14:22',
            ),
            5 => 
            array (
                'id' => 506,
                'name' => 'CH/3',
                'created_at' => '2025-01-04 14:14:22',
                'updated_at' => '2025-01-04 14:14:22',
            ),
            6 => 
            array (
                'id' => 507,
                'name' => 'CH/4',
                'created_at' => '2025-01-04 14:14:22',
                'updated_at' => '2025-01-04 14:14:22',
            ),
            7 => 
            array (
                'id' => 508,
                'name' => 'Red/10',
                'created_at' => '2025-01-04 18:54:17',
                'updated_at' => '2025-01-19 17:57:08',
            ),
            8 => 
            array (
                'id' => 509,
                'name' => 'Red/12',
                'created_at' => '2025-01-04 18:54:17',
                'updated_at' => '2025-01-19 17:57:08',
            ),
            9 => 
            array (
                'id' => 510,
                'name' => 'Green/10',
                'created_at' => '2025-01-04 18:54:17',
                'updated_at' => '2025-01-19 18:00:31',
            ),
            10 => 
            array (
                'id' => 511,
                'name' => 'Green/12',
                'created_at' => '2025-01-04 18:54:17',
                'updated_at' => '2025-01-19 18:00:31',
            ),
            11 => 
            array (
                'id' => 512,
                'name' => 'Green/13',
                'created_at' => '2025-01-04 18:54:17',
                'updated_at' => '2025-01-19 18:00:31',
            ),
            12 => 
            array (
                'id' => 513,
                'name' => 're/12',
                'created_at' => '2025-01-06 18:38:58',
                'updated_at' => '2025-01-06 18:38:58',
            ),
            13 => 
            array (
                'id' => 514,
                'name' => 're/14',
                'created_at' => '2025-01-06 18:38:59',
                'updated_at' => '2025-01-06 18:38:59',
            ),
            14 => 
            array (
                'id' => 515,
                'name' => 're/13',
                'created_at' => '2025-01-06 18:38:59',
                'updated_at' => '2025-01-06 18:38:59',
            ),
            15 => 
            array (
                'id' => 516,
                'name' => 'MR/1',
                'created_at' => '2025-01-08 05:42:05',
                'updated_at' => '2025-01-08 05:42:05',
            ),
            16 => 
            array (
                'id' => 517,
                'name' => 'MR/2',
                'created_at' => '2025-01-08 05:46:01',
                'updated_at' => '2025-01-08 05:46:01',
            ),
            17 => 
            array (
                'id' => 518,
                'name' => 'BK/5',
                'created_at' => '2025-01-08 10:40:11',
                'updated_at' => '2025-01-08 10:40:11',
            ),
            18 => 
            array (
                'id' => 519,
                'name' => 'BK/6',
                'created_at' => '2025-01-08 10:40:11',
                'updated_at' => '2025-01-08 10:40:11',
            ),
            19 => 
            array (
                'id' => 520,
                'name' => 'BK/7',
                'created_at' => '2025-01-08 10:40:11',
                'updated_at' => '2025-01-08 10:40:11',
            ),
            20 => 
            array (
                'id' => 521,
                'name' => 'BK/8',
                'created_at' => '2025-01-08 10:40:11',
                'updated_at' => '2025-01-08 10:40:11',
            ),
            21 => 
            array (
                'id' => 522,
                'name' => 'SY/1',
                'created_at' => '2025-01-08 10:40:11',
                'updated_at' => '2025-01-08 10:40:11',
            ),
            22 => 
            array (
                'id' => 523,
                'name' => 'SY/2',
                'created_at' => '2025-01-08 10:40:11',
                'updated_at' => '2025-01-08 10:40:11',
            ),
            23 => 
            array (
                'id' => 524,
                'name' => 'AS/1',
                'created_at' => '2025-01-08 10:40:11',
                'updated_at' => '2025-01-08 10:40:11',
            ),
            24 => 
            array (
                'id' => 525,
                'name' => 'AS/2',
                'created_at' => '2025-01-08 10:40:11',
                'updated_at' => '2025-01-08 10:40:11',
            ),
            25 => 
            array (
                'id' => 526,
                'name' => 'BR/1',
                'created_at' => '2025-01-08 10:55:25',
                'updated_at' => '2025-01-08 10:55:25',
            ),
            26 => 
            array (
                'id' => 527,
                'name' => 'BR/2',
                'created_at' => '2025-01-08 10:55:25',
                'updated_at' => '2025-01-08 10:55:25',
            ),
            27 => 
            array (
                'id' => 528,
                'name' => 'BR/3',
                'created_at' => '2025-01-08 10:55:25',
                'updated_at' => '2025-01-08 10:55:25',
            ),
            28 => 
            array (
                'id' => 529,
                'name' => 'BR/4',
                'created_at' => '2025-01-08 10:55:25',
                'updated_at' => '2025-01-08 10:55:25',
            ),
            29 => 
            array (
                'id' => 530,
                'name' => 'BR/5',
                'created_at' => '2025-01-08 10:55:25',
                'updated_at' => '2025-01-08 10:55:25',
            ),
            30 => 
            array (
                'id' => 531,
                'name' => 'BR/6',
                'created_at' => '2025-01-08 10:55:25',
                'updated_at' => '2025-01-08 10:55:25',
            ),
            31 => 
            array (
                'id' => 532,
                'name' => 'BL/1',
                'created_at' => '2025-01-08 10:59:20',
                'updated_at' => '2025-01-08 10:59:20',
            ),
            32 => 
            array (
                'id' => 533,
                'name' => 'BL/2',
                'created_at' => '2025-01-08 10:59:20',
                'updated_at' => '2025-01-08 10:59:20',
            ),
            33 => 
            array (
                'id' => 534,
                'name' => 'BL/3',
                'created_at' => '2025-01-08 10:59:20',
                'updated_at' => '2025-01-08 10:59:20',
            ),
            34 => 
            array (
                'id' => 535,
                'name' => 'AS/3',
                'created_at' => '2025-01-08 10:59:20',
                'updated_at' => '2025-01-08 10:59:20',
            ),
            35 => 
            array (
                'id' => 536,
                'name' => 'BLK/1',
                'created_at' => '2025-01-08 11:06:47',
                'updated_at' => '2025-01-08 11:06:47',
            ),
            36 => 
            array (
                'id' => 537,
                'name' => 'BLK/2',
                'created_at' => '2025-01-08 11:06:47',
                'updated_at' => '2025-01-08 11:06:47',
            ),
            37 => 
            array (
                'id' => 538,
                'name' => 'BLK/3',
                'created_at' => '2025-01-08 11:06:47',
                'updated_at' => '2025-01-08 11:06:47',
            ),
            38 => 
            array (
                'id' => 539,
                'name' => 'BLK/4',
                'created_at' => '2025-01-08 11:06:47',
                'updated_at' => '2025-01-08 11:06:47',
            ),
            39 => 
            array (
                'id' => 540,
                'name' => 'BLK/5',
                'created_at' => '2025-01-08 11:06:47',
                'updated_at' => '2025-01-08 11:06:47',
            ),
            40 => 
            array (
                'id' => 541,
                'name' => 'BLK/6',
                'created_at' => '2025-01-08 11:06:47',
                'updated_at' => '2025-01-08 11:06:47',
            ),
            41 => 
            array (
                'id' => 542,
                'name' => 'SN/1',
                'created_at' => '2025-01-08 11:06:47',
                'updated_at' => '2025-01-08 11:06:47',
            ),
            42 => 
            array (
                'id' => 543,
                'name' => 'SN/2',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            43 => 
            array (
                'id' => 544,
                'name' => 'SN/3',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            44 => 
            array (
                'id' => 545,
                'name' => 'SN/4',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            45 => 
            array (
                'id' => 546,
                'name' => 'SN/5',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            46 => 
            array (
                'id' => 547,
                'name' => 'SN/6',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            47 => 
            array (
                'id' => 548,
                'name' => 'SK/1',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            48 => 
            array (
                'id' => 549,
                'name' => 'SK/2',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            49 => 
            array (
                'id' => 550,
                'name' => 'SK/3',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            50 => 
            array (
                'id' => 551,
                'name' => 'SK/4',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            51 => 
            array (
                'id' => 552,
                'name' => 'SK/5',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            52 => 
            array (
                'id' => 553,
                'name' => 'SK/6',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            53 => 
            array (
                'id' => 554,
                'name' => 'SKN/1',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            54 => 
            array (
                'id' => 555,
                'name' => 'SKN/2',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            55 => 
            array (
                'id' => 556,
                'name' => 'SKN/3',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            56 => 
            array (
                'id' => 557,
                'name' => 'SKN/4',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            57 => 
            array (
                'id' => 558,
                'name' => 'SKN/5',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            58 => 
            array (
                'id' => 559,
                'name' => 'SKN/6',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            59 => 
            array (
                'id' => 560,
                'name' => 'SKIN/1',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            60 => 
            array (
                'id' => 561,
                'name' => 'SKIN/2',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            61 => 
            array (
                'id' => 562,
                'name' => 'SKIN/3',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            62 => 
            array (
                'id' => 563,
                'name' => 'SKIN/4',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            63 => 
            array (
                'id' => 564,
                'name' => 'SKIN/5',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            64 => 
            array (
                'id' => 565,
                'name' => 'SKIN/6',
                'created_at' => '2025-01-08 11:06:48',
                'updated_at' => '2025-01-08 11:06:48',
            ),
            65 => 
            array (
                'id' => 566,
                'name' => 'Wi-L/1',
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            66 => 
            array (
                'id' => 567,
                'name' => 'Wi-L/2',
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            67 => 
            array (
                'id' => 568,
                'name' => 'Wi-L/3',
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            68 => 
            array (
                'id' => 569,
                'name' => 'Wi-L/4',
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            69 => 
            array (
                'id' => 570,
                'name' => 'Wi-L/5',
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            70 => 
            array (
                'id' => 571,
                'name' => 'Wi-L/6',
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            71 => 
            array (
                'id' => 572,
                'name' => 'Wi-S/1',
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            72 => 
            array (
                'id' => 573,
                'name' => 'Wi-S/2',
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            73 => 
            array (
                'id' => 574,
                'name' => 'Wi-S/3',
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            74 => 
            array (
                'id' => 575,
                'name' => 'Wi-S/4',
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            75 => 
            array (
                'id' => 576,
                'name' => 'Wi-S/5',
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            76 => 
            array (
                'id' => 577,
                'name' => 'Wi-S/6',
                'created_at' => '2025-01-08 12:35:13',
                'updated_at' => '2025-01-08 12:35:13',
            ),
            77 => 
            array (
                'id' => 578,
                'name' => 'Pink/27',
                'created_at' => '2025-01-12 11:36:18',
                'updated_at' => '2025-01-12 11:36:18',
            ),
            78 => 
            array (
                'id' => 579,
                'name' => 'Pink/28',
                'created_at' => '2025-01-12 11:36:18',
                'updated_at' => '2025-01-12 11:36:18',
            ),
            79 => 
            array (
                'id' => 580,
                'name' => 'Pink/29',
                'created_at' => '2025-01-12 11:36:18',
                'updated_at' => '2025-01-12 11:36:18',
            ),
            80 => 
            array (
                'id' => 581,
                'name' => 'Cream/35',
                'created_at' => '2025-01-22 06:54:39',
                'updated_at' => '2025-01-22 06:54:39',
            ),
            81 => 
            array (
                'id' => 582,
                'name' => 'Golden/35',
                'created_at' => '2025-01-22 08:04:08',
                'updated_at' => '2025-01-22 08:04:08',
            ),
            82 => 
            array (
                'id' => 583,
                'name' => 'BK/35',
                'created_at' => '2025-01-22 08:10:29',
                'updated_at' => '2025-01-22 08:10:29',
            ),
            83 => 
            array (
                'id' => 584,
                'name' => 'Golden/11',
                'created_at' => '2025-01-22 09:27:25',
                'updated_at' => '2025-01-22 09:27:25',
            ),
            84 => 
            array (
                'id' => 585,
                'name' => 'BK/9',
                'created_at' => '2025-01-22 09:30:54',
                'updated_at' => '2025-01-22 09:30:54',
            ),
            85 => 
            array (
                'id' => 586,
                'name' => 'BK/10',
                'created_at' => '2025-01-22 09:30:54',
                'updated_at' => '2025-01-22 09:30:54',
            ),
            86 => 
            array (
                'id' => 587,
                'name' => 'BK/11',
                'created_at' => '2025-01-22 09:30:54',
                'updated_at' => '2025-01-22 09:30:54',
            ),
            87 => 
            array (
                'id' => 588,
                'name' => 'Cyan/36',
                'created_at' => '2025-01-22 10:00:50',
                'updated_at' => '2025-01-22 10:00:50',
            ),
            88 => 
            array (
                'id' => 589,
                'name' => 'Cyan/37',
                'created_at' => '2025-01-22 10:00:50',
                'updated_at' => '2025-01-22 10:00:50',
            ),
            89 => 
            array (
                'id' => 590,
                'name' => 'Cyan/38',
                'created_at' => '2025-01-22 10:00:50',
                'updated_at' => '2025-01-22 10:00:50',
            ),
            90 => 
            array (
                'id' => 591,
                'name' => 'Cyan/39',
                'created_at' => '2025-01-22 10:00:50',
                'updated_at' => '2025-01-22 10:00:50',
            ),
            91 => 
            array (
                'id' => 592,
                'name' => 'Cyan/40',
                'created_at' => '2025-01-22 10:00:50',
                'updated_at' => '2025-01-22 10:00:50',
            ),
            92 => 
            array (
                'id' => 593,
                'name' => 'Cyan/41',
                'created_at' => '2025-01-22 10:00:50',
                'updated_at' => '2025-01-22 10:00:50',
            ),
            93 => 
            array (
                'id' => 594,
                'name' => 'Cream/30',
                'created_at' => '2025-01-22 10:09:30',
                'updated_at' => '2025-01-22 10:09:30',
            ),
            94 => 
            array (
                'id' => 595,
                'name' => 'Cream/31',
                'created_at' => '2025-01-22 10:09:30',
                'updated_at' => '2025-01-22 10:09:30',
            ),
            95 => 
            array (
                'id' => 596,
                'name' => 'Cream/32',
                'created_at' => '2025-01-22 10:09:30',
                'updated_at' => '2025-01-22 10:09:30',
            ),
            96 => 
            array (
                'id' => 597,
                'name' => 'Cream/33',
                'created_at' => '2025-01-22 10:09:30',
                'updated_at' => '2025-01-22 10:09:30',
            ),
            97 => 
            array (
                'id' => 598,
                'name' => 'Cream/34',
                'created_at' => '2025-01-22 10:09:30',
                'updated_at' => '2025-01-22 10:09:30',
            ),
            98 => 
            array (
                'id' => 599,
                'name' => 'BK/30',
                'created_at' => '2025-01-22 10:11:34',
                'updated_at' => '2025-01-22 10:11:34',
            ),
            99 => 
            array (
                'id' => 600,
                'name' => 'BK/31',
                'created_at' => '2025-01-22 10:11:34',
                'updated_at' => '2025-01-22 10:11:34',
            ),
            100 => 
            array (
                'id' => 601,
                'name' => 'BK/32',
                'created_at' => '2025-01-22 10:11:34',
                'updated_at' => '2025-01-22 10:11:34',
            ),
            101 => 
            array (
                'id' => 602,
                'name' => 'BK/33',
                'created_at' => '2025-01-22 10:11:34',
                'updated_at' => '2025-01-22 10:11:34',
            ),
            102 => 
            array (
                'id' => 603,
                'name' => 'BK/34',
                'created_at' => '2025-01-22 10:11:34',
                'updated_at' => '2025-01-22 10:11:34',
            ),
            103 => 
            array (
                'id' => 604,
                'name' => 'Maroon/6',
                'created_at' => '2025-01-22 10:20:40',
                'updated_at' => '2025-01-22 10:20:40',
            ),
            104 => 
            array (
                'id' => 605,
                'name' => 'Maroon/7',
                'created_at' => '2025-01-22 10:20:40',
                'updated_at' => '2025-01-22 10:20:40',
            ),
            105 => 
            array (
                'id' => 606,
                'name' => 'Maroon/8',
                'created_at' => '2025-01-22 10:20:40',
                'updated_at' => '2025-01-22 10:20:40',
            ),
            106 => 
            array (
                'id' => 607,
                'name' => 'Maroon/9',
                'created_at' => '2025-01-22 10:20:40',
                'updated_at' => '2025-01-22 10:20:40',
            ),
            107 => 
            array (
                'id' => 608,
                'name' => 'Maroon/10',
                'created_at' => '2025-01-22 10:20:40',
                'updated_at' => '2025-01-22 10:20:40',
            ),
            108 => 
            array (
                'id' => 609,
                'name' => 'Maroon/11',
                'created_at' => '2025-01-22 10:20:40',
                'updated_at' => '2025-01-22 10:20:40',
            ),
            109 => 
            array (
                'id' => 610,
                'name' => 'Master/11',
                'created_at' => '2025-01-22 10:24:15',
                'updated_at' => '2025-01-22 10:24:15',
            ),
            110 => 
            array (
                'id' => 611,
                'name' => 'Coffee/5',
                'created_at' => '2025-01-22 10:55:46',
                'updated_at' => '2025-01-22 10:55:46',
            ),
            111 => 
            array (
                'id' => 612,
                'name' => 'Maroon/5',
                'created_at' => '2025-01-22 10:56:36',
                'updated_at' => '2025-01-22 10:56:36',
            ),
            112 => 
            array (
                'id' => 613,
                'name' => 'Coffee/12',
                'created_at' => '2025-01-22 11:48:30',
                'updated_at' => '2025-01-22 11:48:30',
            ),
            113 => 
            array (
                'id' => 614,
                'name' => 'Coffee/13',
                'created_at' => '2025-01-22 11:48:30',
                'updated_at' => '2025-01-22 11:48:30',
            ),
            114 => 
            array (
                'id' => 615,
                'name' => 'Coffee/14',
                'created_at' => '2025-01-22 11:48:30',
                'updated_at' => '2025-01-22 11:48:30',
            ),
            115 => 
            array (
                'id' => 616,
                'name' => 'BK/12',
                'created_at' => '2025-01-22 12:34:35',
                'updated_at' => '2025-01-22 12:34:35',
            ),
            116 => 
            array (
                'id' => 617,
                'name' => 'BK/13',
                'created_at' => '2025-01-22 12:34:35',
                'updated_at' => '2025-01-22 12:34:35',
            ),
            117 => 
            array (
                'id' => 618,
                'name' => 'BK/14',
                'created_at' => '2025-01-22 12:34:35',
                'updated_at' => '2025-01-22 12:34:35',
            ),
            118 => 
            array (
                'id' => 619,
                'name' => 'Gray/6',
                'created_at' => '2025-01-22 12:59:44',
                'updated_at' => '2025-01-22 12:59:44',
            ),
            119 => 
            array (
                'id' => 620,
                'name' => 'Gray/7',
                'created_at' => '2025-01-22 12:59:44',
                'updated_at' => '2025-01-22 12:59:44',
            ),
            120 => 
            array (
                'id' => 621,
                'name' => 'Gray/8',
                'created_at' => '2025-01-22 12:59:44',
                'updated_at' => '2025-01-22 12:59:44',
            ),
            121 => 
            array (
                'id' => 622,
                'name' => 'Gray/9',
                'created_at' => '2025-01-22 12:59:44',
                'updated_at' => '2025-01-22 12:59:44',
            ),
            122 => 
            array (
                'id' => 623,
                'name' => 'Gray/10',
                'created_at' => '2025-01-22 12:59:44',
                'updated_at' => '2025-01-22 12:59:44',
            ),
            123 => 
            array (
                'id' => 624,
                'name' => 'Gray/11',
                'created_at' => '2025-01-22 12:59:44',
                'updated_at' => '2025-01-22 12:59:44',
            ),
            124 => 
            array (
                'id' => 625,
                'name' => 'Olive/44',
                'created_at' => '2025-01-23 06:20:48',
                'updated_at' => '2025-01-23 06:20:48',
            ),
            125 => 
            array (
                'id' => 626,
                'name' => 'Coffee/42',
                'created_at' => '2025-01-23 06:41:18',
                'updated_at' => '2025-01-23 06:41:18',
            ),
            126 => 
            array (
                'id' => 627,
                'name' => 'Coffee/43',
                'created_at' => '2025-01-23 06:41:18',
                'updated_at' => '2025-01-23 06:41:18',
            ),
            127 => 
            array (
                'id' => 628,
                'name' => 'Coffee/44',
                'created_at' => '2025-01-23 06:41:18',
                'updated_at' => '2025-01-23 06:41:18',
            ),
            128 => 
            array (
                'id' => 629,
                'name' => 'Cream/42',
                'created_at' => '2025-01-23 07:09:59',
                'updated_at' => '2025-01-23 07:09:59',
            ),
            129 => 
            array (
                'id' => 630,
                'name' => 'Cream/43',
                'created_at' => '2025-01-23 07:09:59',
                'updated_at' => '2025-01-23 07:09:59',
            ),
            130 => 
            array (
                'id' => 631,
                'name' => 'Cream/44',
                'created_at' => '2025-01-23 07:10:00',
                'updated_at' => '2025-01-23 07:10:00',
            ),
            131 => 
            array (
                'id' => 632,
                'name' => 'Chocolate/1',
                'created_at' => '2025-01-23 13:12:48',
                'updated_at' => '2025-01-23 13:12:48',
            ),
            132 => 
            array (
                'id' => 633,
                'name' => 'Chocolate/2',
                'created_at' => '2025-01-23 13:12:48',
                'updated_at' => '2025-01-23 13:12:48',
            ),
            133 => 
            array (
                'id' => 634,
                'name' => 'Chocolate/3',
                'created_at' => '2025-01-23 13:12:48',
                'updated_at' => '2025-01-23 13:12:48',
            ),
            134 => 
            array (
                'id' => 635,
                'name' => 'Chocolate/4',
                'created_at' => '2025-01-23 13:12:48',
                'updated_at' => '2025-01-23 13:12:48',
            ),
            135 => 
            array (
                'id' => 636,
                'name' => 'Master/1',
                'created_at' => '2025-01-23 13:54:00',
                'updated_at' => '2025-01-23 13:54:00',
            ),
            136 => 
            array (
                'id' => 637,
                'name' => 'Master/2',
                'created_at' => '2025-01-23 13:54:00',
                'updated_at' => '2025-01-23 13:54:00',
            ),
            137 => 
            array (
                'id' => 638,
                'name' => 'Master/3',
                'created_at' => '2025-01-23 13:54:00',
                'updated_at' => '2025-01-23 13:54:00',
            ),
            138 => 
            array (
                'id' => 639,
                'name' => 'Master/4',
                'created_at' => '2025-01-23 13:54:00',
                'updated_at' => '2025-01-23 13:54:00',
            ),
            139 => 
            array (
                'id' => 640,
                'name' => 'Coffe/35',
                'created_at' => '2025-01-23 14:09:36',
                'updated_at' => '2025-01-23 14:09:36',
            ),
            140 => 
            array (
                'id' => 641,
                'name' => 'Golden/30',
                'created_at' => '2025-01-23 15:02:22',
                'updated_at' => '2025-01-23 15:02:22',
            ),
            141 => 
            array (
                'id' => 642,
                'name' => 'Golden/31',
                'created_at' => '2025-01-23 15:02:22',
                'updated_at' => '2025-01-23 15:02:22',
            ),
            142 => 
            array (
                'id' => 643,
                'name' => 'Golden/32',
                'created_at' => '2025-01-23 15:02:22',
                'updated_at' => '2025-01-23 15:02:22',
            ),
            143 => 
            array (
                'id' => 644,
                'name' => 'Golden/33',
                'created_at' => '2025-01-23 15:02:22',
                'updated_at' => '2025-01-23 15:02:22',
            ),
            144 => 
            array (
                'id' => 645,
                'name' => 'Golden/34',
                'created_at' => '2025-01-23 15:02:22',
                'updated_at' => '2025-01-23 15:02:22',
            ),
            145 => 
            array (
                'id' => 646,
                'name' => 'White/1',
                'created_at' => '2025-01-23 15:04:05',
                'updated_at' => '2025-01-23 15:04:05',
            ),
            146 => 
            array (
                'id' => 647,
                'name' => 'White/2',
                'created_at' => '2025-01-23 15:04:05',
                'updated_at' => '2025-01-23 15:04:05',
            ),
            147 => 
            array (
                'id' => 648,
                'name' => 'White/3',
                'created_at' => '2025-01-23 15:04:05',
                'updated_at' => '2025-01-23 15:04:05',
            ),
            148 => 
            array (
                'id' => 649,
                'name' => 'White/4',
                'created_at' => '2025-01-23 15:04:05',
                'updated_at' => '2025-01-23 15:04:05',
            ),
            149 => 
            array (
                'id' => 650,
                'name' => 'White/12',
                'created_at' => '2025-01-23 15:04:05',
                'updated_at' => '2025-01-23 15:04:05',
            ),
            150 => 
            array (
                'id' => 651,
                'name' => 'White/13',
                'created_at' => '2025-01-23 15:04:05',
                'updated_at' => '2025-01-23 15:04:05',
            ),
            151 => 
            array (
                'id' => 652,
                'name' => 'Grey/36',
                'created_at' => '2025-01-23 15:10:00',
                'updated_at' => '2025-01-23 15:10:00',
            ),
            152 => 
            array (
                'id' => 653,
                'name' => 'Grey/37',
                'created_at' => '2025-01-23 15:10:00',
                'updated_at' => '2025-01-23 15:10:00',
            ),
            153 => 
            array (
                'id' => 654,
                'name' => 'Grey/38',
                'created_at' => '2025-01-23 15:10:00',
                'updated_at' => '2025-01-23 15:10:00',
            ),
            154 => 
            array (
                'id' => 655,
                'name' => 'Grey/39',
                'created_at' => '2025-01-23 15:10:00',
                'updated_at' => '2025-01-23 15:10:00',
            ),
            155 => 
            array (
                'id' => 656,
                'name' => 'Cream/1',
                'created_at' => '2025-01-23 15:23:01',
                'updated_at' => '2025-01-23 15:23:01',
            ),
            156 => 
            array (
                'id' => 657,
                'name' => 'Cream/2',
                'created_at' => '2025-01-23 15:23:01',
                'updated_at' => '2025-01-23 15:23:01',
            ),
            157 => 
            array (
                'id' => 658,
                'name' => 'Cream/3',
                'created_at' => '2025-01-23 15:23:01',
                'updated_at' => '2025-01-23 15:23:01',
            ),
            158 => 
            array (
                'id' => 659,
                'name' => 'Cream/4',
                'created_at' => '2025-01-23 15:23:01',
                'updated_at' => '2025-01-23 15:23:01',
            ),
            159 => 
            array (
                'id' => 660,
                'name' => 'Cream/12',
                'created_at' => '2025-01-23 15:23:01',
                'updated_at' => '2025-01-23 15:23:01',
            ),
            160 => 
            array (
                'id' => 661,
                'name' => 'Cream/13',
                'created_at' => '2025-01-23 15:23:01',
                'updated_at' => '2025-01-23 15:23:01',
            ),
            161 => 
            array (
                'id' => 662,
                'name' => 'Grey/35',
                'created_at' => '2025-01-23 16:01:50',
                'updated_at' => '2025-01-23 16:01:50',
            ),
            162 => 
            array (
                'id' => 663,
                'name' => 'Golden/1',
                'created_at' => '2025-01-23 16:16:32',
                'updated_at' => '2025-01-23 16:16:32',
            ),
            163 => 
            array (
                'id' => 664,
                'name' => 'Golden/2',
                'created_at' => '2025-01-23 16:16:32',
                'updated_at' => '2025-01-23 16:16:32',
            ),
            164 => 
            array (
                'id' => 665,
                'name' => 'Golden/3',
                'created_at' => '2025-01-23 16:16:32',
                'updated_at' => '2025-01-23 16:16:32',
            ),
            165 => 
            array (
                'id' => 666,
                'name' => 'Golden/4',
                'created_at' => '2025-01-23 16:16:32',
                'updated_at' => '2025-01-23 16:16:32',
            ),
            166 => 
            array (
                'id' => 667,
                'name' => 'Golden/12',
                'created_at' => '2025-01-23 16:16:32',
                'updated_at' => '2025-01-23 16:16:32',
            ),
            167 => 
            array (
                'id' => 668,
                'name' => 'Golden/13',
                'created_at' => '2025-01-23 16:16:32',
                'updated_at' => '2025-01-23 16:16:32',
            ),
            168 => 
            array (
                'id' => 669,
                'name' => 'Cream/5',
                'created_at' => '2025-01-23 16:22:33',
                'updated_at' => '2025-01-23 16:22:33',
            ),
            169 => 
            array (
                'id' => 670,
                'name' => 'Pink/5',
                'created_at' => '2025-01-23 16:24:19',
                'updated_at' => '2025-01-23 16:24:19',
            ),
            170 => 
            array (
                'id' => 671,
                'name' => 'BE/41',
                'created_at' => '2025-01-23 17:01:28',
                'updated_at' => '2025-01-23 17:01:28',
            ),
            171 => 
            array (
                'id' => 672,
                'name' => 'PNK/36',
                'created_at' => '2025-01-23 17:46:03',
                'updated_at' => '2025-01-23 17:46:03',
            ),
            172 => 
            array (
                'id' => 673,
                'name' => 'PNK/37',
                'created_at' => '2025-01-23 17:46:03',
                'updated_at' => '2025-01-23 17:46:03',
            ),
            173 => 
            array (
                'id' => 674,
                'name' => 'PNK/38',
                'created_at' => '2025-01-23 17:46:03',
                'updated_at' => '2025-01-23 17:46:03',
            ),
            174 => 
            array (
                'id' => 675,
                'name' => 'PNK/39',
                'created_at' => '2025-01-23 17:46:03',
                'updated_at' => '2025-01-23 17:46:03',
            ),
            175 => 
            array (
                'id' => 676,
                'name' => 'PNK/40',
                'created_at' => '2025-01-23 17:46:03',
                'updated_at' => '2025-01-23 17:46:03',
            ),
            176 => 
            array (
                'id' => 677,
                'name' => 'PNK/41',
                'created_at' => '2025-01-23 17:46:03',
                'updated_at' => '2025-01-23 17:46:03',
            ),
            177 => 
            array (
                'id' => 678,
                'name' => 'White/45',
                'created_at' => '2025-01-23 18:14:28',
                'updated_at' => '2025-01-23 18:14:28',
            ),
            178 => 
            array (
                'id' => 679,
                'name' => 'BK/45',
                'created_at' => '2025-01-23 18:29:39',
                'updated_at' => '2025-01-23 18:29:39',
            ),
            179 => 
            array (
                'id' => 680,
                'name' => 'White/31',
                'created_at' => '2025-02-08 08:33:18',
                'updated_at' => '2025-02-08 08:33:18',
            ),
            180 => 
            array (
                'id' => 681,
                'name' => 'White/32',
                'created_at' => '2025-02-08 08:33:18',
                'updated_at' => '2025-02-08 08:33:18',
            ),
            181 => 
            array (
                'id' => 682,
                'name' => 'White/33',
                'created_at' => '2025-02-08 08:33:18',
                'updated_at' => '2025-02-08 08:33:18',
            ),
            182 => 
            array (
                'id' => 683,
                'name' => 'White/34',
                'created_at' => '2025-02-08 08:33:18',
                'updated_at' => '2025-02-08 08:33:18',
            ),
            183 => 
            array (
                'id' => 684,
                'name' => 'White/35',
                'created_at' => '2025-02-08 08:33:18',
                'updated_at' => '2025-02-08 08:33:18',
            ),
            184 => 
            array (
                'id' => 685,
                'name' => 'White/27',
                'created_at' => '2025-02-08 08:41:17',
                'updated_at' => '2025-02-08 08:41:17',
            ),
            185 => 
            array (
                'id' => 686,
                'name' => 'Green/31',
                'created_at' => '2025-02-17 06:29:15',
                'updated_at' => '2025-02-17 06:29:15',
            ),
            186 => 
            array (
                'id' => 687,
                'name' => 'Green/32',
                'created_at' => '2025-02-17 06:29:15',
                'updated_at' => '2025-02-17 06:29:15',
            ),
            187 => 
            array (
                'id' => 688,
                'name' => 'Green/34',
                'created_at' => '2025-02-17 06:29:15',
                'updated_at' => '2025-02-17 06:29:15',
            ),
            188 => 
            array (
                'id' => 689,
                'name' => 'Green/35',
                'created_at' => '2025-02-17 06:29:15',
                'updated_at' => '2025-02-17 06:29:15',
            ),
            189 => 
            array (
                'id' => 690,
                'name' => 'Brown/21',
                'created_at' => '2025-02-17 07:34:47',
                'updated_at' => '2025-02-17 07:34:47',
            ),
            190 => 
            array (
                'id' => 691,
                'name' => 'Brown/22',
                'created_at' => '2025-02-17 07:34:47',
                'updated_at' => '2025-02-17 07:34:47',
            ),
            191 => 
            array (
                'id' => 692,
                'name' => 'Brown/23',
                'created_at' => '2025-02-17 07:34:47',
                'updated_at' => '2025-02-17 07:34:47',
            ),
            192 => 
            array (
                'id' => 693,
                'name' => 'Brown/24',
                'created_at' => '2025-02-17 07:34:47',
                'updated_at' => '2025-02-17 07:34:47',
            ),
            193 => 
            array (
                'id' => 694,
                'name' => 'Brown/25',
                'created_at' => '2025-02-17 07:34:47',
                'updated_at' => '2025-02-17 07:34:47',
            ),
            194 => 
            array (
                'id' => 695,
                'name' => 'Black/21',
                'created_at' => '2025-02-17 07:46:51',
                'updated_at' => '2025-02-17 07:46:51',
            ),
            195 => 
            array (
                'id' => 696,
                'name' => 'Black/22',
                'created_at' => '2025-02-17 07:46:51',
                'updated_at' => '2025-02-17 07:46:51',
            ),
            196 => 
            array (
                'id' => 697,
                'name' => 'Black/23',
                'created_at' => '2025-02-17 07:46:51',
                'updated_at' => '2025-02-17 07:46:51',
            ),
            197 => 
            array (
                'id' => 698,
                'name' => 'Black/24',
                'created_at' => '2025-02-17 07:46:51',
                'updated_at' => '2025-02-17 07:46:51',
            ),
            198 => 
            array (
                'id' => 699,
                'name' => 'Black/25',
                'created_at' => '2025-02-17 07:46:51',
                'updated_at' => '2025-02-17 07:46:51',
            ),
            199 => 
            array (
                'id' => 700,
                'name' => 'Brown/32',
                'created_at' => '2025-02-17 07:54:11',
                'updated_at' => '2025-02-17 07:54:11',
            ),
            200 => 
            array (
                'id' => 701,
                'name' => 'White/30',
                'created_at' => '2025-02-17 08:06:08',
                'updated_at' => '2025-02-17 08:06:08',
            ),
            201 => 
            array (
                'id' => 702,
                'name' => 'Chocolate/26',
                'created_at' => '2025-02-17 08:17:07',
                'updated_at' => '2025-02-17 08:17:07',
            ),
            202 => 
            array (
                'id' => 703,
                'name' => 'Chocolate/27',
                'created_at' => '2025-02-17 08:17:07',
                'updated_at' => '2025-02-17 08:17:07',
            ),
            203 => 
            array (
                'id' => 704,
                'name' => 'Chocolate/28',
                'created_at' => '2025-02-17 08:17:07',
                'updated_at' => '2025-02-17 08:17:07',
            ),
            204 => 
            array (
                'id' => 705,
                'name' => 'Chocolate/29',
                'created_at' => '2025-02-17 08:17:07',
                'updated_at' => '2025-02-17 08:17:07',
            ),
            205 => 
            array (
                'id' => 706,
                'name' => 'Chocolate/30',
                'created_at' => '2025-02-17 08:17:07',
                'updated_at' => '2025-02-17 08:17:07',
            ),
            206 => 
            array (
                'id' => 707,
                'name' => 'Green/30',
                'created_at' => '2025-02-17 08:19:10',
                'updated_at' => '2025-02-17 08:19:10',
            ),
            207 => 
            array (
                'id' => 708,
                'name' => 'Black/26',
                'created_at' => '2025-02-17 08:21:04',
                'updated_at' => '2025-02-17 08:21:04',
            ),
            208 => 
            array (
                'id' => 709,
                'name' => 'Black/27',
                'created_at' => '2025-02-17 08:21:04',
                'updated_at' => '2025-02-17 08:21:04',
            ),
            209 => 
            array (
                'id' => 710,
                'name' => 'Black/28',
                'created_at' => '2025-02-17 08:21:04',
                'updated_at' => '2025-02-17 08:21:04',
            ),
            210 => 
            array (
                'id' => 711,
                'name' => 'Black/29',
                'created_at' => '2025-02-17 08:21:04',
                'updated_at' => '2025-02-17 08:21:04',
            ),
            211 => 
            array (
                'id' => 712,
                'name' => 'Black/30',
                'created_at' => '2025-02-17 08:21:04',
                'updated_at' => '2025-02-17 08:21:04',
            ),
            212 => 
            array (
                'id' => 713,
                'name' => 'Grey/33',
                'created_at' => '2025-02-17 08:25:46',
                'updated_at' => '2025-02-17 08:25:46',
            ),
            213 => 
            array (
                'id' => 714,
                'name' => 'Grey/34',
                'created_at' => '2025-02-17 08:25:46',
                'updated_at' => '2025-02-17 08:25:46',
            ),
            214 => 
            array (
                'id' => 715,
                'name' => 'Chocolate/32',
                'created_at' => '2025-02-17 08:27:17',
                'updated_at' => '2025-02-17 08:27:17',
            ),
            215 => 
            array (
                'id' => 716,
                'name' => 'Chocolate/33',
                'created_at' => '2025-02-17 08:27:17',
                'updated_at' => '2025-02-17 08:27:17',
            ),
            216 => 
            array (
                'id' => 717,
                'name' => 'Chocolate/34',
                'created_at' => '2025-02-17 08:27:17',
                'updated_at' => '2025-02-17 08:27:17',
            ),
            217 => 
            array (
                'id' => 718,
                'name' => 'Cream/27',
                'created_at' => '2025-02-17 08:59:40',
                'updated_at' => '2025-02-17 08:59:40',
            ),
            218 => 
            array (
                'id' => 719,
                'name' => 'Cream/28',
                'created_at' => '2025-02-17 08:59:40',
                'updated_at' => '2025-02-17 08:59:40',
            ),
            219 => 
            array (
                'id' => 720,
                'name' => 'Cream/29',
                'created_at' => '2025-02-17 08:59:40',
                'updated_at' => '2025-02-17 08:59:40',
            ),
            220 => 
            array (
                'id' => 721,
                'name' => 'White/21',
                'created_at' => '2025-02-17 09:41:05',
                'updated_at' => '2025-02-17 09:41:05',
            ),
            221 => 
            array (
                'id' => 722,
                'name' => 'White/22',
                'created_at' => '2025-02-17 09:41:05',
                'updated_at' => '2025-02-17 09:41:05',
            ),
            222 => 
            array (
                'id' => 723,
                'name' => 'White/23',
                'created_at' => '2025-02-17 09:41:05',
                'updated_at' => '2025-02-17 09:41:05',
            ),
            223 => 
            array (
                'id' => 724,
                'name' => 'White/24',
                'created_at' => '2025-02-17 09:41:05',
                'updated_at' => '2025-02-17 09:41:05',
            ),
            224 => 
            array (
                'id' => 725,
                'name' => 'White/25',
                'created_at' => '2025-02-17 09:41:05',
                'updated_at' => '2025-02-17 09:41:05',
            ),
            225 => 
            array (
                'id' => 726,
                'name' => 'Pink/21',
                'created_at' => '2025-02-17 09:43:06',
                'updated_at' => '2025-02-17 09:43:06',
            ),
            226 => 
            array (
                'id' => 727,
                'name' => 'Pink/22',
                'created_at' => '2025-02-17 09:43:06',
                'updated_at' => '2025-02-17 09:43:06',
            ),
            227 => 
            array (
                'id' => 728,
                'name' => 'Pink/23',
                'created_at' => '2025-02-17 09:43:06',
                'updated_at' => '2025-02-17 09:43:06',
            ),
            228 => 
            array (
                'id' => 729,
                'name' => 'Pink/24',
                'created_at' => '2025-02-17 09:43:06',
                'updated_at' => '2025-02-17 09:43:06',
            ),
            229 => 
            array (
                'id' => 730,
                'name' => 'Pink/25',
                'created_at' => '2025-02-17 09:43:06',
                'updated_at' => '2025-02-17 09:43:06',
            ),
            230 => 
            array (
                'id' => 731,
                'name' => 'Pink/26',
                'created_at' => '2025-02-17 10:26:23',
                'updated_at' => '2025-02-17 10:26:23',
            ),
            231 => 
            array (
                'id' => 732,
                'name' => 'Cream/26',
                'created_at' => '2025-02-17 11:01:56',
                'updated_at' => '2025-02-17 11:01:56',
            ),
            232 => 
            array (
                'id' => 733,
                'name' => 'Black/31',
                'created_at' => '2025-02-17 11:05:02',
                'updated_at' => '2025-02-17 11:05:02',
            ),
            233 => 
            array (
                'id' => 734,
                'name' => 'Silver/36',
                'created_at' => '2025-02-17 17:39:09',
                'updated_at' => '2025-02-17 17:39:09',
            ),
            234 => 
            array (
                'id' => 735,
                'name' => 'Silver/37',
                'created_at' => '2025-02-17 17:39:09',
                'updated_at' => '2025-02-17 17:39:09',
            ),
            235 => 
            array (
                'id' => 736,
                'name' => 'Silver/38',
                'created_at' => '2025-02-17 17:39:09',
                'updated_at' => '2025-02-17 17:39:09',
            ),
            236 => 
            array (
                'id' => 737,
                'name' => 'Silver/39',
                'created_at' => '2025-02-17 17:39:09',
                'updated_at' => '2025-02-17 17:39:09',
            ),
            237 => 
            array (
                'id' => 738,
                'name' => 'Silver/40',
                'created_at' => '2025-02-17 17:39:09',
                'updated_at' => '2025-02-17 17:39:09',
            ),
            238 => 
            array (
                'id' => 739,
                'name' => 'Silver/41',
                'created_at' => '2025-02-17 17:39:09',
                'updated_at' => '2025-02-17 17:39:09',
            ),
            239 => 
            array (
                'id' => 740,
                'name' => 'AS/27',
                'created_at' => '2025-03-02 21:45:05',
                'updated_at' => '2025-03-02 21:45:05',
            ),
            240 => 
            array (
                'id' => 741,
                'name' => 'AS/28',
                'created_at' => '2025-03-02 21:45:05',
                'updated_at' => '2025-03-02 21:45:05',
            ),
            241 => 
            array (
                'id' => 742,
                'name' => 'AS/29',
                'created_at' => '2025-03-02 21:45:05',
                'updated_at' => '2025-03-02 21:45:05',
            ),
            242 => 
            array (
                'id' => 743,
                'name' => 'AS/30',
                'created_at' => '2025-03-02 21:45:05',
                'updated_at' => '2025-03-02 21:45:05',
            ),
            243 => 
            array (
                'id' => 744,
                'name' => 'AS/31',
                'created_at' => '2025-03-02 21:45:05',
                'updated_at' => '2025-03-02 21:45:05',
            ),
            244 => 
            array (
                'id' => 745,
                'name' => 'AS/32',
                'created_at' => '2025-03-02 21:45:05',
                'updated_at' => '2025-03-02 21:45:05',
            ),
            245 => 
            array (
                'id' => 746,
                'name' => 'Silver/31',
                'created_at' => '2025-03-02 22:01:04',
                'updated_at' => '2025-03-02 22:01:04',
            ),
            246 => 
            array (
                'id' => 747,
                'name' => 'Silver/32',
                'created_at' => '2025-03-02 22:01:04',
                'updated_at' => '2025-03-02 22:01:04',
            ),
            247 => 
            array (
                'id' => 748,
                'name' => 'Silver/33',
                'created_at' => '2025-03-02 22:01:04',
                'updated_at' => '2025-03-02 22:01:04',
            ),
            248 => 
            array (
                'id' => 749,
                'name' => 'Silver/34',
                'created_at' => '2025-03-02 22:01:04',
                'updated_at' => '2025-03-02 22:01:04',
            ),
            249 => 
            array (
                'id' => 750,
                'name' => 'Silver/35',
                'created_at' => '2025-03-02 22:01:04',
                'updated_at' => '2025-03-02 22:01:04',
            ),
            250 => 
            array (
                'id' => 751,
                'name' => 'Red/22',
                'created_at' => '2025-03-02 22:02:31',
                'updated_at' => '2025-03-02 22:02:31',
            ),
            251 => 
            array (
                'id' => 752,
                'name' => 'Red/23',
                'created_at' => '2025-03-02 22:02:31',
                'updated_at' => '2025-03-02 22:02:31',
            ),
            252 => 
            array (
                'id' => 753,
                'name' => 'Red/24',
                'created_at' => '2025-03-02 22:02:31',
                'updated_at' => '2025-03-02 22:02:31',
            ),
            253 => 
            array (
                'id' => 754,
                'name' => 'Red/25',
                'created_at' => '2025-03-02 22:02:31',
                'updated_at' => '2025-03-02 22:02:31',
            ),
            254 => 
            array (
                'id' => 755,
                'name' => 'Blue/22',
                'created_at' => '2025-03-02 22:03:31',
                'updated_at' => '2025-03-02 22:03:31',
            ),
            255 => 
            array (
                'id' => 756,
                'name' => 'Blue/23',
                'created_at' => '2025-03-02 22:03:31',
                'updated_at' => '2025-03-02 22:03:31',
            ),
            256 => 
            array (
                'id' => 757,
                'name' => 'Blue/24',
                'created_at' => '2025-03-02 22:03:31',
                'updated_at' => '2025-03-02 22:03:31',
            ),
            257 => 
            array (
                'id' => 758,
                'name' => 'Blue/25',
                'created_at' => '2025-03-02 22:03:31',
                'updated_at' => '2025-03-02 22:03:31',
            ),
            258 => 
            array (
                'id' => 759,
                'name' => 'CH/36',
                'created_at' => '2025-03-02 22:32:12',
                'updated_at' => '2025-03-02 22:32:12',
            ),
            259 => 
            array (
                'id' => 760,
                'name' => 'CH/37',
                'created_at' => '2025-03-02 22:32:12',
                'updated_at' => '2025-03-02 22:32:12',
            ),
            260 => 
            array (
                'id' => 761,
                'name' => 'CH/38',
                'created_at' => '2025-03-02 22:32:12',
                'updated_at' => '2025-03-02 22:32:12',
            ),
            261 => 
            array (
                'id' => 762,
                'name' => 'Purple/26',
                'created_at' => '2025-03-02 22:35:21',
                'updated_at' => '2025-03-02 22:35:21',
            ),
            262 => 
            array (
                'id' => 763,
                'name' => 'Purple/28',
                'created_at' => '2025-03-02 22:35:21',
                'updated_at' => '2025-03-02 22:35:21',
            ),
            263 => 
            array (
                'id' => 764,
                'name' => 'Purple/29',
                'created_at' => '2025-03-02 22:35:21',
                'updated_at' => '2025-03-02 22:35:21',
            ),
            264 => 
            array (
                'id' => 765,
                'name' => 'Purple/30',
                'created_at' => '2025-03-02 22:35:21',
                'updated_at' => '2025-03-02 22:35:21',
            ),
            265 => 
            array (
                'id' => 766,
                'name' => 'Purple/31',
                'created_at' => '2025-03-02 22:35:21',
                'updated_at' => '2025-03-02 22:35:21',
            ),
            266 => 
            array (
                'id' => 767,
                'name' => 'Purple/32',
                'created_at' => '2025-03-02 22:37:15',
                'updated_at' => '2025-03-02 22:37:15',
            ),
            267 => 
            array (
                'id' => 768,
                'name' => 'Purple/33',
                'created_at' => '2025-03-02 22:37:15',
                'updated_at' => '2025-03-02 22:37:15',
            ),
            268 => 
            array (
                'id' => 769,
                'name' => 'Purple/34',
                'created_at' => '2025-03-02 22:37:15',
                'updated_at' => '2025-03-02 22:37:15',
            ),
            269 => 
            array (
                'id' => 770,
                'name' => 'Purple/35',
                'created_at' => '2025-03-02 22:37:15',
                'updated_at' => '2025-03-02 22:37:15',
            ),
            270 => 
            array (
                'id' => 771,
                'name' => 'Purple/27',
                'created_at' => '2025-03-02 22:40:20',
                'updated_at' => '2025-03-02 22:40:20',
            ),
            271 => 
            array (
                'id' => 772,
                'name' => 'Master/31',
                'created_at' => '2025-03-02 23:14:53',
                'updated_at' => '2025-03-02 23:14:53',
            ),
            272 => 
            array (
                'id' => 773,
                'name' => 'Master/32',
                'created_at' => '2025-03-02 23:14:53',
                'updated_at' => '2025-03-02 23:14:53',
            ),
            273 => 
            array (
                'id' => 774,
                'name' => 'Master/33',
                'created_at' => '2025-03-02 23:14:53',
                'updated_at' => '2025-03-02 23:14:53',
            ),
            274 => 
            array (
                'id' => 775,
                'name' => 'Master/34',
                'created_at' => '2025-03-02 23:14:53',
                'updated_at' => '2025-03-02 23:14:53',
            ),
            275 => 
            array (
                'id' => 776,
                'name' => 'Master/26',
                'created_at' => '2025-03-03 11:30:59',
                'updated_at' => '2025-03-03 11:30:59',
            ),
            276 => 
            array (
                'id' => 777,
                'name' => 'Master/27',
                'created_at' => '2025-03-03 11:30:59',
                'updated_at' => '2025-03-03 11:30:59',
            ),
            277 => 
            array (
                'id' => 778,
                'name' => 'Master/28',
                'created_at' => '2025-03-03 11:30:59',
                'updated_at' => '2025-03-03 11:30:59',
            ),
            278 => 
            array (
                'id' => 779,
                'name' => 'Master/29',
                'created_at' => '2025-03-03 11:30:59',
                'updated_at' => '2025-03-03 11:30:59',
            ),
            279 => 
            array (
                'id' => 780,
                'name' => 'Master/30',
                'created_at' => '2025-03-03 11:30:59',
                'updated_at' => '2025-03-03 11:30:59',
            ),
            280 => 
            array (
                'id' => 781,
                'name' => 'AS/33',
                'created_at' => '2025-03-03 11:34:56',
                'updated_at' => '2025-03-03 11:34:56',
            ),
            281 => 
            array (
                'id' => 782,
                'name' => 'AS/34',
                'created_at' => '2025-03-03 11:34:56',
                'updated_at' => '2025-03-03 11:34:56',
            ),
            282 => 
            array (
                'id' => 783,
                'name' => 'AS/35',
                'created_at' => '2025-03-03 11:34:56',
                'updated_at' => '2025-03-03 11:34:56',
            ),
            283 => 
            array (
                'id' => 784,
                'name' => 'Olive/31',
                'created_at' => '2025-03-03 11:39:29',
                'updated_at' => '2025-03-03 11:39:29',
            ),
            284 => 
            array (
                'id' => 785,
                'name' => 'Olive/32',
                'created_at' => '2025-03-03 11:39:29',
                'updated_at' => '2025-03-03 11:39:29',
            ),
            285 => 
            array (
                'id' => 786,
                'name' => 'Olive/33',
                'created_at' => '2025-03-03 11:39:29',
                'updated_at' => '2025-03-03 11:39:29',
            ),
            286 => 
            array (
                'id' => 787,
                'name' => 'Olive/34',
                'created_at' => '2025-03-03 11:39:29',
                'updated_at' => '2025-03-03 11:39:29',
            ),
            287 => 
            array (
                'id' => 788,
                'name' => 'Olive/35',
                'created_at' => '2025-03-03 11:39:29',
                'updated_at' => '2025-03-03 11:39:29',
            ),
            288 => 
            array (
                'id' => 789,
                'name' => 'Master/21',
                'created_at' => '2025-03-03 11:47:47',
                'updated_at' => '2025-03-03 11:47:47',
            ),
            289 => 
            array (
                'id' => 790,
                'name' => 'Master/22',
                'created_at' => '2025-03-03 11:47:47',
                'updated_at' => '2025-03-03 11:47:47',
            ),
            290 => 
            array (
                'id' => 791,
                'name' => 'Master/23',
                'created_at' => '2025-03-03 11:47:47',
                'updated_at' => '2025-03-03 11:47:47',
            ),
            291 => 
            array (
                'id' => 792,
                'name' => 'Master/24',
                'created_at' => '2025-03-03 11:47:47',
                'updated_at' => '2025-03-03 11:47:47',
            ),
            292 => 
            array (
                'id' => 793,
                'name' => 'Master/25',
                'created_at' => '2025-03-03 11:47:47',
                'updated_at' => '2025-03-03 11:47:47',
            ),
            293 => 
            array (
                'id' => 794,
                'name' => 'Cream/21',
                'created_at' => '2025-03-03 11:56:01',
                'updated_at' => '2025-03-03 11:56:01',
            ),
            294 => 
            array (
                'id' => 795,
                'name' => 'Cream/22',
                'created_at' => '2025-03-03 11:56:01',
                'updated_at' => '2025-03-03 11:56:01',
            ),
            295 => 
            array (
                'id' => 796,
                'name' => 'Cream/23',
                'created_at' => '2025-03-03 11:56:01',
                'updated_at' => '2025-03-03 11:56:01',
            ),
            296 => 
            array (
                'id' => 797,
                'name' => 'Cream/24',
                'created_at' => '2025-03-03 11:56:01',
                'updated_at' => '2025-03-03 11:56:01',
            ),
            297 => 
            array (
                'id' => 798,
                'name' => 'Cream/25',
                'created_at' => '2025-03-03 11:56:01',
                'updated_at' => '2025-03-03 11:56:01',
            ),
            298 => 
            array (
                'id' => 799,
                'name' => 'Green/21',
                'created_at' => '2025-03-03 20:24:57',
                'updated_at' => '2025-03-03 20:24:57',
            ),
            299 => 
            array (
                'id' => 800,
                'name' => 'Green/22',
                'created_at' => '2025-03-03 20:24:57',
                'updated_at' => '2025-03-03 20:24:57',
            ),
            300 => 
            array (
                'id' => 801,
                'name' => 'Green/23',
                'created_at' => '2025-03-03 20:24:57',
                'updated_at' => '2025-03-03 20:24:57',
            ),
            301 => 
            array (
                'id' => 802,
                'name' => 'Green/24',
                'created_at' => '2025-03-03 20:24:57',
                'updated_at' => '2025-03-03 20:24:57',
            ),
            302 => 
            array (
                'id' => 803,
                'name' => 'Green/25',
                'created_at' => '2025-03-03 20:24:57',
                'updated_at' => '2025-03-03 20:24:57',
            ),
            303 => 
            array (
                'id' => 804,
                'name' => 'Golden/26',
                'created_at' => '2025-03-03 20:48:32',
                'updated_at' => '2025-03-03 20:48:32',
            ),
            304 => 
            array (
                'id' => 805,
                'name' => 'Golden/27',
                'created_at' => '2025-03-03 20:48:32',
                'updated_at' => '2025-03-03 20:48:32',
            ),
            305 => 
            array (
                'id' => 806,
                'name' => 'Golden/28',
                'created_at' => '2025-03-03 20:48:32',
                'updated_at' => '2025-03-03 20:48:32',
            ),
            306 => 
            array (
                'id' => 807,
                'name' => 'Golden/29',
                'created_at' => '2025-03-03 20:48:32',
                'updated_at' => '2025-03-03 20:48:32',
            ),
            307 => 
            array (
                'id' => 808,
                'name' => 'Chocolate/31',
                'created_at' => '2025-03-04 18:01:00',
                'updated_at' => '2025-03-04 18:01:00',
            ),
            308 => 
            array (
                'id' => 809,
                'name' => 'Red/31',
                'created_at' => '2025-03-08 15:46:25',
                'updated_at' => '2025-03-08 15:46:25',
            ),
            309 => 
            array (
                'id' => 810,
                'name' => 'Red/32',
                'created_at' => '2025-03-08 15:46:25',
                'updated_at' => '2025-03-08 15:46:25',
            ),
            310 => 
            array (
                'id' => 811,
                'name' => 'Red/33',
                'created_at' => '2025-03-08 15:46:25',
                'updated_at' => '2025-03-08 15:46:25',
            ),
            311 => 
            array (
                'id' => 812,
                'name' => 'Red/34',
                'created_at' => '2025-03-08 15:46:25',
                'updated_at' => '2025-03-08 15:46:25',
            ),
            312 => 
            array (
                'id' => 813,
                'name' => 'Red/35',
                'created_at' => '2025-03-08 15:46:25',
                'updated_at' => '2025-03-08 15:46:25',
            ),
            313 => 
            array (
                'id' => 814,
                'name' => 'Brown/5',
                'created_at' => '2025-03-11 17:31:04',
                'updated_at' => '2025-03-11 17:31:04',
            ),
            314 => 
            array (
                'id' => 815,
                'name' => 'Coffe/42',
                'created_at' => '2025-03-15 21:15:27',
                'updated_at' => '2025-03-15 21:15:27',
            ),
            315 => 
            array (
                'id' => 816,
                'name' => 'Coffe/43',
                'created_at' => '2025-03-15 21:15:27',
                'updated_at' => '2025-03-15 21:15:27',
            ),
            316 => 
            array (
                'id' => 817,
                'name' => 'Coffe/44',
                'created_at' => '2025-03-15 21:15:27',
                'updated_at' => '2025-03-15 21:15:27',
            ),
            317 => 
            array (
                'id' => 818,
                'name' => 'Coffee/17',
                'created_at' => '2025-03-18 16:37:49',
                'updated_at' => '2025-03-18 16:37:49',
            ),
            318 => 
            array (
                'id' => 819,
                'name' => 'Coffee/18',
                'created_at' => '2025-03-18 16:37:49',
                'updated_at' => '2025-03-18 16:37:49',
            ),
            319 => 
            array (
                'id' => 820,
                'name' => 'Coffee/19',
                'created_at' => '2025-03-18 16:37:49',
                'updated_at' => '2025-03-18 16:37:49',
            ),
            320 => 
            array (
                'id' => 821,
                'name' => 'Coffee/20',
                'created_at' => '2025-03-18 16:37:49',
                'updated_at' => '2025-03-18 16:37:49',
            ),
            321 => 
            array (
                'id' => 822,
                'name' => 'Coffee/21',
                'created_at' => '2025-03-18 16:37:49',
                'updated_at' => '2025-03-18 16:37:49',
            ),
            322 => 
            array (
                'id' => 823,
                'name' => 'Pink/17',
                'created_at' => '2025-03-18 16:37:49',
                'updated_at' => '2025-03-18 16:37:49',
            ),
            323 => 
            array (
                'id' => 824,
                'name' => 'Pink/18',
                'created_at' => '2025-03-18 16:37:49',
                'updated_at' => '2025-03-18 16:37:49',
            ),
            324 => 
            array (
                'id' => 825,
                'name' => 'Pink/19',
                'created_at' => '2025-03-18 16:37:49',
                'updated_at' => '2025-03-18 16:37:49',
            ),
            325 => 
            array (
                'id' => 826,
                'name' => 'Pink/20',
                'created_at' => '2025-03-18 16:37:49',
                'updated_at' => '2025-03-18 16:37:49',
            ),
            326 => 
            array (
                'id' => 827,
                'name' => 'Grey/21',
                'created_at' => '2025-03-18 17:03:50',
                'updated_at' => '2025-03-18 17:03:50',
            ),
            327 => 
            array (
                'id' => 828,
                'name' => 'Grey/22',
                'created_at' => '2025-03-18 17:03:50',
                'updated_at' => '2025-03-18 17:03:50',
            ),
            328 => 
            array (
                'id' => 829,
                'name' => 'Grey/23',
                'created_at' => '2025-03-18 17:03:50',
                'updated_at' => '2025-03-18 17:03:50',
            ),
            329 => 
            array (
                'id' => 830,
                'name' => 'Grey/24',
                'created_at' => '2025-03-18 17:03:50',
                'updated_at' => '2025-03-18 17:03:50',
            ),
            330 => 
            array (
                'id' => 831,
                'name' => 'Grey/25',
                'created_at' => '2025-03-18 17:03:50',
                'updated_at' => '2025-03-18 17:03:50',
            ),
            331 => 
            array (
                'id' => 832,
                'name' => 'Grey/26',
                'created_at' => '2025-03-18 17:07:13',
                'updated_at' => '2025-03-18 17:07:13',
            ),
            332 => 
            array (
                'id' => 833,
                'name' => 'Off Wi/41',
                'created_at' => '2025-03-18 23:18:18',
                'updated_at' => '2025-03-18 23:18:18',
            ),
            333 => 
            array (
                'id' => 834,
                'name' => 'CH/17',
                'created_at' => '2025-05-21 13:54:59',
                'updated_at' => '2025-05-21 13:54:59',
            ),
            334 => 
            array (
                'id' => 835,
                'name' => 'CH/18',
                'created_at' => '2025-05-21 13:54:59',
                'updated_at' => '2025-05-21 13:54:59',
            ),
            335 => 
            array (
                'id' => 836,
                'name' => 'CH/19',
                'created_at' => '2025-05-21 13:54:59',
                'updated_at' => '2025-05-21 13:54:59',
            ),
            336 => 
            array (
                'id' => 837,
                'name' => 'CH/20',
                'created_at' => '2025-05-21 13:54:59',
                'updated_at' => '2025-05-21 13:54:59',
            ),
            337 => 
            array (
                'id' => 838,
                'name' => 'CH/21',
                'created_at' => '2025-05-21 13:54:59',
                'updated_at' => '2025-05-21 13:54:59',
            ),
            338 => 
            array (
                'id' => 839,
                'name' => 'White/17',
                'created_at' => '2025-05-21 13:54:59',
                'updated_at' => '2025-05-21 13:54:59',
            ),
            339 => 
            array (
                'id' => 840,
                'name' => 'White/18',
                'created_at' => '2025-05-21 13:54:59',
                'updated_at' => '2025-05-21 13:54:59',
            ),
            340 => 
            array (
                'id' => 841,
                'name' => 'White/19',
                'created_at' => '2025-05-21 13:54:59',
                'updated_at' => '2025-05-21 13:54:59',
            ),
            341 => 
            array (
                'id' => 842,
                'name' => 'White/20',
                'created_at' => '2025-05-21 13:54:59',
                'updated_at' => '2025-05-21 13:54:59',
            ),
            342 => 
            array (
                'id' => 843,
                'name' => 'Gray/27',
                'created_at' => '2025-05-21 14:07:20',
                'updated_at' => '2025-05-21 14:07:20',
            ),
            343 => 
            array (
                'id' => 844,
                'name' => 'Gray/28',
                'created_at' => '2025-05-21 14:07:20',
                'updated_at' => '2025-05-21 14:07:20',
            ),
            344 => 
            array (
                'id' => 845,
                'name' => 'Gray/29',
                'created_at' => '2025-05-21 14:07:20',
                'updated_at' => '2025-05-21 14:07:20',
            ),
            345 => 
            array (
                'id' => 846,
                'name' => 'Gray/30',
                'created_at' => '2025-05-21 14:07:20',
                'updated_at' => '2025-05-21 14:07:20',
            ),
            346 => 
            array (
                'id' => 847,
                'name' => 'Gray/31',
                'created_at' => '2025-05-21 14:07:20',
                'updated_at' => '2025-05-21 14:07:20',
            ),
            347 => 
            array (
                'id' => 848,
                'name' => 'Gray/32',
                'created_at' => '2025-05-21 14:08:12',
                'updated_at' => '2025-05-21 14:08:12',
            ),
            348 => 
            array (
                'id' => 849,
                'name' => 'Gray/33',
                'created_at' => '2025-05-21 14:08:12',
                'updated_at' => '2025-05-21 14:08:12',
            ),
            349 => 
            array (
                'id' => 850,
                'name' => 'Gray/34',
                'created_at' => '2025-05-21 14:08:12',
                'updated_at' => '2025-05-21 14:08:12',
            ),
            350 => 
            array (
                'id' => 851,
                'name' => 'Gray/35',
                'created_at' => '2025-05-21 14:08:12',
                'updated_at' => '2025-05-21 14:08:12',
            ),
            351 => 
            array (
                'id' => 852,
                'name' => 'CH/31',
                'created_at' => '2025-05-21 14:16:20',
                'updated_at' => '2025-05-21 14:16:20',
            ),
            352 => 
            array (
                'id' => 853,
                'name' => 'CH/32',
                'created_at' => '2025-05-21 14:16:20',
                'updated_at' => '2025-05-21 14:16:20',
            ),
            353 => 
            array (
                'id' => 854,
                'name' => 'CH/33',
                'created_at' => '2025-05-21 14:16:20',
                'updated_at' => '2025-05-21 14:16:20',
            ),
            354 => 
            array (
                'id' => 855,
                'name' => 'CH/34',
                'created_at' => '2025-05-21 14:16:20',
                'updated_at' => '2025-05-21 14:16:20',
            ),
            355 => 
            array (
                'id' => 856,
                'name' => 'CH/35',
                'created_at' => '2025-05-21 14:16:20',
                'updated_at' => '2025-05-21 14:16:20',
            ),
            356 => 
            array (
                'id' => 857,
                'name' => 'Coffe/26',
                'created_at' => '2025-05-21 14:37:09',
                'updated_at' => '2025-05-21 14:37:09',
            ),
            357 => 
            array (
                'id' => 858,
                'name' => 'Coffe/27',
                'created_at' => '2025-05-21 14:37:09',
                'updated_at' => '2025-05-21 14:37:09',
            ),
            358 => 
            array (
                'id' => 859,
                'name' => 'Coffe/28',
                'created_at' => '2025-05-21 14:37:09',
                'updated_at' => '2025-05-21 14:37:09',
            ),
            359 => 
            array (
                'id' => 860,
                'name' => 'Coffe/29',
                'created_at' => '2025-05-21 14:37:09',
                'updated_at' => '2025-05-21 14:37:09',
            ),
            360 => 
            array (
                'id' => 861,
                'name' => 'Coffe/30',
                'created_at' => '2025-05-21 14:37:09',
                'updated_at' => '2025-05-21 14:37:09',
            ),
            361 => 
            array (
                'id' => 862,
                'name' => 'Black/16',
                'created_at' => '2025-05-21 14:39:28',
                'updated_at' => '2025-05-21 14:39:28',
            ),
            362 => 
            array (
                'id' => 863,
                'name' => 'Black/17',
                'created_at' => '2025-05-21 14:39:28',
                'updated_at' => '2025-05-21 14:39:28',
            ),
            363 => 
            array (
                'id' => 864,
                'name' => 'Black/18',
                'created_at' => '2025-05-21 14:39:28',
                'updated_at' => '2025-05-21 14:39:28',
            ),
            364 => 
            array (
                'id' => 865,
                'name' => 'Black/19',
                'created_at' => '2025-05-21 14:39:28',
                'updated_at' => '2025-05-21 14:39:28',
            ),
            365 => 
            array (
                'id' => 866,
                'name' => 'Black/20',
                'created_at' => '2025-05-21 14:39:28',
                'updated_at' => '2025-05-21 14:39:28',
            ),
            366 => 
            array (
                'id' => 867,
                'name' => 'Gray/22',
                'created_at' => '2025-05-21 15:26:39',
                'updated_at' => '2025-05-21 15:26:39',
            ),
            367 => 
            array (
                'id' => 868,
                'name' => 'Gray/23',
                'created_at' => '2025-05-21 15:26:39',
                'updated_at' => '2025-05-21 15:26:39',
            ),
            368 => 
            array (
                'id' => 869,
                'name' => 'Gray/24',
                'created_at' => '2025-05-21 15:26:39',
                'updated_at' => '2025-05-21 15:26:39',
            ),
            369 => 
            array (
                'id' => 870,
                'name' => 'Gray/25',
                'created_at' => '2025-05-21 15:26:39',
                'updated_at' => '2025-05-21 15:26:39',
            ),
            370 => 
            array (
                'id' => 871,
                'name' => 'Gray/26',
                'created_at' => '2025-05-21 15:26:39',
                'updated_at' => '2025-05-21 15:26:39',
            ),
            371 => 
            array (
                'id' => 872,
                'name' => 'Maroon/21',
                'created_at' => '2025-05-21 15:28:35',
                'updated_at' => '2025-05-21 15:28:35',
            ),
            372 => 
            array (
                'id' => 873,
                'name' => 'Maroon/22',
                'created_at' => '2025-05-21 15:28:35',
                'updated_at' => '2025-05-21 15:28:35',
            ),
            373 => 
            array (
                'id' => 874,
                'name' => 'Maroon/23',
                'created_at' => '2025-05-21 15:28:35',
                'updated_at' => '2025-05-21 15:28:35',
            ),
            374 => 
            array (
                'id' => 875,
                'name' => 'Maroon/24',
                'created_at' => '2025-05-21 15:28:35',
                'updated_at' => '2025-05-21 15:28:35',
            ),
            375 => 
            array (
                'id' => 876,
                'name' => 'Maroon/25',
                'created_at' => '2025-05-21 15:28:35',
                'updated_at' => '2025-05-21 15:28:35',
            ),
            376 => 
            array (
                'id' => 877,
                'name' => 'Maroon/26',
                'created_at' => '2025-05-21 15:29:22',
                'updated_at' => '2025-05-21 15:29:22',
            ),
            377 => 
            array (
                'id' => 878,
                'name' => 'Maroon/27',
                'created_at' => '2025-05-21 15:29:22',
                'updated_at' => '2025-05-21 15:29:22',
            ),
            378 => 
            array (
                'id' => 879,
                'name' => 'Maroon/28',
                'created_at' => '2025-05-21 15:29:22',
                'updated_at' => '2025-05-21 15:29:22',
            ),
            379 => 
            array (
                'id' => 880,
                'name' => 'Maroon/29',
                'created_at' => '2025-05-21 15:29:22',
                'updated_at' => '2025-05-21 15:29:22',
            ),
            380 => 
            array (
                'id' => 881,
                'name' => 'Maroon/30',
                'created_at' => '2025-05-21 15:29:22',
                'updated_at' => '2025-05-21 15:29:22',
            ),
            381 => 
            array (
                'id' => 882,
                'name' => 'White/0',
                'created_at' => '2025-05-21 15:35:12',
                'updated_at' => '2025-05-21 15:35:12',
            ),
            382 => 
            array (
                'id' => 883,
                'name' => 'White/5',
                'created_at' => '2025-05-24 13:47:14',
                'updated_at' => '2025-05-24 13:47:14',
            ),
            383 => 
            array (
                'id' => 884,
                'name' => 'White/6',
                'created_at' => '2025-05-24 13:47:14',
                'updated_at' => '2025-05-24 13:47:14',
            ),
            384 => 
            array (
                'id' => 885,
                'name' => 'Olive/6',
                'created_at' => '2025-05-27 08:32:39',
                'updated_at' => '2025-05-27 08:32:39',
            ),
            385 => 
            array (
                'id' => 886,
                'name' => 'Olive/7',
                'created_at' => '2025-05-27 08:32:39',
                'updated_at' => '2025-05-27 08:32:39',
            ),
            386 => 
            array (
                'id' => 887,
                'name' => 'Olive/8',
                'created_at' => '2025-05-27 08:32:39',
                'updated_at' => '2025-05-27 08:32:39',
            ),
            387 => 
            array (
                'id' => 888,
                'name' => 'Olive/9',
                'created_at' => '2025-05-27 08:32:39',
                'updated_at' => '2025-05-27 08:32:39',
            ),
            388 => 
            array (
                'id' => 889,
                'name' => 'Chocolate/45',
                'created_at' => '2025-05-27 10:10:28',
                'updated_at' => '2025-05-27 10:10:28',
            ),
            389 => 
            array (
                'id' => 890,
                'name' => 'Chocolate/16',
                'created_at' => '2025-05-27 10:39:15',
                'updated_at' => '2025-05-27 10:39:15',
            ),
            390 => 
            array (
                'id' => 891,
                'name' => 'Chocolate/17',
                'created_at' => '2025-05-27 10:39:15',
                'updated_at' => '2025-05-27 10:39:15',
            ),
            391 => 
            array (
                'id' => 892,
                'name' => 'Chocolate/18',
                'created_at' => '2025-05-27 10:39:15',
                'updated_at' => '2025-05-27 10:39:15',
            ),
            392 => 
            array (
                'id' => 893,
                'name' => 'Master/45',
                'created_at' => '2025-05-27 10:39:17',
                'updated_at' => '2025-05-27 10:39:17',
            ),
            393 => 
            array (
                'id' => 894,
                'name' => 'Coffee/15',
                'created_at' => '2025-05-27 15:35:56',
                'updated_at' => '2025-05-27 15:35:56',
            ),
            394 => 
            array (
                'id' => 895,
                'name' => 'Master/12',
                'created_at' => '2025-05-27 15:35:58',
                'updated_at' => '2025-05-27 15:35:58',
            ),
            395 => 
            array (
                'id' => 896,
                'name' => 'Master/13',
                'created_at' => '2025-05-27 15:35:58',
                'updated_at' => '2025-05-27 15:35:58',
            ),
            396 => 
            array (
                'id' => 897,
                'name' => 'Master/14',
                'created_at' => '2025-05-27 15:35:58',
                'updated_at' => '2025-05-27 15:35:58',
            ),
            397 => 
            array (
                'id' => 898,
                'name' => 'Master/15',
                'created_at' => '2025-05-27 15:35:58',
                'updated_at' => '2025-05-27 15:35:58',
            ),
            398 => 
            array (
                'id' => 899,
                'name' => 'Brown/1',
                'created_at' => '2025-05-27 15:36:03',
                'updated_at' => '2025-05-27 15:36:03',
            ),
            399 => 
            array (
                'id' => 900,
                'name' => 'Brown/2',
                'created_at' => '2025-05-27 15:36:03',
                'updated_at' => '2025-05-27 15:36:03',
            ),
            400 => 
            array (
                'id' => 901,
                'name' => 'Brown/3',
                'created_at' => '2025-05-27 15:36:03',
                'updated_at' => '2025-05-27 15:36:03',
            ),
            401 => 
            array (
                'id' => 902,
                'name' => 'Brown/4',
                'created_at' => '2025-05-27 15:36:03',
                'updated_at' => '2025-05-27 15:36:03',
            ),
            402 => 
            array (
                'id' => 903,
                'name' => 'Brown/12',
                'created_at' => '2025-05-27 15:36:03',
                'updated_at' => '2025-05-27 15:36:03',
            ),
            403 => 
            array (
                'id' => 904,
                'name' => 'Brown/13',
                'created_at' => '2025-05-27 15:36:03',
                'updated_at' => '2025-05-27 15:36:03',
            ),
            404 => 
            array (
                'id' => 905,
                'name' => 'Sky Blue/36',
                'created_at' => '2025-05-27 15:59:08',
                'updated_at' => '2025-05-27 15:59:08',
            ),
            405 => 
            array (
                'id' => 906,
                'name' => 'Sky Blue/37',
                'created_at' => '2025-05-27 15:59:08',
                'updated_at' => '2025-05-27 15:59:08',
            ),
            406 => 
            array (
                'id' => 907,
                'name' => 'Sky Blue/38',
                'created_at' => '2025-05-27 15:59:08',
                'updated_at' => '2025-05-27 15:59:08',
            ),
            407 => 
            array (
                'id' => 908,
                'name' => 'Sky Blue/39',
                'created_at' => '2025-05-27 15:59:08',
                'updated_at' => '2025-05-27 15:59:08',
            ),
            408 => 
            array (
                'id' => 909,
                'name' => 'Sky Blue/40',
                'created_at' => '2025-05-27 15:59:08',
                'updated_at' => '2025-05-27 15:59:08',
            ),
            409 => 
            array (
                'id' => 910,
                'name' => 'Sky Blue/41',
                'created_at' => '2025-05-27 15:59:08',
                'updated_at' => '2025-05-27 15:59:08',
            ),
            410 => 
            array (
                'id' => 911,
                'name' => 'Sky Blue/35',
                'created_at' => '2025-05-27 15:59:08',
                'updated_at' => '2025-05-27 15:59:08',
            ),
            411 => 
            array (
                'id' => 912,
                'name' => 'Olive/1',
                'created_at' => '2025-05-27 15:59:12',
                'updated_at' => '2025-05-27 15:59:12',
            ),
            412 => 
            array (
                'id' => 913,
                'name' => 'Olive/2',
                'created_at' => '2025-05-27 15:59:12',
                'updated_at' => '2025-05-27 15:59:12',
            ),
            413 => 
            array (
                'id' => 914,
                'name' => 'Olive/3',
                'created_at' => '2025-05-27 15:59:12',
                'updated_at' => '2025-05-27 15:59:12',
            ),
            414 => 
            array (
                'id' => 915,
                'name' => 'Olive/4',
                'created_at' => '2025-05-27 15:59:12',
                'updated_at' => '2025-05-27 15:59:12',
            ),
            415 => 
            array (
                'id' => 916,
                'name' => 'Olive/12',
                'created_at' => '2025-05-27 15:59:12',
                'updated_at' => '2025-05-27 15:59:12',
            ),
            416 => 
            array (
                'id' => 917,
                'name' => 'Olive/13',
                'created_at' => '2025-05-27 15:59:12',
                'updated_at' => '2025-05-27 15:59:12',
            ),
            417 => 
            array (
                'id' => 918,
                'name' => 'Cream/14',
                'created_at' => '2025-05-27 15:59:16',
                'updated_at' => '2025-05-27 15:59:16',
            ),
            418 => 
            array (
                'id' => 919,
                'name' => 'Cream/15',
                'created_at' => '2025-05-27 15:59:16',
                'updated_at' => '2025-05-27 15:59:16',
            ),
            419 => 
            array (
                'id' => 920,
                'name' => 'Sky Blue/6',
                'created_at' => '2025-09-14 11:05:02',
                'updated_at' => '2025-09-14 11:05:02',
            ),
            420 => 
            array (
                'id' => 921,
                'name' => 'Sky Blue/7',
                'created_at' => '2025-09-14 11:05:02',
                'updated_at' => '2025-09-14 11:05:02',
            ),
            421 => 
            array (
                'id' => 922,
                'name' => 'Sky Blue/8',
                'created_at' => '2025-09-14 11:05:02',
                'updated_at' => '2025-09-14 11:05:02',
            ),
            422 => 
            array (
                'id' => 923,
                'name' => 'Sky Blue/9',
                'created_at' => '2025-09-14 11:05:02',
                'updated_at' => '2025-09-14 11:05:02',
            ),
            423 => 
            array (
                'id' => 924,
                'name' => 'Sky Blue/10',
                'created_at' => '2025-09-14 11:05:02',
                'updated_at' => '2025-09-14 11:05:02',
            ),
            424 => 
            array (
                'id' => 925,
                'name' => 'Sky Blue/11',
                'created_at' => '2025-09-14 11:05:02',
                'updated_at' => '2025-09-14 11:05:02',
            ),
            425 => 
            array (
                'id' => 926,
                'name' => 'Maroon/35',
                'created_at' => '2025-09-14 12:20:00',
                'updated_at' => '2025-09-14 12:20:00',
            ),
            426 => 
            array (
                'id' => 927,
                'name' => 'BR/40',
                'created_at' => '2025-09-16 10:49:17',
                'updated_at' => '2025-09-16 10:49:17',
            ),
            427 => 
            array (
                'id' => 928,
                'name' => 'BR/41',
                'created_at' => '2025-09-16 10:49:17',
                'updated_at' => '2025-09-16 10:49:17',
            ),
            428 => 
            array (
                'id' => 929,
                'name' => 'BR/42',
                'created_at' => '2025-09-16 10:49:17',
                'updated_at' => '2025-09-16 10:49:17',
            ),
            429 => 
            array (
                'id' => 930,
                'name' => 'BR/43',
                'created_at' => '2025-09-16 10:49:17',
                'updated_at' => '2025-09-16 10:49:17',
            ),
            430 => 
            array (
                'id' => 931,
                'name' => 'BR/44',
                'created_at' => '2025-09-16 10:49:17',
                'updated_at' => '2025-09-16 10:49:17',
            ),
            431 => 
            array (
                'id' => 932,
                'name' => 'Red/41',
                'created_at' => '2025-09-16 11:53:13',
                'updated_at' => '2025-09-16 11:53:13',
            ),
            432 => 
            array (
                'id' => 933,
                'name' => 'Red/42',
                'created_at' => '2025-09-16 11:53:13',
                'updated_at' => '2025-09-16 11:53:13',
            ),
            433 => 
            array (
                'id' => 934,
                'name' => 'Red/43',
                'created_at' => '2025-09-16 11:53:13',
                'updated_at' => '2025-09-16 11:53:13',
            ),
            434 => 
            array (
                'id' => 935,
                'name' => 'Red/44',
                'created_at' => '2025-09-16 11:53:13',
                'updated_at' => '2025-09-16 11:53:13',
            ),
            435 => 
            array (
                'id' => 936,
                'name' => 'Black/',
                'created_at' => '2025-09-21 16:20:10',
                'updated_at' => '2025-09-21 16:20:10',
            ),
            436 => 
            array (
                'id' => 937,
                'name' => 'Chocolate/',
                'created_at' => '2025-09-21 16:20:10',
                'updated_at' => '2025-09-21 16:20:10',
            ),
            437 => 
            array (
                'id' => 938,
                'name' => 'BK Wi/',
                'created_at' => '2025-10-03 08:20:27',
                'updated_at' => '2025-10-03 08:20:27',
            ),
            438 => 
            array (
                'id' => 939,
                'name' => 'Pink/14',
                'created_at' => '2025-11-06 14:07:06',
                'updated_at' => '2025-11-06 14:07:06',
            ),
            439 => 
            array (
                'id' => 940,
                'name' => 'Pink/15',
                'created_at' => '2025-11-06 14:07:06',
                'updated_at' => '2025-11-06 14:07:06',
            ),
            440 => 
            array (
                'id' => 941,
                'name' => 'Pink/42',
                'created_at' => '2025-11-06 14:07:06',
                'updated_at' => '2025-11-06 14:07:06',
            ),
            441 => 
            array (
                'id' => 942,
                'name' => 'Green/14',
                'created_at' => '2025-11-06 14:07:07',
                'updated_at' => '2025-11-06 14:07:07',
            ),
            442 => 
            array (
                'id' => 943,
                'name' => 'Green/15',
                'created_at' => '2025-11-06 14:07:07',
                'updated_at' => '2025-11-06 14:07:07',
            ),
            443 => 
            array (
                'id' => 944,
                'name' => 'Gray/21',
                'created_at' => '2025-11-09 10:52:18',
                'updated_at' => '2025-11-09 10:52:18',
            ),
            444 => 
            array (
                'id' => 945,
                'name' => 'Brown/17',
                'created_at' => '2025-12-11 19:51:10',
                'updated_at' => '2025-12-11 19:51:10',
            ),
            445 => 
            array (
                'id' => 946,
                'name' => 'Brown/18',
                'created_at' => '2025-12-11 19:51:10',
                'updated_at' => '2025-12-11 19:51:10',
            ),
            446 => 
            array (
                'id' => 947,
                'name' => 'Brown/19',
                'created_at' => '2025-12-11 19:51:10',
                'updated_at' => '2025-12-11 19:51:10',
            ),
            447 => 
            array (
                'id' => 948,
                'name' => 'Brown/20',
                'created_at' => '2025-12-11 19:51:10',
                'updated_at' => '2025-12-11 19:51:10',
            ),
            448 => 
            array (
                'id' => 949,
                'name' => 'Black/227',
                'created_at' => '2025-12-11 20:00:24',
                'updated_at' => '2025-12-11 20:00:24',
            ),
            449 => 
            array (
                'id' => 950,
                'name' => 'Brown/227',
                'created_at' => '2025-12-11 20:00:24',
                'updated_at' => '2025-12-11 20:00:24',
            ),
            450 => 
            array (
                'id' => 951,
                'name' => 'Purple/21',
                'created_at' => '2025-12-11 22:43:37',
                'updated_at' => '2025-12-11 22:43:37',
            ),
            451 => 
            array (
                'id' => 952,
                'name' => 'Purple/22',
                'created_at' => '2025-12-11 22:43:37',
                'updated_at' => '2025-12-11 22:43:37',
            ),
            452 => 
            array (
                'id' => 953,
                'name' => 'Purple/23',
                'created_at' => '2025-12-11 22:43:37',
                'updated_at' => '2025-12-11 22:43:37',
            ),
            453 => 
            array (
                'id' => 954,
                'name' => 'Purple/24',
                'created_at' => '2025-12-11 22:43:37',
                'updated_at' => '2025-12-11 22:43:37',
            ),
            454 => 
            array (
                'id' => 955,
                'name' => 'Purple/25',
                'created_at' => '2025-12-11 22:43:37',
                'updated_at' => '2025-12-11 22:43:37',
            ),
            455 => 
            array (
                'id' => 956,
                'name' => 'AS/22',
                'created_at' => '2025-12-11 23:26:50',
                'updated_at' => '2025-12-11 23:26:50',
            ),
            456 => 
            array (
                'id' => 957,
                'name' => 'AS/23',
                'created_at' => '2025-12-11 23:26:50',
                'updated_at' => '2025-12-11 23:26:50',
            ),
            457 => 
            array (
                'id' => 958,
                'name' => 'AS/24',
                'created_at' => '2025-12-11 23:26:50',
                'updated_at' => '2025-12-11 23:26:50',
            ),
            458 => 
            array (
                'id' => 959,
                'name' => 'AS/25',
                'created_at' => '2025-12-11 23:26:50',
                'updated_at' => '2025-12-11 23:26:50',
            ),
            459 => 
            array (
                'id' => 960,
                'name' => 'AS/26',
                'created_at' => '2025-12-11 23:26:50',
                'updated_at' => '2025-12-11 23:26:50',
            ),
            460 => 
            array (
                'id' => 961,
                'name' => 'Brown/11',
                'created_at' => '2025-12-12 20:33:01',
                'updated_at' => '2025-12-12 20:33:01',
            ),
            461 => 
            array (
                'id' => 962,
                'name' => 'Blue/',
                'created_at' => '2025-12-13 18:02:14',
                'updated_at' => '2025-12-13 18:02:14',
            ),
            462 => 
            array (
                'id' => 963,
                'name' => 'Green/',
                'created_at' => '2025-12-13 18:02:14',
                'updated_at' => '2025-12-13 18:02:14',
            ),
            463 => 
            array (
                'id' => 964,
                'name' => 'Gray/12',
                'created_at' => '2026-01-28 12:47:19',
                'updated_at' => '2026-01-28 12:47:19',
            ),
            464 => 
            array (
                'id' => 965,
                'name' => 'Gray/13',
                'created_at' => '2026-01-28 12:47:19',
                'updated_at' => '2026-01-28 12:47:19',
            ),
            465 => 
            array (
                'id' => 966,
                'name' => 'Gray/14',
                'created_at' => '2026-01-28 12:47:19',
                'updated_at' => '2026-01-28 12:47:19',
            ),
            466 => 
            array (
                'id' => 967,
                'name' => 'Gray/15',
                'created_at' => '2026-01-28 12:47:19',
                'updated_at' => '2026-01-28 12:47:19',
            ),
            467 => 
            array (
                'id' => 968,
                'name' => 'Green/6',
                'created_at' => '2026-01-29 13:59:06',
                'updated_at' => '2026-01-29 13:59:06',
            ),
            468 => 
            array (
                'id' => 969,
                'name' => 'Green/7',
                'created_at' => '2026-01-29 13:59:06',
                'updated_at' => '2026-01-29 13:59:06',
            ),
            469 => 
            array (
                'id' => 970,
                'name' => 'Green/8',
                'created_at' => '2026-01-29 13:59:06',
                'updated_at' => '2026-01-29 13:59:06',
            ),
            470 => 
            array (
                'id' => 971,
                'name' => 'Green/9',
                'created_at' => '2026-01-29 13:59:06',
                'updated_at' => '2026-01-29 13:59:06',
            ),
            471 => 
            array (
                'id' => 972,
                'name' => 'Green/1',
                'created_at' => '2026-01-29 14:04:19',
                'updated_at' => '2026-01-29 14:04:19',
            ),
            472 => 
            array (
                'id' => 973,
                'name' => 'Green/2',
                'created_at' => '2026-01-29 14:04:19',
                'updated_at' => '2026-01-29 14:04:19',
            ),
            473 => 
            array (
                'id' => 974,
                'name' => 'Green/3',
                'created_at' => '2026-01-29 14:04:19',
                'updated_at' => '2026-01-29 14:04:19',
            ),
            474 => 
            array (
                'id' => 975,
                'name' => 'Green/4',
                'created_at' => '2026-01-29 14:04:19',
                'updated_at' => '2026-01-29 14:04:19',
            ),
            475 => 
            array (
                'id' => 976,
                'name' => 'Silver/30',
                'created_at' => '2026-01-29 14:10:03',
                'updated_at' => '2026-01-29 14:10:03',
            ),
            476 => 
            array (
                'id' => 977,
                'name' => 'Cream/17',
                'created_at' => '2026-01-29 14:10:04',
                'updated_at' => '2026-01-29 14:10:04',
            ),
            477 => 
            array (
                'id' => 978,
                'name' => 'Cream/18',
                'created_at' => '2026-01-29 14:10:04',
                'updated_at' => '2026-01-29 14:10:04',
            ),
            478 => 
            array (
                'id' => 979,
                'name' => 'Silver/26',
                'created_at' => '2026-01-29 14:10:05',
                'updated_at' => '2026-01-29 14:10:05',
            ),
            479 => 
            array (
                'id' => 980,
                'name' => 'Silver/27',
                'created_at' => '2026-01-29 14:10:05',
                'updated_at' => '2026-01-29 14:10:05',
            ),
            480 => 
            array (
                'id' => 981,
                'name' => 'Silver/28',
                'created_at' => '2026-01-29 14:10:05',
                'updated_at' => '2026-01-29 14:10:05',
            ),
            481 => 
            array (
                'id' => 982,
                'name' => 'Silver/23',
                'created_at' => '2026-01-29 14:10:05',
                'updated_at' => '2026-01-29 14:10:05',
            ),
            482 => 
            array (
                'id' => 983,
                'name' => 'Silver/24',
                'created_at' => '2026-01-29 14:10:05',
                'updated_at' => '2026-01-29 14:10:05',
            ),
            483 => 
            array (
                'id' => 984,
                'name' => 'Silver/25',
                'created_at' => '2026-01-29 14:10:05',
                'updated_at' => '2026-01-29 14:10:05',
            ),
            484 => 
            array (
                'id' => 985,
                'name' => 'Silver/17',
                'created_at' => '2026-01-29 14:10:05',
                'updated_at' => '2026-01-29 14:10:05',
            ),
        ));
        
        
    }
}