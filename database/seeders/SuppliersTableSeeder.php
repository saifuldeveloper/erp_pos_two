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
                'image' => 'Avijatry.jpg',
                'company_name' => 'Avijatry',
                'vat_number' => NULL,
                'email' => 'info.avijatry@gmail.com',
                'phone_number' => '01849-582550',
                'address' => '2nd Floor, Dhaka Trade Center, Gulistan, Dhaka',
                'city' => 'Dhaka',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2025-04-19 19:42:11',
                'updated_at' => '2025-04-19 19:42:11',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'China',
                'image' => 'China.jpg',
                'company_name' => 'China',
                'vat_number' => NULL,
                'email' => 'chinashoes@gmail.com',
                'phone_number' => '01849-582550',
                'address' => '2nd Floor, Dhaka Trade Center, Gulistan, Dhaka',
                'city' => 'Dhaka',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2025-04-19 19:43:23',
                'updated_at' => '2025-04-19 19:43:23',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Accessories',
                'image' => 'Accessories.jfif',
                'company_name' => 'Accessories',
                'vat_number' => NULL,
                'email' => 'accessories@gmail.com',
                'phone_number' => '01849-582550',
                'address' => '2nd Floor, Dhaka Trade Center, Gulistan, Dhaka',
                'city' => 'Dhaka',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2025-04-19 19:44:38',
                'updated_at' => '2025-04-19 19:44:51',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Avijatry Discount',
                'image' => 'AvijatryDiscount.jpg',
                'company_name' => 'Avijatry Discount',
                'vat_number' => NULL,
                'email' => 'Cumilla@avijatry.com',
                'phone_number' => '0',
                'address' => '0',
                'city' => '0',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2025-04-21 02:18:30',
                'updated_at' => '2025-04-21 02:29:26',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'China Discount',
                'image' => 'ChinaDiscount.png',
                'company_name' => 'China Discount',
                'vat_number' => NULL,
                'email' => 'chinadiscount@avijatry.com',
                'phone_number' => '0',
                'address' => '0',
                'city' => '0',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2025-04-24 22:10:34',
                'updated_at' => '2025-04-24 22:10:34',
            ),
        ));
        
        
    }
}