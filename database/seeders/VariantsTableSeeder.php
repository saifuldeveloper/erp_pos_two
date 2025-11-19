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
                'name' => 'Chocolate/16',
                'created_at' => '2025-04-19 21:11:13',
                'updated_at' => '2025-04-19 21:11:13',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Chocolate/17',
                'created_at' => '2025-04-19 21:11:13',
                'updated_at' => '2025-04-19 21:11:13',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Black/16',
                'created_at' => '2025-04-19 21:13:04',
                'updated_at' => '2025-04-19 21:13:04',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Black/17',
                'created_at' => '2025-04-19 21:13:04',
                'updated_at' => '2025-04-19 21:13:04',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Chocolate/18',
                'created_at' => '2025-04-19 21:50:07',
                'updated_at' => '2025-04-19 21:50:07',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Chocolate/44',
                'created_at' => '2025-04-19 21:53:40',
                'updated_at' => '2025-04-19 21:53:40',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Chocolate/45',
                'created_at' => '2025-04-19 21:53:40',
                'updated_at' => '2025-04-19 21:53:40',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Black/42',
                'created_at' => '2025-04-19 21:56:30',
                'updated_at' => '2025-04-19 21:56:30',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Black/18',
                'created_at' => '2025-04-19 21:57:41',
                'updated_at' => '2025-04-19 21:57:41',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Chocolate/43',
                'created_at' => '2025-04-19 22:08:14',
                'updated_at' => '2025-04-19 22:08:14',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Black/43',
                'created_at' => '2025-04-19 22:16:20',
                'updated_at' => '2025-04-19 22:16:20',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Black/44',
                'created_at' => '2025-04-19 22:16:20',
                'updated_at' => '2025-04-19 22:16:20',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Black/45',
                'created_at' => '2025-04-19 22:19:36',
                'updated_at' => '2025-04-19 22:19:36',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Chocolate/42',
                'created_at' => '2025-04-19 22:19:36',
                'updated_at' => '2025-04-19 22:19:36',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Master/39',
                'created_at' => '2025-04-19 22:37:07',
                'updated_at' => '2025-04-19 22:37:07',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Black/39',
                'created_at' => '2025-04-19 22:38:56',
                'updated_at' => '2025-04-19 22:38:56',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Black/40',
                'created_at' => '2025-04-19 22:38:56',
                'updated_at' => '2025-04-19 22:38:56',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Black/41',
                'created_at' => '2025-04-19 22:38:56',
                'updated_at' => '2025-04-19 22:38:56',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Chocolate/39',
                'created_at' => '2025-04-19 22:38:56',
                'updated_at' => '2025-04-19 22:38:56',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Chocolate/40',
                'created_at' => '2025-04-19 22:38:56',
                'updated_at' => '2025-04-19 22:38:56',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Chocolate/41',
                'created_at' => '2025-04-19 22:38:56',
                'updated_at' => '2025-04-19 22:38:56',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Master/41',
                'created_at' => '2025-04-19 22:42:22',
                'updated_at' => '2025-04-19 22:42:22',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Master/42',
                'created_at' => '2025-04-19 22:42:22',
                'updated_at' => '2025-04-19 22:42:22',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Master/40',
                'created_at' => '2025-04-19 22:44:24',
                'updated_at' => '2025-04-19 22:44:24',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Master/43',
                'created_at' => '2025-04-19 22:44:24',
                'updated_at' => '2025-04-19 22:44:24',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Master/44',
                'created_at' => '2025-04-19 23:11:51',
                'updated_at' => '2025-04-19 23:11:51',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Black/13',
                'created_at' => '2025-04-19 23:45:26',
                'updated_at' => '2025-04-19 23:45:26',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Black/14',
                'created_at' => '2025-04-19 23:45:26',
                'updated_at' => '2025-04-19 23:45:26',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Black/15',
                'created_at' => '2025-04-19 23:45:26',
                'updated_at' => '2025-04-19 23:45:26',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Black/10',
                'created_at' => '2025-04-19 23:59:26',
                'updated_at' => '2025-04-19 23:59:26',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Black/11',
                'created_at' => '2025-04-19 23:59:26',
                'updated_at' => '2025-04-19 23:59:26',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Black/12',
                'created_at' => '2025-04-19 23:59:26',
                'updated_at' => '2025-04-19 23:59:26',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Chocolate/10',
                'created_at' => '2025-04-19 23:59:26',
                'updated_at' => '2025-04-19 23:59:26',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Chocolate/11',
                'created_at' => '2025-04-19 23:59:26',
                'updated_at' => '2025-04-19 23:59:26',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Chocolate/12',
                'created_at' => '2025-04-19 23:59:26',
                'updated_at' => '2025-04-19 23:59:26',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Chocolate/13',
                'created_at' => '2025-04-19 23:59:26',
                'updated_at' => '2025-04-19 23:59:26',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Chocolate/14',
                'created_at' => '2025-04-19 23:59:26',
                'updated_at' => '2025-04-19 23:59:26',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Chocolate/15',
                'created_at' => '2025-04-19 23:59:26',
                'updated_at' => '2025-04-19 23:59:26',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Black/',
                'created_at' => '2025-04-20 02:25:40',
                'updated_at' => '2025-04-20 02:25:40',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'White/39',
                'created_at' => '2025-04-20 16:44:59',
                'updated_at' => '2025-04-20 16:44:59',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'White/41',
                'created_at' => '2025-04-20 16:44:59',
                'updated_at' => '2025-04-20 16:44:59',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'White/42',
                'created_at' => '2025-04-20 16:44:59',
                'updated_at' => '2025-04-20 16:44:59',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'White/43',
                'created_at' => '2025-04-20 16:44:59',
                'updated_at' => '2025-04-20 16:44:59',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'White/44',
                'created_at' => '2025-04-20 16:44:59',
                'updated_at' => '2025-04-20 16:44:59',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Gray/40',
                'created_at' => '2025-04-20 20:08:15',
                'updated_at' => '2025-04-20 20:08:15',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Gray/41',
                'created_at' => '2025-04-20 20:08:15',
                'updated_at' => '2025-04-20 20:08:15',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Gray/42',
                'created_at' => '2025-04-20 20:08:15',
                'updated_at' => '2025-04-20 20:08:15',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Gray/43',
                'created_at' => '2025-04-20 20:08:15',
                'updated_at' => '2025-04-20 20:08:15',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'Blue/41',
                'created_at' => '2025-04-21 01:06:50',
                'updated_at' => '2025-04-21 01:06:50',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'Blue/42',
                'created_at' => '2025-04-21 01:06:50',
                'updated_at' => '2025-04-21 01:06:50',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Blue/43',
                'created_at' => '2025-04-21 01:06:50',
                'updated_at' => '2025-04-21 01:06:50',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Blue/44',
                'created_at' => '2025-04-21 01:06:50',
                'updated_at' => '2025-04-21 01:06:50',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Master/45',
                'created_at' => '2025-04-21 02:51:00',
                'updated_at' => '2025-04-21 02:51:00',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'Black/35',
                'created_at' => '2025-04-21 16:51:16',
                'updated_at' => '2025-04-21 16:51:16',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'Black/36',
                'created_at' => '2025-04-21 16:51:16',
                'updated_at' => '2025-04-21 16:51:16',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'Black/46',
                'created_at' => '2025-04-21 16:55:15',
                'updated_at' => '2025-04-21 16:55:15',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'Master/46',
                'created_at' => '2025-04-21 17:04:26',
                'updated_at' => '2025-04-21 17:04:26',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'Chocolate/46',
                'created_at' => '2025-04-21 20:05:20',
                'updated_at' => '2025-04-21 20:05:20',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'Black/47',
                'created_at' => '2025-04-21 20:11:40',
                'updated_at' => '2025-04-21 20:11:40',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'Coffee/40',
                'created_at' => '2025-04-21 21:34:24',
                'updated_at' => '2025-04-21 21:34:24',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'Coffee/41',
                'created_at' => '2025-04-21 21:34:24',
                'updated_at' => '2025-04-21 21:34:24',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'Coffee/42',
                'created_at' => '2025-04-21 21:34:24',
                'updated_at' => '2025-04-21 21:34:24',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'Coffee/43',
                'created_at' => '2025-04-21 21:34:24',
                'updated_at' => '2025-04-21 21:34:24',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'Black/8',
                'created_at' => '2025-04-21 22:15:25',
                'updated_at' => '2025-04-21 22:15:25',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'Black/9',
                'created_at' => '2025-04-21 22:15:25',
                'updated_at' => '2025-04-21 22:15:25',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'Golden/37',
                'created_at' => '2025-04-22 00:09:20',
                'updated_at' => '2025-04-22 00:09:20',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'Golden/38',
                'created_at' => '2025-04-22 00:09:20',
                'updated_at' => '2025-04-22 00:09:20',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'Golden/39',
                'created_at' => '2025-04-22 00:09:20',
                'updated_at' => '2025-04-22 00:09:20',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'Cream/41',
                'created_at' => '2025-04-22 00:18:17',
                'updated_at' => '2025-04-22 00:18:17',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'Cream/36',
                'created_at' => '2025-04-22 00:21:30',
                'updated_at' => '2025-04-22 00:21:30',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'Cream/37',
                'created_at' => '2025-04-22 00:21:30',
                'updated_at' => '2025-04-22 00:21:30',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'Cream/38',
                'created_at' => '2025-04-22 00:21:30',
                'updated_at' => '2025-04-22 00:21:30',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'Cream/39',
                'created_at' => '2025-04-22 00:21:30',
                'updated_at' => '2025-04-22 00:21:30',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'Cream/40',
                'created_at' => '2025-04-22 00:21:30',
                'updated_at' => '2025-04-22 00:21:30',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'Pink/36',
                'created_at' => '2025-04-22 00:21:30',
                'updated_at' => '2025-04-22 00:21:30',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'Pink/37',
                'created_at' => '2025-04-22 00:21:30',
                'updated_at' => '2025-04-22 00:21:30',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'Pink/38',
                'created_at' => '2025-04-22 00:21:30',
                'updated_at' => '2025-04-22 00:21:30',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'Pink/39',
                'created_at' => '2025-04-22 00:21:30',
                'updated_at' => '2025-04-22 00:21:30',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'Pink/40',
                'created_at' => '2025-04-22 00:21:30',
                'updated_at' => '2025-04-22 00:21:30',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'Black/38',
                'created_at' => '2025-04-22 00:26:09',
                'updated_at' => '2025-04-22 00:26:09',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'Black/37',
                'created_at' => '2025-04-22 00:27:44',
                'updated_at' => '2025-04-22 00:27:44',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'Coffee/36',
                'created_at' => '2025-04-22 00:30:03',
                'updated_at' => '2025-04-22 00:30:03',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'Coffee/37',
                'created_at' => '2025-04-22 00:30:03',
                'updated_at' => '2025-04-22 00:30:03',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'Coffee/38',
                'created_at' => '2025-04-22 00:30:03',
                'updated_at' => '2025-04-22 00:30:03',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'Master/36',
                'created_at' => '2025-04-22 00:30:03',
                'updated_at' => '2025-04-22 00:30:03',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'Master/37',
                'created_at' => '2025-04-22 00:30:03',
                'updated_at' => '2025-04-22 00:30:03',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'Master/38',
                'created_at' => '2025-04-22 00:30:03',
                'updated_at' => '2025-04-22 00:30:03',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'Golden/10',
                'created_at' => '2025-04-22 00:32:15',
                'updated_at' => '2025-04-22 00:32:15',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'Golden/11',
                'created_at' => '2025-04-22 00:32:15',
                'updated_at' => '2025-04-22 00:32:15',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'Golden/40',
                'created_at' => '2025-04-22 00:32:42',
                'updated_at' => '2025-04-22 00:32:42',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'Golden/41',
                'created_at' => '2025-04-22 00:32:42',
                'updated_at' => '2025-04-22 00:32:42',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'Coffee/35',
                'created_at' => '2025-04-22 00:38:06',
                'updated_at' => '2025-04-22 00:38:06',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'Coffee/39',
                'created_at' => '2025-04-22 00:38:06',
                'updated_at' => '2025-04-22 00:38:06',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'Master/35',
                'created_at' => '2025-04-22 00:39:53',
                'updated_at' => '2025-04-22 00:39:53',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'Coffee/5',
                'created_at' => '2025-04-22 01:04:16',
                'updated_at' => '2025-04-22 01:04:16',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'Coffee/7',
                'created_at' => '2025-04-22 01:04:16',
                'updated_at' => '2025-04-22 01:04:16',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'Golden/31',
                'created_at' => '2025-04-22 01:05:04',
                'updated_at' => '2025-04-22 01:05:04',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'Coffee/44',
                'created_at' => '2025-04-22 01:13:02',
                'updated_at' => '2025-04-22 01:13:02',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'Pink/35',
                'created_at' => '2025-04-22 01:38:57',
                'updated_at' => '2025-04-22 01:38:57',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'RED/36',
                'created_at' => '2025-04-22 01:48:20',
                'updated_at' => '2025-08-09 15:55:54',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'RED/39',
                'created_at' => '2025-04-22 01:48:20',
                'updated_at' => '2025-04-24 18:40:00',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'RED/40',
                'created_at' => '2025-04-22 01:48:20',
                'updated_at' => '2025-04-24 17:43:16',
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'Golden/36',
                'created_at' => '2025-04-22 01:51:38',
                'updated_at' => '2025-04-22 01:51:38',
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'Pink/41',
                'created_at' => '2025-04-22 01:51:38',
                'updated_at' => '2025-04-22 01:51:38',
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'Coffee/6',
                'created_at' => '2025-04-22 01:58:04',
                'updated_at' => '2025-04-22 01:58:04',
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'Coffee/8',
                'created_at' => '2025-04-22 01:58:04',
                'updated_at' => '2025-04-22 01:58:04',
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'Coffee/9',
                'created_at' => '2025-04-22 01:58:04',
                'updated_at' => '2025-04-22 01:58:04',
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'Coffee/10',
                'created_at' => '2025-04-22 01:58:04',
                'updated_at' => '2025-04-22 01:58:04',
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'Coffee/11',
                'created_at' => '2025-04-22 01:58:04',
                'updated_at' => '2025-04-22 01:58:04',
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'Pink/6',
                'created_at' => '2025-04-22 01:58:04',
                'updated_at' => '2025-04-22 01:58:04',
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'Pink/8',
                'created_at' => '2025-04-22 01:58:04',
                'updated_at' => '2025-04-22 01:58:04',
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'Pink/9',
                'created_at' => '2025-04-22 01:58:04',
                'updated_at' => '2025-04-22 01:58:04',
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'Pink/10',
                'created_at' => '2025-04-22 01:58:04',
                'updated_at' => '2025-04-22 01:58:04',
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'Pink/11',
                'created_at' => '2025-04-22 01:58:04',
                'updated_at' => '2025-04-22 01:58:04',
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'Red/35',
                'created_at' => '2025-04-22 02:20:51',
                'updated_at' => '2025-04-22 02:20:51',
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'Cream/35',
                'created_at' => '2025-04-22 02:22:35',
                'updated_at' => '2025-04-22 02:22:35',
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'RED/38',
                'created_at' => '2025-04-22 02:43:38',
                'updated_at' => '2025-08-09 15:55:54',
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'Golden/35',
                'created_at' => '2025-04-22 02:44:18',
                'updated_at' => '2025-04-22 02:44:18',
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'Maroon/36',
                'created_at' => '2025-04-22 02:48:53',
                'updated_at' => '2025-04-22 02:48:53',
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'Maroon/39',
                'created_at' => '2025-04-22 02:48:53',
                'updated_at' => '2025-04-22 02:48:53',
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'Maroon/40',
                'created_at' => '2025-04-22 02:48:53',
                'updated_at' => '2025-04-22 02:48:53',
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'Maroon/35',
                'created_at' => '2025-04-22 02:48:53',
                'updated_at' => '2025-04-22 02:48:53',
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'Maroon/38',
                'created_at' => '2025-04-22 02:48:53',
                'updated_at' => '2025-04-22 02:48:53',
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'Black/7',
                'created_at' => '2025-04-22 02:58:31',
                'updated_at' => '2025-04-22 02:58:31',
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'Maroon/37',
                'created_at' => '2025-04-22 03:10:57',
                'updated_at' => '2025-04-22 03:10:57',
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'Golden/6',
                'created_at' => '2025-04-22 17:21:22',
                'updated_at' => '2025-04-22 17:21:22',
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'Black/6',
                'created_at' => '2025-04-22 17:35:03',
                'updated_at' => '2025-04-22 17:35:03',
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'Maroon/6',
                'created_at' => '2025-04-22 17:48:46',
                'updated_at' => '2025-04-22 17:48:46',
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'Maroon/8',
                'created_at' => '2025-04-22 17:48:46',
                'updated_at' => '2025-04-22 17:48:46',
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'Maroon/9',
                'created_at' => '2025-04-22 17:48:46',
                'updated_at' => '2025-04-22 17:48:46',
            ),
            130 => 
            array (
                'id' => 131,
                'name' => 'White/35',
                'created_at' => '2025-04-22 18:05:48',
                'updated_at' => '2025-04-22 18:05:48',
            ),
            131 => 
            array (
                'id' => 132,
                'name' => 'White/36',
                'created_at' => '2025-04-22 18:05:48',
                'updated_at' => '2025-04-22 18:05:48',
            ),
            132 => 
            array (
                'id' => 133,
                'name' => 'White/40',
                'created_at' => '2025-04-22 18:05:48',
                'updated_at' => '2025-04-22 18:05:48',
            ),
            133 => 
            array (
                'id' => 134,
                'name' => 'White/37',
                'created_at' => '2025-04-22 18:09:20',
                'updated_at' => '2025-04-22 18:09:20',
            ),
            134 => 
            array (
                'id' => 135,
                'name' => 'White/38',
                'created_at' => '2025-04-22 19:10:05',
                'updated_at' => '2025-04-22 19:10:05',
            ),
            135 => 
            array (
                'id' => 136,
                'name' => 'Maroon/10',
                'created_at' => '2025-04-22 19:22:33',
                'updated_at' => '2025-04-22 19:22:33',
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'Cream/6',
                'created_at' => '2025-04-22 19:31:22',
                'updated_at' => '2025-04-22 19:31:22',
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'Cream/7',
                'created_at' => '2025-04-22 19:31:22',
                'updated_at' => '2025-04-22 19:31:22',
            ),
            138 => 
            array (
                'id' => 139,
                'name' => 'Cream/8',
                'created_at' => '2025-04-22 19:31:22',
                'updated_at' => '2025-04-22 19:31:22',
            ),
            139 => 
            array (
                'id' => 140,
                'name' => 'Cream/10',
                'created_at' => '2025-04-22 19:31:22',
                'updated_at' => '2025-04-22 19:31:22',
            ),
            140 => 
            array (
                'id' => 141,
                'name' => 'Cream/11',
                'created_at' => '2025-04-22 19:31:22',
                'updated_at' => '2025-04-22 19:31:22',
            ),
            141 => 
            array (
                'id' => 142,
                'name' => 'Pink/7',
                'created_at' => '2025-04-22 19:31:22',
                'updated_at' => '2025-04-22 19:31:22',
            ),
            142 => 
            array (
                'id' => 143,
                'name' => 'Maroon/11',
                'created_at' => '2025-04-22 19:35:08',
                'updated_at' => '2025-04-22 19:35:08',
            ),
            143 => 
            array (
                'id' => 144,
                'name' => 'Cream/9',
                'created_at' => '2025-04-22 19:58:52',
                'updated_at' => '2025-04-22 19:58:52',
            ),
            144 => 
            array (
                'id' => 145,
                'name' => 'Maroon/7',
                'created_at' => '2025-04-22 20:03:02',
                'updated_at' => '2025-04-22 20:03:02',
            ),
            145 => 
            array (
                'id' => 146,
                'name' => 'Maroon/41',
                'created_at' => '2025-04-22 20:10:58',
                'updated_at' => '2025-04-22 20:10:58',
            ),
            146 => 
            array (
                'id' => 147,
                'name' => 'Maroon/13',
                'created_at' => '2025-04-22 20:26:41',
                'updated_at' => '2025-04-22 20:26:41',
            ),
            147 => 
            array (
                'id' => 148,
                'name' => 'Maroon/14',
                'created_at' => '2025-04-22 20:26:41',
                'updated_at' => '2025-04-22 20:26:41',
            ),
            148 => 
            array (
                'id' => 149,
                'name' => 'Silver/7',
                'created_at' => '2025-04-22 20:48:01',
                'updated_at' => '2025-04-22 20:48:01',
            ),
            149 => 
            array (
                'id' => 150,
                'name' => 'Silver/8',
                'created_at' => '2025-04-22 20:48:01',
                'updated_at' => '2025-04-22 20:48:01',
            ),
            150 => 
            array (
                'id' => 151,
                'name' => 'Silver/9',
                'created_at' => '2025-04-22 20:48:01',
                'updated_at' => '2025-04-22 20:48:01',
            ),
            151 => 
            array (
                'id' => 152,
                'name' => 'Silver/10',
                'created_at' => '2025-04-22 20:48:01',
                'updated_at' => '2025-04-22 20:48:01',
            ),
            152 => 
            array (
                'id' => 153,
                'name' => 'Gray/9',
                'created_at' => '2025-04-22 20:50:18',
                'updated_at' => '2025-04-22 20:50:18',
            ),
            153 => 
            array (
                'id' => 154,
                'name' => 'Gray/11',
                'created_at' => '2025-04-22 20:50:18',
                'updated_at' => '2025-04-22 20:50:18',
            ),
            154 => 
            array (
                'id' => 155,
                'name' => 'Coffee/13',
                'created_at' => '2025-04-22 20:59:12',
                'updated_at' => '2025-04-22 20:59:12',
            ),
            155 => 
            array (
                'id' => 156,
                'name' => 'Silver/35',
                'created_at' => '2025-04-22 21:18:41',
                'updated_at' => '2025-04-22 21:18:41',
            ),
            156 => 
            array (
                'id' => 157,
                'name' => 'Silver/38',
                'created_at' => '2025-04-22 21:18:41',
                'updated_at' => '2025-04-22 21:18:41',
            ),
            157 => 
            array (
                'id' => 158,
                'name' => 'Silver/39',
                'created_at' => '2025-04-22 21:18:41',
                'updated_at' => '2025-04-22 21:18:41',
            ),
            158 => 
            array (
                'id' => 159,
                'name' => 'Silver/40',
                'created_at' => '2025-04-22 21:18:41',
                'updated_at' => '2025-04-22 21:18:41',
            ),
            159 => 
            array (
                'id' => 160,
                'name' => 'Chocolate/7',
                'created_at' => '2025-04-22 22:54:00',
                'updated_at' => '2025-04-22 22:54:00',
            ),
            160 => 
            array (
                'id' => 161,
                'name' => 'Chocolate/9',
                'created_at' => '2025-04-22 22:54:00',
                'updated_at' => '2025-04-22 22:54:00',
            ),
            161 => 
            array (
                'id' => 162,
                'name' => 'Pink/14',
                'created_at' => '2025-04-22 23:09:06',
                'updated_at' => '2025-04-22 23:09:06',
            ),
            162 => 
            array (
                'id' => 163,
                'name' => 'Chocolate/37',
                'created_at' => '2025-04-22 23:18:36',
                'updated_at' => '2025-04-22 23:18:36',
            ),
            163 => 
            array (
                'id' => 164,
                'name' => 'Pink/13',
                'created_at' => '2025-04-22 23:23:16',
                'updated_at' => '2025-04-22 23:23:16',
            ),
            164 => 
            array (
                'id' => 165,
                'name' => 'Pink/15',
                'created_at' => '2025-04-22 23:23:16',
                'updated_at' => '2025-04-22 23:23:16',
            ),
            165 => 
            array (
                'id' => 166,
                'name' => 'Silver/36',
                'created_at' => '2025-04-22 23:24:51',
                'updated_at' => '2025-04-22 23:24:51',
            ),
            166 => 
            array (
                'id' => 167,
                'name' => 'Silver/37',
                'created_at' => '2025-04-22 23:24:51',
                'updated_at' => '2025-04-22 23:24:51',
            ),
            167 => 
            array (
                'id' => 168,
                'name' => 'Purple/36',
                'created_at' => '2025-04-22 23:46:48',
                'updated_at' => '2025-04-22 23:46:48',
            ),
            168 => 
            array (
                'id' => 169,
                'name' => 'Purple/39',
                'created_at' => '2025-04-22 23:46:48',
                'updated_at' => '2025-04-22 23:46:48',
            ),
            169 => 
            array (
                'id' => 170,
                'name' => 'Purple/40',
                'created_at' => '2025-04-22 23:46:48',
                'updated_at' => '2025-04-22 23:46:48',
            ),
            170 => 
            array (
                'id' => 171,
                'name' => 'Coffee/14',
                'created_at' => '2025-04-23 00:29:15',
                'updated_at' => '2025-04-23 00:29:15',
            ),
            171 => 
            array (
                'id' => 172,
                'name' => 'Coffee/15',
                'created_at' => '2025-04-23 00:29:15',
                'updated_at' => '2025-04-23 00:29:15',
            ),
            172 => 
            array (
                'id' => 173,
                'name' => 'Coffee/12',
                'created_at' => '2025-04-23 00:40:13',
                'updated_at' => '2025-04-23 00:40:13',
            ),
            173 => 
            array (
                'id' => 174,
                'name' => 'Blue/36',
                'created_at' => '2025-04-23 01:17:19',
                'updated_at' => '2025-04-23 01:17:19',
            ),
            174 => 
            array (
                'id' => 175,
                'name' => 'Golden/7',
                'created_at' => '2025-04-23 01:19:21',
                'updated_at' => '2025-04-23 01:19:21',
            ),
            175 => 
            array (
                'id' => 176,
                'name' => 'Silver/11',
                'created_at' => '2025-04-23 01:26:50',
                'updated_at' => '2025-04-23 01:26:50',
            ),
            176 => 
            array (
                'id' => 177,
                'name' => 'White/7',
                'created_at' => '2025-04-23 01:31:29',
                'updated_at' => '2025-04-23 01:31:29',
            ),
            177 => 
            array (
                'id' => 178,
                'name' => 'White/8',
                'created_at' => '2025-04-23 01:31:29',
                'updated_at' => '2025-04-23 01:31:29',
            ),
            178 => 
            array (
                'id' => 179,
                'name' => 'White/9',
                'created_at' => '2025-04-23 01:31:29',
                'updated_at' => '2025-04-23 01:31:29',
            ),
            179 => 
            array (
                'id' => 180,
                'name' => 'White/10',
                'created_at' => '2025-04-23 01:31:29',
                'updated_at' => '2025-04-23 01:31:29',
            ),
            180 => 
            array (
                'id' => 181,
                'name' => 'White/11',
                'created_at' => '2025-04-23 01:31:29',
                'updated_at' => '2025-04-23 01:31:29',
            ),
            181 => 
            array (
                'id' => 182,
                'name' => 'Silver/41',
                'created_at' => '2025-04-23 01:34:08',
                'updated_at' => '2025-04-23 01:34:08',
            ),
            182 => 
            array (
                'id' => 183,
                'name' => 'Gray/37',
                'created_at' => '2025-04-23 01:37:05',
                'updated_at' => '2025-04-23 01:37:05',
            ),
            183 => 
            array (
                'id' => 184,
                'name' => 'Gray/38',
                'created_at' => '2025-04-23 01:37:05',
                'updated_at' => '2025-04-23 01:37:05',
            ),
            184 => 
            array (
                'id' => 185,
                'name' => 'Black/5',
                'created_at' => '2025-04-23 01:42:19',
                'updated_at' => '2025-04-23 01:42:19',
            ),
            185 => 
            array (
                'id' => 186,
                'name' => 'Golden/8',
                'created_at' => '2025-04-23 01:49:02',
                'updated_at' => '2025-04-23 01:49:02',
            ),
            186 => 
            array (
                'id' => 187,
                'name' => 'Purple/38',
                'created_at' => '2025-04-23 04:04:51',
                'updated_at' => '2025-04-23 04:04:51',
            ),
            187 => 
            array (
                'id' => 188,
                'name' => 'Chocolate/8',
                'created_at' => '2025-04-23 17:30:12',
                'updated_at' => '2025-04-23 17:30:12',
            ),
            188 => 
            array (
                'id' => 189,
                'name' => 'Black/1',
                'created_at' => '2025-04-23 17:32:50',
                'updated_at' => '2025-04-23 17:32:50',
            ),
            189 => 
            array (
                'id' => 190,
                'name' => 'Black/2',
                'created_at' => '2025-04-23 17:32:50',
                'updated_at' => '2025-04-23 17:32:50',
            ),
            190 => 
            array (
                'id' => 191,
                'name' => 'Chocolate/6',
                'created_at' => '2025-04-23 17:33:44',
                'updated_at' => '2025-04-23 17:33:44',
            ),
            191 => 
            array (
                'id' => 192,
                'name' => 'Black/3',
                'created_at' => '2025-04-23 17:35:35',
                'updated_at' => '2025-04-23 17:35:35',
            ),
            192 => 
            array (
                'id' => 193,
                'name' => 'Chocolate/2',
                'created_at' => '2025-04-23 17:35:35',
                'updated_at' => '2025-04-23 17:35:35',
            ),
            193 => 
            array (
                'id' => 194,
                'name' => 'Chocolate/3',
                'created_at' => '2025-04-23 17:35:35',
                'updated_at' => '2025-04-23 17:35:35',
            ),
            194 => 
            array (
                'id' => 195,
                'name' => 'Chocolate/36',
                'created_at' => '2025-04-23 17:44:08',
                'updated_at' => '2025-04-23 17:44:08',
            ),
            195 => 
            array (
                'id' => 196,
                'name' => 'Chocolate/1',
                'created_at' => '2025-04-23 17:49:28',
                'updated_at' => '2025-04-23 17:49:28',
            ),
            196 => 
            array (
                'id' => 197,
                'name' => 'Chocolate/4',
                'created_at' => '2025-04-23 17:49:28',
                'updated_at' => '2025-04-23 17:49:28',
            ),
            197 => 
            array (
                'id' => 198,
                'name' => 'Master/1',
                'created_at' => '2025-04-23 17:49:28',
                'updated_at' => '2025-04-23 17:49:28',
            ),
            198 => 
            array (
                'id' => 199,
                'name' => 'Master/2',
                'created_at' => '2025-04-23 17:49:28',
                'updated_at' => '2025-04-23 17:49:28',
            ),
            199 => 
            array (
                'id' => 200,
                'name' => 'Master/3',
                'created_at' => '2025-04-23 17:49:28',
                'updated_at' => '2025-04-23 17:49:28',
            ),
            200 => 
            array (
                'id' => 201,
                'name' => 'Master/4',
                'created_at' => '2025-04-23 17:49:28',
                'updated_at' => '2025-04-23 17:49:28',
            ),
            201 => 
            array (
                'id' => 202,
                'name' => 'Black/4',
                'created_at' => '2025-04-23 17:58:33',
                'updated_at' => '2025-04-23 17:58:33',
            ),
            202 => 
            array (
                'id' => 203,
                'name' => 'Coffee/1',
                'created_at' => '2025-04-23 18:35:04',
                'updated_at' => '2025-04-23 18:35:04',
            ),
            203 => 
            array (
                'id' => 204,
                'name' => 'Coffee/2',
                'created_at' => '2025-04-23 18:35:04',
                'updated_at' => '2025-04-23 18:35:04',
            ),
            204 => 
            array (
                'id' => 205,
                'name' => 'Coffee/3',
                'created_at' => '2025-04-23 18:35:04',
                'updated_at' => '2025-04-23 18:35:04',
            ),
            205 => 
            array (
                'id' => 206,
                'name' => 'Black/31',
                'created_at' => '2025-04-23 18:39:20',
                'updated_at' => '2025-04-23 18:39:20',
            ),
            206 => 
            array (
                'id' => 207,
                'name' => 'Black/33',
                'created_at' => '2025-04-23 18:39:20',
                'updated_at' => '2025-04-23 18:39:20',
            ),
            207 => 
            array (
                'id' => 208,
                'name' => 'Chocolate/38',
                'created_at' => '2025-04-23 18:47:01',
                'updated_at' => '2025-04-23 18:47:01',
            ),
            208 => 
            array (
                'id' => 209,
                'name' => 'Master/6',
                'created_at' => '2025-04-23 18:55:47',
                'updated_at' => '2025-04-23 18:55:47',
            ),
            209 => 
            array (
                'id' => 210,
                'name' => 'Master/7',
                'created_at' => '2025-04-23 18:55:47',
                'updated_at' => '2025-04-23 18:55:47',
            ),
            210 => 
            array (
                'id' => 211,
                'name' => 'Master/8',
                'created_at' => '2025-04-23 18:55:47',
                'updated_at' => '2025-04-23 18:55:47',
            ),
            211 => 
            array (
                'id' => 212,
                'name' => 'Black/32',
                'created_at' => '2025-04-23 19:22:16',
                'updated_at' => '2025-04-23 19:22:16',
            ),
            212 => 
            array (
                'id' => 213,
                'name' => 'Coffee/31',
                'created_at' => '2025-04-23 19:22:16',
                'updated_at' => '2025-04-23 19:22:16',
            ),
            213 => 
            array (
                'id' => 214,
                'name' => 'Coffee/32',
                'created_at' => '2025-04-23 19:22:16',
                'updated_at' => '2025-04-23 19:22:16',
            ),
            214 => 
            array (
                'id' => 215,
                'name' => 'Master/12',
                'created_at' => '2025-04-23 19:22:16',
                'updated_at' => '2025-04-23 19:22:16',
            ),
            215 => 
            array (
                'id' => 216,
                'name' => 'Cream/3',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            216 => 
            array (
                'id' => 217,
                'name' => 'Cream/4',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            217 => 
            array (
                'id' => 218,
                'name' => 'Cream/13',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            218 => 
            array (
                'id' => 219,
                'name' => 'Cream/30',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            219 => 
            array (
                'id' => 220,
                'name' => 'Cream/31',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            220 => 
            array (
                'id' => 221,
                'name' => 'Cream/32',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            221 => 
            array (
                'id' => 222,
                'name' => 'Cream/33',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            222 => 
            array (
                'id' => 223,
                'name' => 'Cream/34',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            223 => 
            array (
                'id' => 224,
                'name' => 'Pink/2',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            224 => 
            array (
                'id' => 225,
                'name' => 'Pink/3',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            225 => 
            array (
                'id' => 226,
                'name' => 'Pink/4',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            226 => 
            array (
                'id' => 227,
                'name' => 'Pink/30',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            227 => 
            array (
                'id' => 228,
                'name' => 'Pink/31',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            228 => 
            array (
                'id' => 229,
                'name' => 'Pink/32',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            229 => 
            array (
                'id' => 230,
                'name' => 'Pink/33',
                'created_at' => '2025-04-23 19:28:46',
                'updated_at' => '2025-04-23 19:28:46',
            ),
            230 => 
            array (
                'id' => 231,
                'name' => 'Black/29',
                'created_at' => '2025-04-23 19:32:19',
                'updated_at' => '2025-04-23 19:32:19',
            ),
            231 => 
            array (
                'id' => 232,
                'name' => 'Black/30',
                'created_at' => '2025-04-23 19:33:29',
                'updated_at' => '2025-04-23 19:33:29',
            ),
            232 => 
            array (
                'id' => 233,
                'name' => 'Black/34',
                'created_at' => '2025-04-23 19:34:51',
                'updated_at' => '2025-04-23 19:34:51',
            ),
            233 => 
            array (
                'id' => 234,
                'name' => 'Maroon/34',
                'created_at' => '2025-04-23 19:36:14',
                'updated_at' => '2025-04-23 19:36:14',
            ),
            234 => 
            array (
                'id' => 235,
                'name' => 'Coffee/29',
                'created_at' => '2025-04-23 19:38:45',
                'updated_at' => '2025-04-23 19:38:45',
            ),
            235 => 
            array (
                'id' => 236,
                'name' => 'Coffee/30',
                'created_at' => '2025-04-23 19:38:45',
                'updated_at' => '2025-04-23 19:38:45',
            ),
            236 => 
            array (
                'id' => 237,
                'name' => 'Coffee/33',
                'created_at' => '2025-04-23 19:38:45',
                'updated_at' => '2025-04-23 19:38:45',
            ),
            237 => 
            array (
                'id' => 238,
                'name' => 'Coffee/34',
                'created_at' => '2025-04-23 19:38:45',
                'updated_at' => '2025-04-23 19:38:45',
            ),
            238 => 
            array (
                'id' => 239,
                'name' => 'Cream/29',
                'created_at' => '2025-04-23 19:38:45',
                'updated_at' => '2025-04-23 19:38:45',
            ),
            239 => 
            array (
                'id' => 240,
                'name' => 'Coffee/4',
                'created_at' => '2025-04-23 19:51:25',
                'updated_at' => '2025-04-23 19:51:25',
            ),
            240 => 
            array (
                'id' => 241,
                'name' => 'Cream/2',
                'created_at' => '2025-04-23 19:55:13',
                'updated_at' => '2025-04-23 19:55:13',
            ),
            241 => 
            array (
                'id' => 242,
                'name' => 'Pink/1',
                'created_at' => '2025-04-23 19:56:23',
                'updated_at' => '2025-04-23 19:56:23',
            ),
            242 => 
            array (
                'id' => 243,
                'name' => 'Pink/12',
                'created_at' => '2025-04-23 19:56:24',
                'updated_at' => '2025-04-23 19:56:24',
            ),
            243 => 
            array (
                'id' => 244,
                'name' => 'Cream/1',
                'created_at' => '2025-04-23 20:03:22',
                'updated_at' => '2025-04-23 20:03:22',
            ),
            244 => 
            array (
                'id' => 245,
                'name' => 'Cream/5',
                'created_at' => '2025-04-23 20:03:22',
                'updated_at' => '2025-04-23 20:03:22',
            ),
            245 => 
            array (
                'id' => 246,
                'name' => 'Pink/5',
                'created_at' => '2025-04-23 20:03:22',
                'updated_at' => '2025-04-23 20:03:22',
            ),
            246 => 
            array (
                'id' => 247,
                'name' => 'Pink/34',
                'created_at' => '2025-04-23 20:08:20',
                'updated_at' => '2025-04-23 20:08:20',
            ),
            247 => 
            array (
                'id' => 248,
                'name' => 'Golden/30',
                'created_at' => '2025-04-23 20:12:08',
                'updated_at' => '2025-04-23 20:12:08',
            ),
            248 => 
            array (
                'id' => 249,
                'name' => 'Cream/22',
                'created_at' => '2025-04-23 20:20:23',
                'updated_at' => '2025-04-23 20:20:23',
            ),
            249 => 
            array (
                'id' => 250,
                'name' => 'Cream/23',
                'created_at' => '2025-04-23 20:20:23',
                'updated_at' => '2025-04-23 20:20:23',
            ),
            250 => 
            array (
                'id' => 251,
                'name' => 'Cream/24',
                'created_at' => '2025-04-23 20:20:23',
                'updated_at' => '2025-04-23 20:20:23',
            ),
            251 => 
            array (
                'id' => 252,
                'name' => 'Cream/25',
                'created_at' => '2025-04-23 20:20:23',
                'updated_at' => '2025-04-23 20:20:23',
            ),
            252 => 
            array (
                'id' => 253,
                'name' => 'Cream/26',
                'created_at' => '2025-04-23 20:20:23',
                'updated_at' => '2025-04-23 20:20:23',
            ),
            253 => 
            array (
                'id' => 254,
                'name' => 'Pink/22',
                'created_at' => '2025-04-23 20:20:23',
                'updated_at' => '2025-04-23 20:20:23',
            ),
            254 => 
            array (
                'id' => 255,
                'name' => 'Pink/23',
                'created_at' => '2025-04-23 20:20:23',
                'updated_at' => '2025-04-23 20:20:23',
            ),
            255 => 
            array (
                'id' => 256,
                'name' => 'Pink/24',
                'created_at' => '2025-04-23 20:20:23',
                'updated_at' => '2025-04-23 20:20:23',
            ),
            256 => 
            array (
                'id' => 257,
                'name' => 'Pink/25',
                'created_at' => '2025-04-23 20:20:23',
                'updated_at' => '2025-04-23 20:20:23',
            ),
            257 => 
            array (
                'id' => 258,
                'name' => 'Pink/26',
                'created_at' => '2025-04-23 20:20:23',
                'updated_at' => '2025-04-23 20:20:23',
            ),
            258 => 
            array (
                'id' => 259,
                'name' => 'Cream/21',
                'created_at' => '2025-04-23 20:24:28',
                'updated_at' => '2025-04-23 20:24:28',
            ),
            259 => 
            array (
                'id' => 260,
                'name' => 'Pink/21',
                'created_at' => '2025-04-23 20:24:28',
                'updated_at' => '2025-04-23 20:24:28',
            ),
            260 => 
            array (
                'id' => 261,
                'name' => 'Cream/27',
                'created_at' => '2025-04-23 20:44:18',
                'updated_at' => '2025-04-23 20:44:18',
            ),
            261 => 
            array (
                'id' => 262,
                'name' => 'Pink/27',
                'created_at' => '2025-04-23 20:44:18',
                'updated_at' => '2025-04-23 20:44:18',
            ),
            262 => 
            array (
                'id' => 263,
                'name' => 'Cream/28',
                'created_at' => '2025-04-23 21:48:49',
                'updated_at' => '2025-04-23 21:48:49',
            ),
            263 => 
            array (
                'id' => 264,
                'name' => 'Pink/29',
                'created_at' => '2025-04-23 21:48:49',
                'updated_at' => '2025-04-23 21:48:49',
            ),
            264 => 
            array (
                'id' => 265,
                'name' => 'Golden/26',
                'created_at' => '2025-04-23 21:53:11',
                'updated_at' => '2025-04-23 21:53:11',
            ),
            265 => 
            array (
                'id' => 266,
                'name' => 'Golden/27',
                'created_at' => '2025-04-23 21:53:11',
                'updated_at' => '2025-04-23 21:53:11',
            ),
            266 => 
            array (
                'id' => 267,
                'name' => 'Golden/28',
                'created_at' => '2025-04-23 21:53:11',
                'updated_at' => '2025-04-23 21:53:11',
            ),
            267 => 
            array (
                'id' => 268,
                'name' => 'Golden/29',
                'created_at' => '2025-04-23 21:53:11',
                'updated_at' => '2025-04-23 21:53:11',
            ),
            268 => 
            array (
                'id' => 269,
                'name' => 'Silver/26',
                'created_at' => '2025-04-23 21:53:11',
                'updated_at' => '2025-04-23 21:53:11',
            ),
            269 => 
            array (
                'id' => 270,
                'name' => 'Silver/27',
                'created_at' => '2025-04-23 21:53:11',
                'updated_at' => '2025-04-23 21:53:11',
            ),
            270 => 
            array (
                'id' => 271,
                'name' => 'Silver/28',
                'created_at' => '2025-04-23 21:53:11',
                'updated_at' => '2025-04-23 21:53:11',
            ),
            271 => 
            array (
                'id' => 272,
                'name' => 'Silver/29',
                'created_at' => '2025-04-23 21:53:11',
                'updated_at' => '2025-04-23 21:53:11',
            ),
            272 => 
            array (
                'id' => 273,
                'name' => 'Silver/30',
                'created_at' => '2025-04-23 21:53:11',
                'updated_at' => '2025-04-23 21:53:11',
            ),
            273 => 
            array (
                'id' => 274,
                'name' => 'Black/0',
                'created_at' => '2025-04-23 22:16:20',
                'updated_at' => '2025-04-23 22:16:20',
            ),
            274 => 
            array (
                'id' => 275,
                'name' => 'Cream/0',
                'created_at' => '2025-04-23 22:16:20',
                'updated_at' => '2025-04-23 22:16:20',
            ),
            275 => 
            array (
                'id' => 276,
                'name' => 'Maroon/0',
                'created_at' => '2025-04-23 22:16:20',
                'updated_at' => '2025-04-23 22:16:20',
            ),
            276 => 
            array (
                'id' => 277,
                'name' => 'Pink/0',
                'created_at' => '2025-04-23 22:16:20',
                'updated_at' => '2025-04-23 22:16:20',
            ),
            277 => 
            array (
                'id' => 278,
                'name' => 'White/0',
                'created_at' => '2025-04-23 22:18:52',
                'updated_at' => '2025-04-23 22:18:52',
            ),
            278 => 
            array (
                'id' => 279,
                'name' => 'Pink/28',
                'created_at' => '2025-04-23 22:24:06',
                'updated_at' => '2025-04-23 22:24:06',
            ),
            279 => 
            array (
                'id' => 280,
                'name' => 'Golden/32',
                'created_at' => '2025-04-23 22:32:09',
                'updated_at' => '2025-04-23 22:32:09',
            ),
            280 => 
            array (
                'id' => 281,
                'name' => 'Golden/33',
                'created_at' => '2025-04-23 22:32:09',
                'updated_at' => '2025-04-23 22:32:09',
            ),
            281 => 
            array (
                'id' => 282,
                'name' => 'Golden/34',
                'created_at' => '2025-04-23 22:32:09',
                'updated_at' => '2025-04-23 22:32:09',
            ),
            282 => 
            array (
                'id' => 283,
                'name' => 'Silver/31',
                'created_at' => '2025-04-23 22:32:09',
                'updated_at' => '2025-04-23 22:32:09',
            ),
            283 => 
            array (
                'id' => 284,
                'name' => 'Silver/32',
                'created_at' => '2025-04-23 22:32:09',
                'updated_at' => '2025-04-23 22:32:09',
            ),
            284 => 
            array (
                'id' => 285,
                'name' => 'Silver/33',
                'created_at' => '2025-04-23 22:32:09',
                'updated_at' => '2025-04-23 22:32:09',
            ),
            285 => 
            array (
                'id' => 286,
                'name' => 'Silver/34',
                'created_at' => '2025-04-23 22:32:09',
                'updated_at' => '2025-04-23 22:32:09',
            ),
            286 => 
            array (
                'id' => 287,
                'name' => 'Black/27',
                'created_at' => '2025-04-23 23:23:26',
                'updated_at' => '2025-04-23 23:23:26',
            ),
            287 => 
            array (
                'id' => 288,
                'name' => 'Black/28',
                'created_at' => '2025-04-23 23:23:26',
                'updated_at' => '2025-04-23 23:23:26',
            ),
            288 => 
            array (
                'id' => 289,
                'name' => 'White/28',
                'created_at' => '2025-04-23 23:26:20',
                'updated_at' => '2025-04-23 23:26:20',
            ),
            289 => 
            array (
                'id' => 290,
                'name' => 'White/29',
                'created_at' => '2025-04-23 23:26:20',
                'updated_at' => '2025-04-23 23:26:20',
            ),
            290 => 
            array (
                'id' => 291,
                'name' => 'White/30',
                'created_at' => '2025-04-23 23:26:20',
                'updated_at' => '2025-04-23 23:26:20',
            ),
            291 => 
            array (
                'id' => 292,
                'name' => 'Blue/28',
                'created_at' => '2025-04-23 23:31:51',
                'updated_at' => '2025-04-23 23:31:51',
            ),
            292 => 
            array (
                'id' => 293,
                'name' => 'Blue/29',
                'created_at' => '2025-04-23 23:31:51',
                'updated_at' => '2025-04-23 23:31:51',
            ),
            293 => 
            array (
                'id' => 294,
                'name' => 'Blue/30',
                'created_at' => '2025-04-23 23:31:51',
                'updated_at' => '2025-04-23 23:31:51',
            ),
            294 => 
            array (
                'id' => 295,
                'name' => 'Gray/33',
                'created_at' => '2025-04-23 23:33:32',
                'updated_at' => '2025-04-23 23:33:32',
            ),
            295 => 
            array (
                'id' => 296,
                'name' => 'Gray/34',
                'created_at' => '2025-04-23 23:33:32',
                'updated_at' => '2025-04-23 23:33:32',
            ),
            296 => 
            array (
                'id' => 297,
                'name' => 'Gray/35',
                'created_at' => '2025-04-23 23:33:32',
                'updated_at' => '2025-04-23 23:33:32',
            ),
            297 => 
            array (
                'id' => 298,
                'name' => 'Gray/36',
                'created_at' => '2025-04-23 23:33:32',
                'updated_at' => '2025-04-23 23:33:32',
            ),
            298 => 
            array (
                'id' => 299,
                'name' => 'Blue/33',
                'created_at' => '2025-04-23 23:38:02',
                'updated_at' => '2025-04-23 23:38:02',
            ),
            299 => 
            array (
                'id' => 300,
                'name' => 'Blue/34',
                'created_at' => '2025-04-23 23:38:02',
                'updated_at' => '2025-04-23 23:38:02',
            ),
            300 => 
            array (
                'id' => 301,
                'name' => 'Blue/35',
                'created_at' => '2025-04-23 23:38:02',
                'updated_at' => '2025-04-23 23:38:02',
            ),
            301 => 
            array (
                'id' => 302,
                'name' => 'Chocolate/22',
                'created_at' => '2025-04-23 23:40:53',
                'updated_at' => '2025-04-23 23:40:53',
            ),
            302 => 
            array (
                'id' => 303,
                'name' => 'Chocolate/27',
                'created_at' => '2025-04-23 23:40:53',
                'updated_at' => '2025-04-23 23:40:53',
            ),
            303 => 
            array (
                'id' => 304,
                'name' => 'Chocolate/28',
                'created_at' => '2025-04-23 23:40:53',
                'updated_at' => '2025-04-23 23:40:53',
            ),
            304 => 
            array (
                'id' => 305,
                'name' => 'Chocolate/31',
                'created_at' => '2025-04-23 23:40:53',
                'updated_at' => '2025-04-23 23:40:53',
            ),
            305 => 
            array (
                'id' => 306,
                'name' => 'Gray/31',
                'created_at' => '2025-04-23 23:43:52',
                'updated_at' => '2025-04-23 23:43:52',
            ),
            306 => 
            array (
                'id' => 307,
                'name' => 'Gray/26',
                'created_at' => '2025-04-23 23:45:46',
                'updated_at' => '2025-04-23 23:45:46',
            ),
            307 => 
            array (
                'id' => 308,
                'name' => 'Gray/27',
                'created_at' => '2025-04-23 23:45:46',
                'updated_at' => '2025-04-23 23:45:46',
            ),
            308 => 
            array (
                'id' => 309,
                'name' => 'Gray/28',
                'created_at' => '2025-04-23 23:45:46',
                'updated_at' => '2025-04-23 23:45:46',
            ),
            309 => 
            array (
                'id' => 310,
                'name' => 'Gray/29',
                'created_at' => '2025-04-23 23:45:46',
                'updated_at' => '2025-04-23 23:45:46',
            ),
            310 => 
            array (
                'id' => 311,
                'name' => 'Master/28',
                'created_at' => '2025-04-23 23:50:08',
                'updated_at' => '2025-04-23 23:50:08',
            ),
            311 => 
            array (
                'id' => 312,
                'name' => 'Master/29',
                'created_at' => '2025-04-23 23:50:08',
                'updated_at' => '2025-04-23 23:50:08',
            ),
            312 => 
            array (
                'id' => 313,
                'name' => 'Master/31',
                'created_at' => '2025-04-23 23:50:08',
                'updated_at' => '2025-04-23 23:50:08',
            ),
            313 => 
            array (
                'id' => 314,
                'name' => 'Master/32',
                'created_at' => '2025-04-23 23:50:08',
                'updated_at' => '2025-04-23 23:50:08',
            ),
            314 => 
            array (
                'id' => 315,
                'name' => 'Black/26',
                'created_at' => '2025-04-23 23:52:48',
                'updated_at' => '2025-04-23 23:52:48',
            ),
            315 => 
            array (
                'id' => 316,
                'name' => 'Master/26',
                'created_at' => '2025-04-23 23:52:48',
                'updated_at' => '2025-04-23 23:52:48',
            ),
            316 => 
            array (
                'id' => 317,
                'name' => 'Black/21',
                'created_at' => '2025-04-23 23:55:49',
                'updated_at' => '2025-04-23 23:55:49',
            ),
            317 => 
            array (
                'id' => 318,
                'name' => 'Black/22',
                'created_at' => '2025-04-23 23:55:49',
                'updated_at' => '2025-04-23 23:55:49',
            ),
            318 => 
            array (
                'id' => 319,
                'name' => 'Black/23',
                'created_at' => '2025-04-23 23:55:49',
                'updated_at' => '2025-04-23 23:55:49',
            ),
            319 => 
            array (
                'id' => 320,
                'name' => 'Black/25',
                'created_at' => '2025-04-23 23:55:49',
                'updated_at' => '2025-04-23 23:55:49',
            ),
            320 => 
            array (
                'id' => 321,
                'name' => 'Master/21',
                'created_at' => '2025-04-23 23:55:49',
                'updated_at' => '2025-04-23 23:55:49',
            ),
            321 => 
            array (
                'id' => 322,
                'name' => 'Master/22',
                'created_at' => '2025-04-23 23:55:49',
                'updated_at' => '2025-04-23 23:55:49',
            ),
            322 => 
            array (
                'id' => 323,
                'name' => 'Master/23',
                'created_at' => '2025-04-23 23:55:49',
                'updated_at' => '2025-04-23 23:55:49',
            ),
            323 => 
            array (
                'id' => 324,
                'name' => 'Master/24',
                'created_at' => '2025-04-23 23:55:49',
                'updated_at' => '2025-04-23 23:55:49',
            ),
            324 => 
            array (
                'id' => 325,
                'name' => 'Master/25',
                'created_at' => '2025-04-23 23:55:49',
                'updated_at' => '2025-04-23 23:55:49',
            ),
            325 => 
            array (
                'id' => 326,
                'name' => 'Master/27',
                'created_at' => '2025-04-24 00:04:54',
                'updated_at' => '2025-04-24 00:04:54',
            ),
            326 => 
            array (
                'id' => 327,
                'name' => 'Master/30',
                'created_at' => '2025-04-24 00:04:54',
                'updated_at' => '2025-04-24 00:04:54',
            ),
            327 => 
            array (
                'id' => 328,
                'name' => 'Black/24',
                'created_at' => '2025-04-24 00:25:53',
                'updated_at' => '2025-04-24 00:25:53',
            ),
            328 => 
            array (
                'id' => 329,
                'name' => 'Chocolate/34',
                'created_at' => '2025-04-24 00:42:23',
                'updated_at' => '2025-04-24 00:42:23',
            ),
            329 => 
            array (
                'id' => 330,
                'name' => 'Blue/23',
                'created_at' => '2025-04-24 00:48:27',
                'updated_at' => '2025-04-24 00:48:27',
            ),
            330 => 
            array (
                'id' => 331,
                'name' => 'Blue/25',
                'created_at' => '2025-04-24 00:48:28',
                'updated_at' => '2025-04-24 00:48:28',
            ),
            331 => 
            array (
                'id' => 332,
                'name' => 'Gray/19',
                'created_at' => '2025-04-24 00:51:26',
                'updated_at' => '2025-04-24 00:51:26',
            ),
            332 => 
            array (
                'id' => 333,
                'name' => 'Gray/20',
                'created_at' => '2025-04-24 00:51:26',
                'updated_at' => '2025-04-24 00:51:26',
            ),
            333 => 
            array (
                'id' => 334,
                'name' => 'Gray/21',
                'created_at' => '2025-04-24 00:51:26',
                'updated_at' => '2025-04-24 00:51:26',
            ),
            334 => 
            array (
                'id' => 335,
                'name' => 'Black/20',
                'created_at' => '2025-04-24 00:52:51',
                'updated_at' => '2025-04-24 00:52:51',
            ),
            335 => 
            array (
                'id' => 336,
                'name' => 'Blue/37',
                'created_at' => '2025-04-24 00:55:34',
                'updated_at' => '2025-04-24 00:55:34',
            ),
            336 => 
            array (
                'id' => 337,
                'name' => 'Blue/38',
                'created_at' => '2025-04-24 00:55:34',
                'updated_at' => '2025-04-24 00:55:34',
            ),
            337 => 
            array (
                'id' => 338,
                'name' => 'Green/38',
                'created_at' => '2025-04-24 00:55:34',
                'updated_at' => '2025-04-24 00:55:34',
            ),
            338 => 
            array (
                'id' => 339,
                'name' => 'Chocolate/25',
                'created_at' => '2025-04-24 01:09:02',
                'updated_at' => '2025-04-24 01:09:02',
            ),
            339 => 
            array (
                'id' => 340,
                'name' => 'Blue/19',
                'created_at' => '2025-04-24 01:12:02',
                'updated_at' => '2025-04-24 01:12:02',
            ),
            340 => 
            array (
                'id' => 341,
                'name' => 'Blue/20',
                'created_at' => '2025-04-24 01:12:02',
                'updated_at' => '2025-04-24 01:12:02',
            ),
            341 => 
            array (
                'id' => 342,
                'name' => 'Blue/22',
                'created_at' => '2025-04-24 01:12:02',
                'updated_at' => '2025-04-24 01:12:02',
            ),
            342 => 
            array (
                'id' => 343,
                'name' => 'Gray/39',
                'created_at' => '2025-04-24 01:34:07',
                'updated_at' => '2025-04-24 01:34:07',
            ),
            343 => 
            array (
                'id' => 344,
                'name' => 'Green/37',
                'created_at' => '2025-04-24 01:34:07',
                'updated_at' => '2025-04-24 01:34:07',
            ),
            344 => 
            array (
                'id' => 345,
                'name' => 'Green/39',
                'created_at' => '2025-04-24 01:34:07',
                'updated_at' => '2025-04-24 01:34:07',
            ),
            345 => 
            array (
                'id' => 346,
                'name' => 'Olive/35',
                'created_at' => '2025-04-24 01:34:07',
                'updated_at' => '2025-04-24 01:34:07',
            ),
            346 => 
            array (
                'id' => 347,
                'name' => 'Olive/36',
                'created_at' => '2025-04-24 01:34:07',
                'updated_at' => '2025-04-24 01:34:07',
            ),
            347 => 
            array (
                'id' => 348,
                'name' => 'Olive/37',
                'created_at' => '2025-04-24 01:34:07',
                'updated_at' => '2025-04-24 01:34:07',
            ),
            348 => 
            array (
                'id' => 349,
                'name' => 'Olive/38',
                'created_at' => '2025-04-24 01:34:07',
                'updated_at' => '2025-04-24 01:34:07',
            ),
            349 => 
            array (
                'id' => 350,
                'name' => 'Olive/39',
                'created_at' => '2025-04-24 01:34:07',
                'updated_at' => '2025-04-24 01:34:07',
            ),
            350 => 
            array (
                'id' => 351,
                'name' => 'Green/35',
                'created_at' => '2025-04-24 01:37:08',
                'updated_at' => '2025-04-24 01:37:08',
            ),
            351 => 
            array (
                'id' => 352,
                'name' => 'Green/36',
                'created_at' => '2025-04-24 01:37:08',
                'updated_at' => '2025-04-24 01:37:08',
            ),
            352 => 
            array (
                'id' => 353,
                'name' => 'Gray/18',
                'created_at' => '2025-04-24 01:53:03',
                'updated_at' => '2025-04-24 01:53:03',
            ),
            353 => 
            array (
                'id' => 354,
                'name' => 'Olive/18',
                'created_at' => '2025-04-24 01:53:03',
                'updated_at' => '2025-04-24 01:53:03',
            ),
            354 => 
            array (
                'id' => 355,
                'name' => 'Olive/19',
                'created_at' => '2025-04-24 01:53:03',
                'updated_at' => '2025-04-24 01:53:03',
            ),
            355 => 
            array (
                'id' => 356,
                'name' => 'Olive/20',
                'created_at' => '2025-04-24 01:53:03',
                'updated_at' => '2025-04-24 01:53:03',
            ),
            356 => 
            array (
                'id' => 357,
                'name' => 'Olive/21',
                'created_at' => '2025-04-24 01:53:03',
                'updated_at' => '2025-04-24 01:53:03',
            ),
            357 => 
            array (
                'id' => 358,
                'name' => 'Gray/23',
                'created_at' => '2025-04-24 02:06:07',
                'updated_at' => '2025-04-24 02:06:07',
            ),
            358 => 
            array (
                'id' => 359,
                'name' => 'Blue/31',
                'created_at' => '2025-04-24 02:12:28',
                'updated_at' => '2025-04-24 02:12:28',
            ),
            359 => 
            array (
                'id' => 360,
                'name' => 'Gray/22',
                'created_at' => '2025-04-24 02:17:01',
                'updated_at' => '2025-04-24 02:17:01',
            ),
            360 => 
            array (
                'id' => 361,
                'name' => 'Gray/24',
                'created_at' => '2025-04-24 02:17:01',
                'updated_at' => '2025-04-24 02:17:01',
            ),
            361 => 
            array (
                'id' => 362,
                'name' => 'Green/20',
                'created_at' => '2025-04-24 02:17:01',
                'updated_at' => '2025-04-24 02:17:01',
            ),
            362 => 
            array (
                'id' => 363,
                'name' => 'Green/23',
                'created_at' => '2025-04-24 02:17:01',
                'updated_at' => '2025-04-24 02:17:01',
            ),
            363 => 
            array (
                'id' => 364,
                'name' => 'Green/24',
                'created_at' => '2025-04-24 02:17:01',
                'updated_at' => '2025-04-24 02:17:01',
            ),
            364 => 
            array (
                'id' => 365,
                'name' => 'Green/21',
                'created_at' => '2025-04-24 02:20:01',
                'updated_at' => '2025-04-24 02:20:01',
            ),
            365 => 
            array (
                'id' => 366,
                'name' => 'Green/22',
                'created_at' => '2025-04-24 02:20:01',
                'updated_at' => '2025-04-24 02:20:01',
            ),
            366 => 
            array (
                'id' => 367,
                'name' => 'White/26',
                'created_at' => '2025-04-24 02:25:52',
                'updated_at' => '2025-04-24 02:25:52',
            ),
            367 => 
            array (
                'id' => 368,
                'name' => 'White/27',
                'created_at' => '2025-04-24 02:25:52',
                'updated_at' => '2025-04-24 02:25:52',
            ),
            368 => 
            array (
                'id' => 369,
                'name' => 'White/31',
                'created_at' => '2025-04-24 02:26:59',
                'updated_at' => '2025-04-24 02:26:59',
            ),
            369 => 
            array (
                'id' => 370,
                'name' => 'White/21',
                'created_at' => '2025-04-24 02:38:52',
                'updated_at' => '2025-04-24 02:38:52',
            ),
            370 => 
            array (
                'id' => 371,
                'name' => 'White/23',
                'created_at' => '2025-04-24 02:38:52',
                'updated_at' => '2025-04-24 02:38:52',
            ),
            371 => 
            array (
                'id' => 372,
                'name' => 'Blue/24',
                'created_at' => '2025-04-24 03:03:56',
                'updated_at' => '2025-04-24 03:03:56',
            ),
            372 => 
            array (
                'id' => 373,
                'name' => 'Blue/26',
                'created_at' => '2025-04-24 03:03:56',
                'updated_at' => '2025-04-24 03:03:56',
            ),
            373 => 
            array (
                'id' => 374,
                'name' => 'White/22',
                'created_at' => '2025-04-24 03:08:45',
                'updated_at' => '2025-04-24 03:08:45',
            ),
            374 => 
            array (
                'id' => 375,
                'name' => 'Coffee/25',
                'created_at' => '2025-04-24 03:15:54',
                'updated_at' => '2025-04-24 03:15:54',
            ),
            375 => 
            array (
                'id' => 376,
                'name' => 'Purple/37',
                'created_at' => '2025-04-24 03:32:22',
                'updated_at' => '2025-04-24 03:32:22',
            ),
            376 => 
            array (
                'id' => 377,
                'name' => 'Cream/',
                'created_at' => '2025-04-24 03:42:38',
                'updated_at' => '2025-04-24 03:42:38',
            ),
            377 => 
            array (
                'id' => 378,
                'name' => 'White/24',
                'created_at' => '2025-04-24 03:45:17',
                'updated_at' => '2025-04-24 03:45:17',
            ),
            378 => 
            array (
                'id' => 379,
                'name' => 'Maroon/24',
                'created_at' => '2025-04-24 04:03:12',
                'updated_at' => '2025-04-24 04:03:12',
            ),
            379 => 
            array (
                'id' => 380,
                'name' => 'Maroon/25',
                'created_at' => '2025-04-24 04:03:12',
                'updated_at' => '2025-04-24 04:03:12',
            ),
            380 => 
            array (
                'id' => 381,
                'name' => 'Maroon/26',
                'created_at' => '2025-04-24 04:03:12',
                'updated_at' => '2025-04-24 04:03:12',
            ),
            381 => 
            array (
                'id' => 382,
                'name' => 'Maroon/28',
                'created_at' => '2025-04-24 04:03:12',
                'updated_at' => '2025-04-24 04:03:12',
            ),
            382 => 
            array (
                'id' => 383,
                'name' => 'Blue/27',
                'created_at' => '2025-04-24 04:05:14',
                'updated_at' => '2025-04-24 04:05:14',
            ),
            383 => 
            array (
                'id' => 384,
                'name' => 'Maroon/27',
                'created_at' => '2025-04-24 04:05:14',
                'updated_at' => '2025-04-24 04:05:14',
            ),
            384 => 
            array (
                'id' => 385,
                'name' => 'Blue/39',
                'created_at' => '2025-04-24 04:16:24',
                'updated_at' => '2025-04-24 04:16:24',
            ),
            385 => 
            array (
                'id' => 386,
                'name' => 'Blue/40',
                'created_at' => '2025-04-24 04:16:24',
                'updated_at' => '2025-04-24 04:16:24',
            ),
            386 => 
            array (
                'id' => 387,
                'name' => 'Gray/44',
                'created_at' => '2025-04-24 17:29:06',
                'updated_at' => '2025-04-24 17:29:06',
            ),
            387 => 
            array (
                'id' => 388,
                'name' => 'RED/41',
                'created_at' => '2025-04-24 17:43:16',
                'updated_at' => '2025-04-24 17:43:16',
            ),
            388 => 
            array (
                'id' => 389,
                'name' => 'RED/43',
                'created_at' => '2025-04-24 17:43:16',
                'updated_at' => '2025-04-24 17:43:16',
            ),
            389 => 
            array (
                'id' => 390,
                'name' => 'RED/44',
                'created_at' => '2025-04-24 17:43:16',
                'updated_at' => '2025-04-24 17:43:16',
            ),
            390 => 
            array (
                'id' => 391,
                'name' => 'Cream/42',
                'created_at' => '2025-04-24 18:25:27',
                'updated_at' => '2025-04-24 18:25:27',
            ),
            391 => 
            array (
                'id' => 392,
                'name' => 'Cream/43',
                'created_at' => '2025-04-24 18:25:27',
                'updated_at' => '2025-04-24 18:25:27',
            ),
            392 => 
            array (
                'id' => 393,
                'name' => 'Olive/40',
                'created_at' => '2025-04-24 18:29:38',
                'updated_at' => '2025-04-24 18:29:38',
            ),
            393 => 
            array (
                'id' => 394,
                'name' => 'Olive/41',
                'created_at' => '2025-04-24 18:29:38',
                'updated_at' => '2025-04-24 18:29:38',
            ),
            394 => 
            array (
                'id' => 395,
                'name' => 'Olive/44',
                'created_at' => '2025-04-24 18:29:38',
                'updated_at' => '2025-04-24 18:29:38',
            ),
            395 => 
            array (
                'id' => 396,
                'name' => 'Brown/39',
                'created_at' => '2025-04-24 18:40:00',
                'updated_at' => '2025-04-24 18:40:00',
            ),
            396 => 
            array (
                'id' => 397,
                'name' => 'Brown/41',
                'created_at' => '2025-04-24 18:40:00',
                'updated_at' => '2025-04-24 18:40:00',
            ),
            397 => 
            array (
                'id' => 398,
                'name' => 'Brown/42',
                'created_at' => '2025-04-24 18:40:00',
                'updated_at' => '2025-04-24 18:40:00',
            ),
            398 => 
            array (
                'id' => 399,
                'name' => 'Brown/43',
                'created_at' => '2025-04-24 18:40:00',
                'updated_at' => '2025-04-24 18:40:00',
            ),
            399 => 
            array (
                'id' => 400,
                'name' => 'Olive/43',
                'created_at' => '2025-04-24 18:40:00',
                'updated_at' => '2025-04-24 18:40:00',
            ),
            400 => 
            array (
                'id' => 401,
                'name' => 'RED/42',
                'created_at' => '2025-04-24 18:40:00',
                'updated_at' => '2025-04-24 18:40:00',
            ),
            401 => 
            array (
                'id' => 402,
                'name' => 'Navy/36',
                'created_at' => '2025-04-24 18:53:24',
                'updated_at' => '2025-04-24 18:53:24',
            ),
            402 => 
            array (
                'id' => 403,
                'name' => 'Navy/37',
                'created_at' => '2025-04-24 18:53:24',
                'updated_at' => '2025-04-24 18:53:24',
            ),
            403 => 
            array (
                'id' => 404,
                'name' => 'Navy/38',
                'created_at' => '2025-04-24 18:53:24',
                'updated_at' => '2025-04-24 18:53:24',
            ),
            404 => 
            array (
                'id' => 405,
                'name' => 'Navy/39',
                'created_at' => '2025-04-24 18:53:24',
                'updated_at' => '2025-04-24 18:53:24',
            ),
            405 => 
            array (
                'id' => 406,
                'name' => 'Navy/40',
                'created_at' => '2025-04-24 18:53:24',
                'updated_at' => '2025-04-24 18:53:24',
            ),
            406 => 
            array (
                'id' => 407,
                'name' => 'Navy/41',
                'created_at' => '2025-04-24 19:28:14',
                'updated_at' => '2025-04-24 19:28:14',
            ),
            407 => 
            array (
                'id' => 408,
                'name' => 'Brown/40',
                'created_at' => '2025-04-24 19:58:46',
                'updated_at' => '2025-04-24 19:58:46',
            ),
            408 => 
            array (
                'id' => 409,
                'name' => 'Green/41',
                'created_at' => '2025-04-24 20:06:58',
                'updated_at' => '2025-04-24 20:06:58',
            ),
            409 => 
            array (
                'id' => 410,
                'name' => 'Olive/8',
                'created_at' => '2025-04-24 21:09:54',
                'updated_at' => '2025-04-24 21:09:54',
            ),
            410 => 
            array (
                'id' => 411,
                'name' => 'Brown/44',
                'created_at' => '2025-04-24 21:46:43',
                'updated_at' => '2025-04-24 21:46:43',
            ),
            411 => 
            array (
                'id' => 412,
                'name' => 'Chocolate/35',
                'created_at' => '2025-04-24 22:49:37',
                'updated_at' => '2025-04-24 22:49:37',
            ),
            412 => 
            array (
                'id' => 413,
                'name' => 'Chocolate/30',
                'created_at' => '2025-04-24 23:06:15',
                'updated_at' => '2025-04-24 23:06:15',
            ),
            413 => 
            array (
                'id' => 414,
                'name' => 'Chocolate/32',
                'created_at' => '2025-04-24 23:06:15',
                'updated_at' => '2025-04-24 23:06:15',
            ),
            414 => 
            array (
                'id' => 415,
                'name' => 'Gray/2',
                'created_at' => '2025-04-24 23:15:17',
                'updated_at' => '2025-04-24 23:15:17',
            ),
            415 => 
            array (
                'id' => 416,
                'name' => 'White/25',
                'created_at' => '2025-04-24 23:29:16',
                'updated_at' => '2025-04-24 23:29:16',
            ),
            416 => 
            array (
                'id' => 417,
                'name' => 'Gray/6',
                'created_at' => '2025-04-24 23:40:14',
                'updated_at' => '2025-04-24 23:40:14',
            ),
            417 => 
            array (
                'id' => 418,
                'name' => 'Gray/8',
                'created_at' => '2025-04-24 23:40:14',
                'updated_at' => '2025-04-24 23:40:14',
            ),
            418 => 
            array (
                'id' => 419,
                'name' => 'Master/5',
                'created_at' => '2025-04-25 04:41:00',
                'updated_at' => '2025-04-25 04:41:00',
            ),
            419 => 
            array (
                'id' => 420,
                'name' => 'Coffee/',
                'created_at' => '2025-04-25 05:00:02',
                'updated_at' => '2025-04-25 05:00:02',
            ),
            420 => 
            array (
                'id' => 421,
                'name' => 'Pink/',
                'created_at' => '2025-04-25 05:00:02',
                'updated_at' => '2025-04-25 05:00:02',
            ),
            421 => 
            array (
                'id' => 422,
                'name' => 'Chocolate/0',
                'created_at' => '2025-04-25 22:49:34',
                'updated_at' => '2025-04-25 22:49:34',
            ),
            422 => 
            array (
                'id' => 423,
                'name' => 'White/32',
                'created_at' => '2025-04-26 00:27:16',
                'updated_at' => '2025-04-26 00:27:16',
            ),
            423 => 
            array (
                'id' => 424,
                'name' => 'White/33',
                'created_at' => '2025-04-26 00:27:16',
                'updated_at' => '2025-04-26 00:27:16',
            ),
            424 => 
            array (
                'id' => 425,
                'name' => 'White/34',
                'created_at' => '2025-04-26 00:27:16',
                'updated_at' => '2025-04-26 00:27:16',
            ),
            425 => 
            array (
                'id' => 426,
                'name' => 'Gray/',
                'created_at' => '2025-04-26 00:42:53',
                'updated_at' => '2025-04-26 00:42:53',
            ),
            426 => 
            array (
                'id' => 427,
                'name' => 'Golden/9',
                'created_at' => '2025-04-26 00:54:34',
                'updated_at' => '2025-04-26 00:54:34',
            ),
            427 => 
            array (
                'id' => 428,
                'name' => 'Olive/23',
                'created_at' => '2025-04-26 01:26:26',
                'updated_at' => '2025-04-26 01:26:26',
            ),
            428 => 
            array (
                'id' => 429,
                'name' => 'Biscuit/10',
                'created_at' => '2025-04-26 06:23:43',
                'updated_at' => '2025-04-26 06:23:43',
            ),
            429 => 
            array (
                'id' => 430,
                'name' => 'Biscuit/11',
                'created_at' => '2025-04-26 06:23:43',
                'updated_at' => '2025-04-26 06:23:43',
            ),
            430 => 
            array (
                'id' => 431,
                'name' => 'Gray/32',
                'created_at' => '2025-05-24 16:59:56',
                'updated_at' => '2025-05-24 16:59:56',
            ),
            431 => 
            array (
                'id' => 432,
                'name' => 'Gray/30',
                'created_at' => '2025-05-24 16:59:56',
                'updated_at' => '2025-05-24 16:59:56',
            ),
            432 => 
            array (
                'id' => 433,
                'name' => 'Blue/32',
                'created_at' => '2025-05-24 17:18:16',
                'updated_at' => '2025-05-24 17:18:16',
            ),
            433 => 
            array (
                'id' => 434,
                'name' => 'Blue/6',
                'created_at' => '2025-05-24 17:54:23',
                'updated_at' => '2025-05-24 17:54:23',
            ),
            434 => 
            array (
                'id' => 435,
                'name' => 'Blue/7',
                'created_at' => '2025-05-24 17:54:23',
                'updated_at' => '2025-05-24 17:54:23',
            ),
            435 => 
            array (
                'id' => 436,
                'name' => 'Blue/8',
                'created_at' => '2025-05-24 17:54:23',
                'updated_at' => '2025-05-24 17:54:23',
            ),
            436 => 
            array (
                'id' => 437,
                'name' => 'Blue/9',
                'created_at' => '2025-05-24 17:54:23',
                'updated_at' => '2025-05-24 17:54:23',
            ),
            437 => 
            array (
                'id' => 438,
                'name' => 'Blue/10',
                'created_at' => '2025-05-24 17:54:23',
                'updated_at' => '2025-05-24 17:54:23',
            ),
            438 => 
            array (
                'id' => 439,
                'name' => 'Master/9',
                'created_at' => '2025-05-24 18:04:15',
                'updated_at' => '2025-05-24 18:04:15',
            ),
            439 => 
            array (
                'id' => 440,
                'name' => 'Master/10',
                'created_at' => '2025-05-24 18:04:15',
                'updated_at' => '2025-05-24 18:04:15',
            ),
            440 => 
            array (
                'id' => 441,
                'name' => 'Chocolate/5',
                'created_at' => '2025-05-24 18:09:56',
                'updated_at' => '2025-05-24 18:09:56',
            ),
            441 => 
            array (
                'id' => 442,
                'name' => 'Brown/36',
                'created_at' => '2025-05-28 21:03:34',
                'updated_at' => '2025-05-28 21:03:34',
            ),
            442 => 
            array (
                'id' => 443,
                'name' => 'Brown/37',
                'created_at' => '2025-05-28 21:03:34',
                'updated_at' => '2025-05-28 21:03:34',
            ),
            443 => 
            array (
                'id' => 444,
                'name' => 'Brown/38',
                'created_at' => '2025-05-28 21:03:34',
                'updated_at' => '2025-05-28 21:03:34',
            ),
            444 => 
            array (
                'id' => 445,
                'name' => 'Brown/35',
                'created_at' => '2025-05-28 21:03:34',
                'updated_at' => '2025-05-28 21:03:34',
            ),
            445 => 
            array (
                'id' => 446,
                'name' => 'Gray/7',
                'created_at' => '2025-05-29 02:43:14',
                'updated_at' => '2025-05-29 02:43:14',
            ),
            446 => 
            array (
                'id' => 447,
                'name' => 'Gray/10',
                'created_at' => '2025-05-29 02:43:14',
                'updated_at' => '2025-05-29 02:43:14',
            ),
            447 => 
            array (
                'id' => 448,
                'name' => 'White/45',
                'created_at' => '2025-05-31 16:32:03',
                'updated_at' => '2025-05-31 16:32:03',
            ),
            448 => 
            array (
                'id' => 449,
                'name' => 'Brown/6',
                'created_at' => '2025-08-09 15:23:28',
                'updated_at' => '2025-08-09 15:23:28',
            ),
            449 => 
            array (
                'id' => 450,
                'name' => 'Brown/7',
                'created_at' => '2025-08-09 15:23:28',
                'updated_at' => '2025-08-09 15:23:28',
            ),
            450 => 
            array (
                'id' => 451,
                'name' => 'Brown/8',
                'created_at' => '2025-08-09 15:23:28',
                'updated_at' => '2025-08-09 15:23:28',
            ),
            451 => 
            array (
                'id' => 452,
                'name' => 'Brown/9',
                'created_at' => '2025-08-09 15:23:28',
                'updated_at' => '2025-08-09 15:23:28',
            ),
            452 => 
            array (
                'id' => 453,
                'name' => 'Brown/10',
                'created_at' => '2025-08-09 15:23:28',
                'updated_at' => '2025-08-09 15:23:28',
            ),
            453 => 
            array (
                'id' => 454,
                'name' => 'RED/37',
                'created_at' => '2025-08-09 15:55:54',
                'updated_at' => '2025-08-09 15:55:54',
            ),
            454 => 
            array (
                'id' => 455,
                'name' => 'Cream/44',
                'created_at' => '2025-08-09 16:35:32',
                'updated_at' => '2025-08-09 16:35:32',
            ),
            455 => 
            array (
                'id' => 456,
                'name' => 'Brown/12',
                'created_at' => '2025-08-10 18:03:23',
                'updated_at' => '2025-08-10 18:03:23',
            ),
            456 => 
            array (
                'id' => 457,
                'name' => 'Brown/13',
                'created_at' => '2025-08-10 18:03:24',
                'updated_at' => '2025-08-10 18:03:24',
            ),
            457 => 
            array (
                'id' => 458,
                'name' => 'Brown/14',
                'created_at' => '2025-08-10 18:03:24',
                'updated_at' => '2025-08-10 18:03:24',
            ),
            458 => 
            array (
                'id' => 459,
                'name' => 'Brown/15',
                'created_at' => '2025-08-10 18:03:24',
                'updated_at' => '2025-08-10 18:03:24',
            ),
            459 => 
            array (
                'id' => 460,
                'name' => 'Sky Blue/36',
                'created_at' => '2025-08-10 18:46:02',
                'updated_at' => '2025-08-10 18:46:02',
            ),
            460 => 
            array (
                'id' => 461,
                'name' => 'Sky Blue/37',
                'created_at' => '2025-08-10 18:46:02',
                'updated_at' => '2025-08-10 18:46:02',
            ),
            461 => 
            array (
                'id' => 462,
                'name' => 'Sky Blue/38',
                'created_at' => '2025-08-10 18:46:02',
                'updated_at' => '2025-08-10 18:46:02',
            ),
            462 => 
            array (
                'id' => 463,
                'name' => 'Sky Blue/39',
                'created_at' => '2025-08-10 18:46:02',
                'updated_at' => '2025-08-10 18:46:02',
            ),
            463 => 
            array (
                'id' => 464,
                'name' => 'Sky Blue/40',
                'created_at' => '2025-08-10 18:46:02',
                'updated_at' => '2025-08-10 18:46:02',
            ),
            464 => 
            array (
                'id' => 465,
                'name' => 'Sky Blue/41',
                'created_at' => '2025-08-10 18:46:02',
                'updated_at' => '2025-08-10 18:46:02',
            ),
            465 => 
            array (
                'id' => 466,
                'name' => 'Sky Blue/35',
                'created_at' => '2025-08-10 18:46:02',
                'updated_at' => '2025-08-10 18:46:02',
            ),
            466 => 
            array (
                'id' => 467,
                'name' => 'Cream/12',
                'created_at' => '2025-08-10 20:02:21',
                'updated_at' => '2025-08-10 20:02:21',
            ),
            467 => 
            array (
                'id' => 468,
                'name' => 'Cream/14',
                'created_at' => '2025-08-10 20:02:21',
                'updated_at' => '2025-08-10 20:02:21',
            ),
            468 => 
            array (
                'id' => 469,
                'name' => 'Cream/15',
                'created_at' => '2025-08-10 20:02:21',
                'updated_at' => '2025-08-10 20:02:21',
            ),
            469 => 
            array (
                'id' => 470,
                'name' => 'Gray/12',
                'created_at' => '2025-08-10 20:02:26',
                'updated_at' => '2025-08-10 20:02:26',
            ),
            470 => 
            array (
                'id' => 471,
                'name' => 'Gray/13',
                'created_at' => '2025-08-10 20:02:26',
                'updated_at' => '2025-08-10 20:02:26',
            ),
            471 => 
            array (
                'id' => 472,
                'name' => 'Gray/14',
                'created_at' => '2025-08-10 20:02:26',
                'updated_at' => '2025-08-10 20:02:26',
            ),
            472 => 
            array (
                'id' => 473,
                'name' => 'Gray/15',
                'created_at' => '2025-08-10 20:02:26',
                'updated_at' => '2025-08-10 20:02:26',
            ),
            473 => 
            array (
                'id' => 474,
                'name' => 'Chocolate/33',
                'created_at' => '2025-08-10 20:26:08',
                'updated_at' => '2025-08-10 20:26:08',
            ),
            474 => 
            array (
                'id' => 475,
                'name' => 'Pink/42',
                'created_at' => '2025-08-10 20:54:35',
                'updated_at' => '2025-08-10 20:54:35',
            ),
            475 => 
            array (
                'id' => 476,
                'name' => 'Pink/43',
                'created_at' => '2025-08-10 20:54:35',
                'updated_at' => '2025-08-10 20:54:35',
            ),
            476 => 
            array (
                'id' => 477,
                'name' => 'Pink/44',
                'created_at' => '2025-08-10 20:54:35',
                'updated_at' => '2025-08-10 20:54:35',
            ),
            477 => 
            array (
                'id' => 478,
                'name' => 'Green/40',
                'created_at' => '2025-10-30 15:20:25',
                'updated_at' => '2025-10-30 15:20:25',
            ),
            478 => 
            array (
                'id' => 479,
                'name' => 'Green/42',
                'created_at' => '2025-10-30 15:20:25',
                'updated_at' => '2025-10-30 15:20:25',
            ),
            479 => 
            array (
                'id' => 480,
                'name' => 'Green/43',
                'created_at' => '2025-10-30 15:20:25',
                'updated_at' => '2025-10-30 15:20:25',
            ),
            480 => 
            array (
                'id' => 481,
                'name' => 'Green/44',
                'created_at' => '2025-10-30 15:20:25',
                'updated_at' => '2025-10-30 15:20:25',
            ),
            481 => 
            array (
                'id' => 482,
                'name' => 'Olive/42',
                'created_at' => '2025-10-30 17:04:50',
                'updated_at' => '2025-10-30 17:04:50',
            ),
            482 => 
            array (
                'id' => 483,
                'name' => 'Navy/42',
                'created_at' => '2025-10-30 17:23:16',
                'updated_at' => '2025-10-30 17:23:16',
            ),
            483 => 
            array (
                'id' => 484,
                'name' => 'Navy/43',
                'created_at' => '2025-10-30 17:23:16',
                'updated_at' => '2025-10-30 17:23:16',
            ),
            484 => 
            array (
                'id' => 485,
                'name' => 'Navy/44',
                'created_at' => '2025-10-30 17:23:16',
                'updated_at' => '2025-10-30 17:23:16',
            ),
            485 => 
            array (
                'id' => 486,
                'name' => 'Brown/',
                'created_at' => '2025-11-01 18:56:44',
                'updated_at' => '2025-11-01 18:56:44',
            ),
            486 => 
            array (
                'id' => 487,
                'name' => 'Green/',
                'created_at' => '2025-11-01 18:56:44',
                'updated_at' => '2025-11-01 18:56:44',
            ),
            487 => 
            array (
                'id' => 488,
                'name' => 'Green/12',
                'created_at' => '2025-11-01 21:21:30',
                'updated_at' => '2025-11-01 21:21:30',
            ),
            488 => 
            array (
                'id' => 489,
                'name' => 'Green/13',
                'created_at' => '2025-11-01 21:21:30',
                'updated_at' => '2025-11-01 21:21:30',
            ),
            489 => 
            array (
                'id' => 490,
                'name' => 'Green/30',
                'created_at' => '2025-11-01 21:21:30',
                'updated_at' => '2025-11-01 21:21:30',
            ),
            490 => 
            array (
                'id' => 491,
                'name' => 'Green/31',
                'created_at' => '2025-11-01 21:21:30',
                'updated_at' => '2025-11-01 21:21:30',
            ),
            491 => 
            array (
                'id' => 492,
                'name' => 'Brown/30',
                'created_at' => '2025-11-01 21:21:33',
                'updated_at' => '2025-11-01 21:21:33',
            ),
            492 => 
            array (
                'id' => 493,
                'name' => 'Brown/31',
                'created_at' => '2025-11-01 21:21:33',
                'updated_at' => '2025-11-01 21:21:33',
            ),
            493 => 
            array (
                'id' => 494,
                'name' => 'Brown/1',
                'created_at' => '2025-11-01 21:21:38',
                'updated_at' => '2025-11-01 21:21:38',
            ),
            494 => 
            array (
                'id' => 495,
                'name' => 'Brown/2',
                'created_at' => '2025-11-01 21:21:38',
                'updated_at' => '2025-11-01 21:21:38',
            ),
            495 => 
            array (
                'id' => 496,
                'name' => 'Brown/3',
                'created_at' => '2025-11-01 21:21:38',
                'updated_at' => '2025-11-01 21:21:38',
            ),
            496 => 
            array (
                'id' => 497,
                'name' => 'Brown/4',
                'created_at' => '2025-11-01 21:21:38',
                'updated_at' => '2025-11-01 21:21:38',
            ),
            497 => 
            array (
                'id' => 498,
                'name' => 'Maroon/1',
                'created_at' => '2025-11-01 21:21:38',
                'updated_at' => '2025-11-01 21:21:38',
            ),
            498 => 
            array (
                'id' => 499,
                'name' => 'Maroon/2',
                'created_at' => '2025-11-01 21:21:38',
                'updated_at' => '2025-11-01 21:21:38',
            ),
            499 => 
            array (
                'id' => 500,
                'name' => 'Maroon/3',
                'created_at' => '2025-11-01 21:21:38',
                'updated_at' => '2025-11-01 21:21:38',
            ),
        ));
        \DB::table('variants')->insert(array (
            0 => 
            array (
                'id' => 501,
                'name' => 'Maroon/4',
                'created_at' => '2025-11-01 21:21:39',
                'updated_at' => '2025-11-01 21:21:39',
            ),
            1 => 
            array (
                'id' => 502,
                'name' => 'White/6',
                'created_at' => '2025-11-02 00:17:29',
                'updated_at' => '2025-11-02 00:17:29',
            ),
            2 => 
            array (
                'id' => 503,
                'name' => 'Green/6',
                'created_at' => '2025-11-02 00:27:13',
                'updated_at' => '2025-11-02 00:27:13',
            ),
            3 => 
            array (
                'id' => 504,
                'name' => 'Green/7',
                'created_at' => '2025-11-02 00:27:13',
                'updated_at' => '2025-11-02 00:27:13',
            ),
            4 => 
            array (
                'id' => 505,
                'name' => 'Green/8',
                'created_at' => '2025-11-02 00:27:13',
                'updated_at' => '2025-11-02 00:27:13',
            ),
            5 => 
            array (
                'id' => 506,
                'name' => 'Green/9',
                'created_at' => '2025-11-02 00:27:13',
                'updated_at' => '2025-11-02 00:27:13',
            ),
            6 => 
            array (
                'id' => 507,
                'name' => 'Green/10',
                'created_at' => '2025-11-02 00:27:13',
                'updated_at' => '2025-11-02 00:27:13',
            ),
            7 => 
            array (
                'id' => 508,
                'name' => 'Green/11',
                'created_at' => '2025-11-02 00:27:13',
                'updated_at' => '2025-11-02 00:27:13',
            ),
            8 => 
            array (
                'id' => 509,
                'name' => 'Silver/6',
                'created_at' => '2025-11-02 00:27:15',
                'updated_at' => '2025-11-02 00:27:15',
            ),
            9 => 
            array (
                'id' => 510,
                'name' => 'Blue/18',
                'created_at' => '2025-11-03 13:39:19',
                'updated_at' => '2025-11-03 13:39:19',
            ),
            10 => 
            array (
                'id' => 511,
                'name' => 'Blue/21',
                'created_at' => '2025-11-03 13:39:19',
                'updated_at' => '2025-11-03 13:39:19',
            ),
            11 => 
            array (
                'id' => 512,
                'name' => 'Green/26',
                'created_at' => '2025-11-03 13:48:12',
                'updated_at' => '2025-11-03 13:48:12',
            ),
            12 => 
            array (
                'id' => 513,
                'name' => 'Green/27',
                'created_at' => '2025-11-03 13:48:12',
                'updated_at' => '2025-11-03 13:48:12',
            ),
            13 => 
            array (
                'id' => 514,
                'name' => 'Green/25',
                'created_at' => '2025-11-03 13:48:12',
                'updated_at' => '2025-11-03 13:48:12',
            ),
            14 => 
            array (
                'id' => 515,
                'name' => 'Gray/25',
                'created_at' => '2025-11-03 14:22:30',
                'updated_at' => '2025-11-03 14:22:30',
            ),
            15 => 
            array (
                'id' => 516,
                'name' => 'Navy/25',
                'created_at' => '2025-11-03 14:22:30',
                'updated_at' => '2025-11-03 14:22:30',
            ),
            16 => 
            array (
                'id' => 517,
                'name' => 'Navy/26',
                'created_at' => '2025-11-03 14:22:30',
                'updated_at' => '2025-11-03 14:22:30',
            ),
            17 => 
            array (
                'id' => 518,
                'name' => 'Navy/27',
                'created_at' => '2025-11-03 14:22:30',
                'updated_at' => '2025-11-03 14:22:30',
            ),
            18 => 
            array (
                'id' => 519,
                'name' => 'Navy/28',
                'created_at' => '2025-11-03 14:22:30',
                'updated_at' => '2025-11-03 14:22:30',
            ),
            19 => 
            array (
                'id' => 520,
                'name' => 'Navy/29',
                'created_at' => '2025-11-03 14:22:30',
                'updated_at' => '2025-11-03 14:22:30',
            ),
            20 => 
            array (
                'id' => 521,
                'name' => 'Navy/30',
                'created_at' => '2025-11-03 14:22:30',
                'updated_at' => '2025-11-03 14:22:30',
            ),
            21 => 
            array (
                'id' => 522,
                'name' => 'Blue/5',
                'created_at' => '2025-11-04 16:11:24',
                'updated_at' => '2025-11-04 16:11:24',
            ),
        ));
        
        
    }
}