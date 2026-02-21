<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExpenseCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('expense_categories')->delete();
        
        \DB::table('expense_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '13592410',
                'name' => 'Food',
                'is_active' => 0,
                'created_at' => '2024-12-11 01:11:14',
                'updated_at' => '2024-12-11 01:12:29',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '51919443',
                'name' => 'Food',
                'is_active' => 0,
                'created_at' => '2024-12-11 01:13:03',
                'updated_at' => '2024-12-11 03:05:37',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => '36415507',
                'name' => 'Guest Entertainment',
                'is_active' => 1,
                'created_at' => '2024-12-27 09:20:34',
                'updated_at' => '2025-01-10 19:05:40',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => '39911226',
                'name' => 'Tils Putting',
                'is_active' => 0,
                'created_at' => '2024-12-27 10:56:53',
                'updated_at' => '2025-01-07 06:20:43',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => '65061201',
                'name' => 'Marketing',
                'is_active' => 1,
                'created_at' => '2024-12-27 10:58:15',
                'updated_at' => '2025-01-07 06:11:02',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => '69235892',
                'name' => 'sells return',
                'is_active' => 0,
                'created_at' => '2024-12-27 10:58:40',
                'updated_at' => '2025-01-07 06:21:16',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => '99028029',
                'name' => 'For shop needs',
                'is_active' => 0,
                'created_at' => '2024-12-28 23:10:12',
                'updated_at' => '2025-01-07 06:21:19',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => '21394968',
                'name' => 'Donate',
                'is_active' => 1,
                'created_at' => '2024-12-28 23:11:14',
                'updated_at' => '2024-12-28 23:11:14',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => '16643070',
                'name' => 'Said',
                'is_active' => 1,
                'created_at' => '2024-12-28 23:14:23',
                'updated_at' => '2025-01-07 06:11:27',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => '70526804',
                'name' => 'Kurban',
                'is_active' => 1,
                'created_at' => '2024-12-28 23:14:39',
                'updated_at' => '2025-01-07 06:11:35',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => '21401761',
                'name' => 'Al-Amin',
                'is_active' => 1,
                'created_at' => '2024-12-28 23:16:52',
                'updated_at' => '2025-01-07 06:18:41',
            ),
            11 => 
            array (
                'id' => 12,
                'code' => '03021816',
                'name' => 'LOCK',
                'is_active' => 0,
                'created_at' => '2024-12-29 22:42:08',
                'updated_at' => '2025-01-07 06:21:37',
            ),
            12 => 
            array (
                'id' => 13,
                'code' => '27153366',
                'name' => 'Said Vai daily',
                'is_active' => 0,
                'created_at' => '2024-12-29 22:49:17',
                'updated_at' => '2025-01-07 06:21:42',
            ),
            13 => 
            array (
                'id' => 14,
                'code' => '00625321',
                'name' => 'Al-Amin Vai Daily',
                'is_active' => 0,
                'created_at' => '2024-12-29 22:49:43',
                'updated_at' => '2025-01-07 06:21:47',
            ),
            14 => 
            array (
                'id' => 15,
                'code' => '32699077',
                'name' => 'Dhaka Cost',
                'is_active' => 0,
                'created_at' => '2024-12-31 09:57:49',
                'updated_at' => '2025-01-07 06:26:05',
            ),
            15 => 
            array (
                'id' => 16,
                'code' => '28527612',
                'name' => 'Labour',
                'is_active' => 0,
                'created_at' => '2024-12-31 10:03:25',
                'updated_at' => '2025-01-07 06:22:28',
            ),
            16 => 
            array (
                'id' => 17,
                'code' => '24905640',
                'name' => 'Kurban Vai Daily',
                'is_active' => 0,
                'created_at' => '2024-12-31 10:09:18',
                'updated_at' => '2025-01-07 06:21:51',
            ),
            17 => 
            array (
                'id' => 18,
                'code' => '85924726',
                'name' => 'Daily Tiffin',
                'is_active' => 1,
                'created_at' => '2025-01-01 10:04:04',
                'updated_at' => '2025-01-10 16:57:35',
            ),
            18 => 
            array (
                'id' => 19,
                'code' => '52976512',
                'name' => 'Miscellaneous',
                'is_active' => 1,
                'created_at' => '2025-01-01 10:05:31',
                'updated_at' => '2025-01-07 06:20:30',
            ),
            19 => 
            array (
                'id' => 20,
                'code' => '39415792',
                'name' => 'Salary',
                'is_active' => 0,
                'created_at' => '2025-01-04 15:27:20',
                'updated_at' => '2025-01-07 06:22:38',
            ),
            20 => 
            array (
                'id' => 21,
                'code' => '99310350',
                'name' => 'Pubali Bank Deposit',
                'is_active' => 1,
                'created_at' => '2025-01-04 15:55:10',
                'updated_at' => '2025-01-10 19:07:23',
            ),
            21 => 
            array (
                'id' => 22,
                'code' => '88329213',
                'name' => 'Electricity Bill',
                'is_active' => 1,
                'created_at' => '2025-01-07 06:23:19',
                'updated_at' => '2025-01-07 06:23:19',
            ),
            22 => 
            array (
                'id' => 23,
                'code' => '09643129',
                'name' => 'Godown Rent',
                'is_active' => 1,
                'created_at' => '2025-01-07 06:23:47',
                'updated_at' => '2025-01-10 17:02:23',
            ),
            23 => 
            array (
                'id' => 24,
                'code' => '31201702',
                'name' => 'Sale',
                'is_active' => 0,
                'created_at' => '2025-01-07 06:24:28',
                'updated_at' => '2025-01-07 06:24:44',
            ),
            24 => 
            array (
                'id' => 25,
                'code' => '18649561',
                'name' => 'Transport',
                'is_active' => 1,
                'created_at' => '2025-01-07 06:25:43',
                'updated_at' => '2025-01-07 06:25:43',
            ),
            25 => 
            array (
                'id' => 26,
                'code' => '41312935',
                'name' => 'Maid',
                'is_active' => 1,
                'created_at' => '2025-01-07 06:35:29',
                'updated_at' => '2025-01-07 06:35:29',
            ),
            26 => 
            array (
                'id' => 27,
                'code' => '36973174',
                'name' => 'Imrul',
                'is_active' => 1,
                'created_at' => '2025-01-10 16:45:26',
                'updated_at' => '2025-01-10 16:45:26',
            ),
            27 => 
            array (
                'id' => 28,
                'code' => '01246878',
                'name' => 'Discount',
                'is_active' => 1,
                'created_at' => '2025-01-10 16:52:06',
                'updated_at' => '2025-01-10 16:52:06',
            ),
            28 => 
            array (
                'id' => 29,
                'code' => '10456475',
                'name' => 'Shop Rent',
                'is_active' => 1,
                'created_at' => '2025-01-10 17:02:42',
                'updated_at' => '2025-01-10 17:02:42',
            ),
            29 => 
            array (
                'id' => 30,
                'code' => '74355610',
                'name' => 'Night Guard',
                'is_active' => 1,
                'created_at' => '2025-01-10 17:23:06',
                'updated_at' => '2025-01-10 17:23:06',
            ),
            30 => 
            array (
                'id' => 31,
                'code' => '21470319',
                'name' => 'Cash Short',
                'is_active' => 1,
                'created_at' => '2025-01-10 17:39:17',
                'updated_at' => '2025-01-10 17:39:17',
            ),
            31 => 
            array (
                'id' => 32,
                'code' => '90808365',
                'name' => 'Rafael Sir',
                'is_active' => 1,
                'created_at' => '2025-01-10 19:17:34',
                'updated_at' => '2025-01-10 19:17:34',
            ),
            32 => 
            array (
                'id' => 33,
                'code' => '23936078',
                'name' => 'Taslim Uddin Sir',
                'is_active' => 1,
                'created_at' => '2025-01-10 19:18:10',
                'updated_at' => '2025-01-10 19:18:10',
            ),
            33 => 
            array (
                'id' => 34,
                'code' => '50915291',
                'name' => 'Pubali Bank POS Machine',
                'is_active' => 1,
                'created_at' => '2025-01-10 19:20:20',
                'updated_at' => '2025-01-10 19:20:20',
            ),
            34 => 
            array (
                'id' => 35,
                'code' => '92817509',
                'name' => 'UCB Bank POS Machine',
                'is_active' => 1,
                'created_at' => '2025-01-10 19:20:34',
                'updated_at' => '2025-01-10 19:20:48',
            ),
            35 => 
            array (
                'id' => 36,
                'code' => '34602184',
                'name' => 'Overtime',
                'is_active' => 1,
                'created_at' => '2025-01-10 19:24:24',
                'updated_at' => '2025-01-10 19:24:24',
            ),
            36 => 
            array (
                'id' => 37,
                'code' => '01286958',
                'name' => 'Shoe Accessories',
                'is_active' => 1,
                'created_at' => '2025-01-12 17:49:09',
                'updated_at' => '2025-01-12 17:49:09',
            ),
            37 => 
            array (
                'id' => 38,
                'code' => '79390309',
                'name' => 'Khulna China',
                'is_active' => 1,
                'created_at' => '2025-01-19 15:19:34',
                'updated_at' => '2025-01-19 15:19:34',
            ),
            38 => 
            array (
                'id' => 39,
                'code' => '64371140',
                'name' => 'City Bank POS Machine',
                'is_active' => 1,
                'created_at' => '2025-02-04 15:42:51',
                'updated_at' => '2025-02-04 15:42:51',
            ),
            39 => 
            array (
                'id' => 40,
                'code' => '12233760',
                'name' => 'Sabbir',
                'is_active' => 1,
                'created_at' => '2025-02-06 16:21:57',
                'updated_at' => '2025-02-06 16:21:57',
            ),
            40 => 
            array (
                'id' => 41,
                'code' => '47849928',
                'name' => 'Janata Bank Deposit',
                'is_active' => 1,
                'created_at' => '2025-05-28 16:59:53',
                'updated_at' => '2025-05-28 16:59:53',
            ),
            41 => 
            array (
                'id' => 42,
                'code' => '21634915',
                'name' => '1 Pair Commission',
                'is_active' => 1,
                'created_at' => '2025-07-27 16:05:01',
                'updated_at' => '2025-07-27 16:05:01',
            ),
            42 => 
            array (
                'id' => 43,
                'code' => '45713354',
                'name' => 'Sakil',
                'is_active' => 1,
                'created_at' => '2025-09-10 14:52:50',
                'updated_at' => '2025-09-10 14:52:50',
            ),
            43 => 
            array (
                'id' => 44,
                'code' => '98232972',
                'name' => 'Amin',
                'is_active' => 1,
                'created_at' => '2025-09-14 16:15:23',
                'updated_at' => '2025-09-14 16:15:23',
            ),
        ));
        
        
    }
}