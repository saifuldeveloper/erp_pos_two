<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('customers')->delete();
        
        \DB::table('customers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'customer_group_id' => 1,
                'user_id' => NULL,
                'name' => 'antor',
                'company_name' => NULL,
                'email' => NULL,
                'phone_number' => '000000',
                'tax_no' => NULL,
                'address' => NULL,
                'city' => NULL,
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'points' => NULL,
                'is_active' => 1,
                'created_at' => '2026-06-28 13:31:59',
                'updated_at' => '2026-06-28 13:31:59',
                'deposit' => NULL,
                'expense' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'customer_group_id' => 1,
                'user_id' => NULL,
                'name' => 'Antor',
                'company_name' => NULL,
                'email' => NULL,
                'phone_number' => '0000',
                'tax_no' => NULL,
                'address' => NULL,
                'city' => NULL,
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'points' => NULL,
                'is_active' => 1,
                'created_at' => '2026-06-28 13:36:37',
                'updated_at' => '2026-06-28 13:36:37',
                'deposit' => NULL,
                'expense' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'customer_group_id' => 1,
                'user_id' => NULL,
                'name' => 'shafiq',
                'company_name' => NULL,
                'email' => NULL,
                'phone_number' => '01712090037',
                'tax_no' => NULL,
                'address' => NULL,
                'city' => NULL,
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'points' => NULL,
                'is_active' => 1,
                'created_at' => '2026-07-14 12:08:24',
                'updated_at' => '2026-07-14 12:08:24',
                'deposit' => NULL,
                'expense' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'customer_group_id' => 1,
                'user_id' => NULL,
                'name' => 'Rofiq Hasan',
                'company_name' => NULL,
                'email' => 'Rafiq@gmail.com',
                'phone_number' => '01928112807',
                'tax_no' => NULL,
                'address' => NULL,
                'city' => NULL,
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'points' => NULL,
                'is_active' => 1,
                'created_at' => '2026-07-14 13:40:31',
                'updated_at' => '2026-07-14 13:40:31',
                'deposit' => NULL,
                'expense' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'customer_group_id' => 1,
                'user_id' => NULL,
                'name' => 'Sofiq Khan',
                'company_name' => NULL,
                'email' => NULL,
                'phone_number' => '01721905566',
                'tax_no' => NULL,
                'address' => NULL,
                'city' => NULL,
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'points' => NULL,
                'is_active' => 1,
                'created_at' => '2026-07-14 14:28:33',
                'updated_at' => '2026-07-14 14:28:33',
                'deposit' => NULL,
                'expense' => NULL,
            ),
        ));
        
        
    }
}