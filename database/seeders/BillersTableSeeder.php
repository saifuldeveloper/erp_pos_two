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
                'created_at' => '2024-10-07 12:24:14',
                'updated_at' => '2024-12-22 01:31:20',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Imrul Kayes',
                'image' => NULL,
                'company_name' => 'Avijatry Khulna',
                'vat_number' => NULL,
                'email' => 'imrulkayes@gmail.com',
                'phone_number' => '01928219070',
                'address' => 'Khulna',
                'city' => 'Khulna',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2024-12-22 01:32:29',
                'updated_at' => '2025-03-15 22:08:01',
            ),
        ));
        
        
    }
}