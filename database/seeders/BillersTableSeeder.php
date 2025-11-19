<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BillersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('billers')->delete();
        
        \DB::table('billers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Sazzad',
                'image' => NULL,
                'company_name' => 'Avijatry store',
                'vat_number' => NULL,
                'email' => 'sazzad@gmail.com',
                'phone_number' => '78945612',
                'address' => 'Uttara',
                'city' => 'Dhaka',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 0,
                'created_at' => '2024-10-08 00:24:14',
                'updated_at' => '2024-12-22 13:31:20',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Jahidul',
                'image' => NULL,
                'company_name' => 'Avijatry Shoes',
                'vat_number' => NULL,
                'email' => 'jahidul49@gmail.com',
                'phone_number' => '01629166721',
                'address' => 'Kandirpar, Comilla',
                'city' => 'Cumilla',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2025-04-19 17:17:33',
                'updated_at' => '2025-11-13 21:41:22',
            ),
        ));
        
        
    }
}