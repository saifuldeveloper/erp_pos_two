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
                'code' => '58737049',
                'name' => 'Guest Entertainment',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:33:10',
                'updated_at' => '2025-04-19 19:33:10',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '54991849',
                'name' => 'Donate',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:33:21',
                'updated_at' => '2025-04-19 19:33:21',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => '36211328',
                'name' => 'Daily Tiffin',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:33:32',
                'updated_at' => '2025-04-19 19:33:32',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => '13299465',
                'name' => 'Miscellaneous',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:33:39',
                'updated_at' => '2025-04-19 19:33:39',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => '43015211',
                'name' => 'Electricity Bill',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:33:51',
                'updated_at' => '2025-04-19 19:33:51',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => '80212990',
                'name' => 'Transport',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:34:12',
                'updated_at' => '2025-04-19 19:34:12',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => '50894673',
                'name' => 'Shop Rent',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:34:25',
                'updated_at' => '2025-04-19 19:34:25',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => '54207396',
                'name' => 'Rafael Sir',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:34:35',
                'updated_at' => '2025-04-19 19:34:35',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => '35928743',
                'name' => 'A H M Taslim Uddin Sir',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:34:48',
                'updated_at' => '2025-04-19 19:34:48',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => '82920331',
                'name' => 'Shoe Accessories',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:35:01',
                'updated_at' => '2025-04-19 19:35:01',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => '19658821',
                'name' => 'Wifi Bill',
                'is_active' => 1,
                'created_at' => '2025-04-19 19:35:40',
                'updated_at' => '2025-04-19 19:35:40',
            ),
            11 => 
            array (
                'id' => 12,
                'code' => '30035521',
                'name' => 'Pubali Bank POS Machine',
                'is_active' => 1,
                'created_at' => '2025-04-27 01:19:43',
                'updated_at' => '2025-04-27 01:19:43',
            ),
            12 => 
            array (
                'id' => 13,
                'code' => '23732514',
                'name' => 'Night Guard',
                'is_active' => 1,
                'created_at' => '2025-04-27 01:20:04',
                'updated_at' => '2025-04-27 01:20:04',
            ),
            13 => 
            array (
                'id' => 14,
                'code' => '76098201',
                'name' => 'Discount',
                'is_active' => 1,
                'created_at' => '2025-04-27 01:20:21',
                'updated_at' => '2025-04-27 01:20:21',
            ),
            14 => 
            array (
                'id' => 15,
                'code' => '07124646',
                'name' => 'Marketing',
                'is_active' => 1,
                'created_at' => '2025-04-27 01:21:48',
                'updated_at' => '2025-04-27 01:21:48',
            ),
            15 => 
            array (
                'id' => 16,
                'code' => '06882346',
                'name' => 'Pubali Bank Deposit',
                'is_active' => 1,
                'created_at' => '2025-04-27 16:27:57',
                'updated_at' => '2025-04-27 16:27:57',
            ),
            16 => 
            array (
                'id' => 17,
                'code' => '41024318',
                'name' => 'Tagada',
                'is_active' => 1,
                'created_at' => '2025-04-28 03:48:19',
                'updated_at' => '2025-04-28 03:48:19',
            ),
            17 => 
            array (
                'id' => 18,
                'code' => '50286934',
                'name' => 'Janata Bank Deposit',
                'is_active' => 1,
                'created_at' => '2025-05-04 13:16:45',
                'updated_at' => '2025-05-04 13:16:45',
            ),
            18 => 
            array (
                'id' => 19,
                'code' => '32900721',
            'name' => 'Staff Comission (1 Pair)',
                'is_active' => 1,
                'created_at' => '2025-05-05 16:43:49',
                'updated_at' => '2025-05-05 16:43:49',
            ),
            19 => 
            array (
                'id' => 20,
                'code' => '58637416',
                'name' => 'VAT',
                'is_active' => 1,
                'created_at' => '2025-05-13 11:42:21',
                'updated_at' => '2025-05-13 11:42:21',
            ),
            20 => 
            array (
                'id' => 21,
                'code' => '80250929',
                'name' => 'Oil',
                'is_active' => 1,
                'created_at' => '2025-05-18 12:00:36',
                'updated_at' => '2025-05-18 12:00:36',
            ),
            21 => 
            array (
                'id' => 22,
                'code' => '57040596',
                'name' => 'Dutch Bangla Bank Deposit',
                'is_active' => 1,
                'created_at' => '2025-06-06 23:51:53',
                'updated_at' => '2025-06-06 23:51:53',
            ),
            22 => 
            array (
                'id' => 23,
                'code' => '06043216',
                'name' => 'Baksh Payment',
                'is_active' => 1,
                'created_at' => '2025-07-10 16:09:53',
                'updated_at' => '2025-07-10 16:09:53',
            ),
        ));
        
        
    }
}