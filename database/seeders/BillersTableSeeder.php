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
                'is_active' => 1,
                'created_at' => '2024-10-07 18:24:14',
                'updated_at' => '2024-10-07 18:24:14',
            ),
        ));
        
        
    }
}