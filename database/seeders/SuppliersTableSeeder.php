<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('suppliers')->delete();
        
        \DB::table('suppliers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Avijatry',
                'image' => 'Avijatry.png',
                'company_name' => 'Avijatry',
                'vat_number' => NULL,
                'email' => 'avijatry@gmail.com',
                'phone_number' => '00000',
                'address' => '0000',
                'city' => 'Dhaka',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2026-06-28 13:06:54',
                'updated_at' => '2026-06-28 13:06:54',
            ),
        ));
        
        
    }
}