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
                'phone_number' => '987654321',
                'address' => 'Uttara',
                'city' => 'Dhaka',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2024-10-07 18:25:04',
                'updated_at' => '2024-12-21 06:54:58',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'China',
                'image' => 'China.png',
                'company_name' => 'China',
                'vat_number' => NULL,
                'email' => 'china@gmail.com',
                'phone_number' => '0',
                'address' => 'Shanghai',
                'city' => 'Shanghai',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2024-12-22 12:45:29',
                'updated_at' => '2024-12-22 12:45:29',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Accessories',
                'image' => 'Accessories.jpeg',
                'company_name' => 'Accessories',
                'vat_number' => NULL,
                'email' => 'accessories@com',
                'phone_number' => '01816420420',
                'address' => 'Dhaka',
                'city' => 'Dhaka',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2025-01-18 19:06:53',
                'updated_at' => '2025-01-18 19:08:23',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Khulna China',
                'image' => 'KhulnaChina.png',
                'company_name' => 'Khulna China',
                'vat_number' => NULL,
                'email' => 'china@avijatry.com',
                'phone_number' => '0',
                'address' => 'Shanghai',
                'city' => 'Shanghai',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2025-01-19 20:08:02',
                'updated_at' => '2025-01-19 20:08:02',
            ),
        ));
        
        
    }
}