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
                'image' => NULL,
                'company_name' => 'Avijatry',
                'vat_number' => NULL,
                'email' => 'masud@gmail.com',
                'phone_number' => '987654321',
                'address' => 'Uttara',
                'city' => 'Dhaka',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2024-10-07 18:25:04',
                'updated_at' => '2024-10-07 18:25:04',
            ),
        ));
        
        
    }
}