<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WastesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('wastes')->delete();
        
        \DB::table('wastes')->insert(array (
            0 => 
            array (
                'id' => 3,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'Black/13-R-86',
                'total_price' => '795.00',
                'status' => 1,
                'created_at' => '2025-04-20 16:55:52',
                'updated_at' => '2025-04-20 16:55:52',
            ),
            1 => 
            array (
                'id' => 4,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'R-131- 39/Black',
                'total_price' => '1595.00',
                'status' => 1,
                'created_at' => '2025-04-21 10:42:37',
                'updated_at' => '2025-04-21 10:42:37',
            ),
            2 => 
            array (
                'id' => 5,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'R-239- 43/Master',
                'total_price' => '1395.00',
                'status' => 1,
                'created_at' => '2025-04-21 12:59:19',
                'updated_at' => '2025-04-21 12:59:19',
            ),
            3 => 
            array (
                'id' => 6,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '1450.00',
                'status' => 1,
                'created_at' => '2025-04-21 12:59:37',
                'updated_at' => '2025-04-21 12:59:37',
            ),
            4 => 
            array (
                'id' => 7,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '1050.00',
                'status' => 1,
                'created_at' => '2025-04-21 15:30:34',
                'updated_at' => '2025-04-21 15:30:34',
            ),
            5 => 
            array (
                'id' => 8,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'R-188-43 CH',
                'total_price' => '795.00',
                'status' => 1,
                'created_at' => '2025-04-21 16:48:10',
                'updated_at' => '2025-04-21 16:48:10',
            ),
            6 => 
            array (
                'id' => 9,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'R-72-41-Black',
                'total_price' => '995.00',
                'status' => 1,
                'created_at' => '2025-04-21 16:48:42',
                'updated_at' => '2025-04-21 16:48:42',
            ),
            7 => 
            array (
                'id' => 10,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'R-66-40-Master',
                'total_price' => '1760.00',
                'status' => 1,
                'created_at' => '2025-04-21 16:49:12',
                'updated_at' => '2025-04-21 16:49:12',
            ),
            8 => 
            array (
                'id' => 11,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '790.00',
                'status' => 1,
                'created_at' => '2025-04-21 17:32:07',
                'updated_at' => '2025-04-21 17:32:07',
            ),
            9 => 
            array (
                'id' => 12,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '4690.00',
                'status' => 1,
                'created_at' => '2025-04-21 21:35:41',
                'updated_at' => '2025-04-21 21:35:41',
            ),
            10 => 
            array (
                'id' => 13,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '975.00',
                'status' => 1,
                'created_at' => '2025-04-21 21:38:24',
                'updated_at' => '2025-04-21 21:38:24',
            ),
            11 => 
            array (
                'id' => 14,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '12345.00',
                'status' => 1,
                'created_at' => '2025-04-25 19:42:04',
                'updated_at' => '2025-04-25 19:42:04',
            ),
            12 => 
            array (
                'id' => 15,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '12955.00',
                'status' => 1,
                'created_at' => '2025-04-25 19:47:31',
                'updated_at' => '2025-04-25 19:47:31',
            ),
            13 => 
            array (
                'id' => 16,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '16365.00',
                'status' => 1,
                'created_at' => '2025-04-25 19:51:18',
                'updated_at' => '2025-04-25 19:51:18',
            ),
            14 => 
            array (
                'id' => 17,
                'receiver_type' => 'employee',
                'receiver_id' => 1,
                'receiver_name' => 'Md Jahidul Hoq',
                'note' => NULL,
                'total_price' => '1150.00',
                'status' => 1,
                'created_at' => '2026-03-20 11:48:58',
                'updated_at' => '2026-03-20 11:48:58',
            ),
            15 => 
            array (
                'id' => 18,
                'receiver_type' => 'employee',
                'receiver_id' => 1,
                'receiver_name' => 'Md Jahidul Hoq',
                'note' => NULL,
                'total_price' => '1595.00',
                'status' => 1,
                'created_at' => '2026-03-20 11:50:51',
                'updated_at' => '2026-03-20 11:50:51',
            ),
            16 => 
            array (
                'id' => 19,
                'receiver_type' => 'employee',
                'receiver_id' => 1,
                'receiver_name' => 'Md Jahidul Hoq',
                'note' => NULL,
                'total_price' => '1495.00',
                'status' => 1,
                'created_at' => '2026-03-20 11:53:38',
                'updated_at' => '2026-03-20 11:53:38',
            ),
            17 => 
            array (
                'id' => 20,
                'receiver_type' => 'employee',
                'receiver_id' => 1,
                'receiver_name' => 'Md Jahidul Hoq',
                'note' => NULL,
                'total_price' => '1455.00',
                'status' => 1,
                'created_at' => '2026-03-20 12:07:05',
                'updated_at' => '2026-03-20 12:07:05',
            ),
            18 => 
            array (
                'id' => 21,
                'receiver_type' => 'employee',
                'receiver_id' => 1,
                'receiver_name' => 'Md Jahidul Hoq',
                'note' => NULL,
                'total_price' => '995.00',
                'status' => 1,
                'created_at' => '2026-03-20 19:39:19',
                'updated_at' => '2026-03-20 19:39:19',
            ),
            19 => 
            array (
                'id' => 22,
                'receiver_type' => 'employee',
                'receiver_id' => 1,
                'receiver_name' => 'Md Jahidul Hoq',
                'note' => NULL,
                'total_price' => '895.00',
                'status' => 1,
                'created_at' => '2026-03-20 19:41:43',
                'updated_at' => '2026-03-20 19:41:43',
            ),
            20 => 
            array (
                'id' => 23,
                'receiver_type' => 'employee',
                'receiver_id' => 3,
                'receiver_name' => 'Md Faysal Sarker',
                'note' => NULL,
                'total_price' => '1150.00',
                'status' => 1,
                'created_at' => '2026-03-24 11:12:33',
                'updated_at' => '2026-03-24 11:12:33',
            ),
            21 => 
            array (
                'id' => 24,
                'receiver_type' => 'employee',
                'receiver_id' => 3,
                'receiver_name' => 'Md Faysal Sarker',
                'note' => NULL,
                'total_price' => '795.00',
                'status' => 1,
                'created_at' => '2026-03-24 11:13:13',
                'updated_at' => '2026-03-24 11:13:13',
            ),
            22 => 
            array (
                'id' => 25,
                'receiver_type' => 'employee',
                'receiver_id' => 3,
                'receiver_name' => 'Md Faysal Sarker',
                'note' => NULL,
                'total_price' => '4620.00',
                'status' => 1,
                'created_at' => '2026-03-24 11:14:58',
                'updated_at' => '2026-03-24 11:14:58',
            ),
            23 => 
            array (
                'id' => 26,
                'receiver_type' => 'employee',
                'receiver_id' => 2,
                'receiver_name' => 'Abdul Malek',
                'note' => NULL,
                'total_price' => '7700.00',
                'status' => 1,
                'created_at' => '2026-03-25 16:11:42',
                'updated_at' => '2026-03-25 16:11:42',
            ),
            24 => 
            array (
                'id' => 27,
                'receiver_type' => 'employee',
                'receiver_id' => 6,
                'receiver_name' => 'Shahadat',
                'note' => 'Eid',
                'total_price' => '1970.00',
                'status' => 1,
                'created_at' => '2026-03-25 18:22:31',
                'updated_at' => '2026-03-25 18:22:31',
            ),
            25 => 
            array (
                'id' => 28,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => 'Rafayael Sir',
                'total_price' => '1495.00',
                'status' => 1,
                'created_at' => '2026-06-22 12:38:12',
                'updated_at' => '2026-06-22 12:38:12',
            ),
            26 => 
            array (
                'id' => 29,
                'receiver_type' => 'supplier',
                'receiver_id' => 2,
                'receiver_name' => 'China',
                'note' => 'Rafayael Sir',
                'total_price' => '1200.00',
                'status' => 1,
                'created_at' => '2026-06-22 12:39:25',
                'updated_at' => '2026-06-22 12:39:25',
            ),
            27 => 
            array (
                'id' => 30,
                'receiver_type' => 'supplier',
                'receiver_id' => 3,
                'receiver_name' => 'Accessories',
                'note' => 'দোকানে কাজে ব্যাবহার করা হইছে',
                'total_price' => '240.00',
                'status' => 1,
                'created_at' => '2026-06-22 12:42:01',
                'updated_at' => '2026-06-22 12:42:01',
            ),
            28 => 
            array (
                'id' => 31,
                'receiver_type' => 'supplier',
                'receiver_id' => 3,
                'receiver_name' => 'Accessories',
                'note' => 'দোকানে কাজে ব্যাবহার করা হইছে',
                'total_price' => '560.00',
                'status' => 1,
                'created_at' => '2026-06-22 12:43:17',
                'updated_at' => '2026-06-22 12:43:17',
            ),
            29 => 
            array (
                'id' => 32,
                'receiver_type' => 'biller',
                'receiver_id' => 4,
                'receiver_name' => 'Showroom own',
                'note' => NULL,
                'total_price' => '57145.00',
                'status' => 1,
                'created_at' => '2026-06-22 14:24:29',
                'updated_at' => '2026-06-22 14:24:29',
            ),
            30 => 
            array (
                'id' => 33,
                'receiver_type' => 'biller',
                'receiver_id' => 4,
                'receiver_name' => 'Showroom own',
                'note' => NULL,
                'total_price' => '2850.00',
                'status' => 1,
                'created_at' => '2026-06-22 15:00:50',
                'updated_at' => '2026-06-22 15:00:50',
            ),
            31 => 
            array (
                'id' => 34,
                'receiver_type' => 'biller',
                'receiver_id' => 4,
                'receiver_name' => 'Showroom own',
                'note' => NULL,
                'total_price' => '1700.00',
                'status' => 1,
                'created_at' => '2026-06-22 17:46:07',
                'updated_at' => '2026-06-22 17:46:07',
            ),
            32 => 
            array (
                'id' => 35,
                'receiver_type' => 'biller',
                'receiver_id' => 4,
                'receiver_name' => 'Showroom own',
                'note' => NULL,
                'total_price' => '695.00',
                'status' => 1,
                'created_at' => '2026-06-22 19:28:49',
                'updated_at' => '2026-06-22 19:28:49',
            ),
            33 => 
            array (
                'id' => 36,
                'receiver_type' => 'biller',
                'receiver_id' => 4,
                'receiver_name' => 'Showroom own',
                'note' => NULL,
                'total_price' => '1550.00',
                'status' => 1,
                'created_at' => '2026-06-22 19:59:43',
                'updated_at' => '2026-06-22 19:59:43',
            ),
            34 => 
            array (
                'id' => 37,
                'receiver_type' => 'biller',
                'receiver_id' => 4,
                'receiver_name' => 'Showroom own',
                'note' => NULL,
                'total_price' => '1550.00',
                'status' => 1,
                'created_at' => '2026-06-22 20:03:15',
                'updated_at' => '2026-06-22 20:03:15',
            ),
            35 => 
            array (
                'id' => 38,
                'receiver_type' => 'biller',
                'receiver_id' => 4,
                'receiver_name' => 'Showroom own',
                'note' => NULL,
                'total_price' => '2750.00',
                'status' => 1,
                'created_at' => '2026-06-22 20:08:48',
                'updated_at' => '2026-06-22 20:08:48',
            ),
            36 => 
            array (
                'id' => 39,
                'receiver_type' => 'biller',
                'receiver_id' => 4,
                'receiver_name' => 'Showroom own',
                'note' => NULL,
                'total_price' => '1500.00',
                'status' => 1,
                'created_at' => '2026-06-22 20:10:22',
                'updated_at' => '2026-06-22 20:10:22',
            ),
            37 => 
            array (
                'id' => 40,
                'receiver_type' => 'biller',
                'receiver_id' => 4,
                'receiver_name' => 'Showroom own',
                'note' => NULL,
                'total_price' => '11070.00',
                'status' => 1,
                'created_at' => '2026-06-23 00:25:04',
                'updated_at' => '2026-06-23 00:25:04',
            ),
        ));
        
        
    }
}