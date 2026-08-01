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
                'name' => 'antor',
                'company_name' => NULL,
                'email' => NULL,
                'phone_number' => '000000',
                'address' => NULL,
                'city' => NULL,
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'deposit' => NULL,
                'expense' => NULL,
                'tax_no' => NULL,
                'user_id' => NULL,
                'points' => NULL,
                'created_at' => '2026-06-28 13:31:59',
                'updated_at' => '2026-06-28 13:31:59',
            ),
            1 => 
            array (
                'id' => 2,
                'customer_group_id' => 1,
                'name' => 'Antor',
                'company_name' => NULL,
                'email' => NULL,
                'phone_number' => '0000',
                'address' => NULL,
                'city' => NULL,
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'deposit' => NULL,
                'expense' => NULL,
                'tax_no' => NULL,
                'user_id' => NULL,
                'points' => NULL,
                'created_at' => '2026-06-28 13:36:37',
                'updated_at' => '2026-06-28 13:36:37',
            ),
            2 => 
            array (
                'id' => 3,
                'customer_group_id' => 1,
                'name' => 'shafiq',
                'company_name' => NULL,
                'email' => NULL,
                'phone_number' => '01712090037',
                'address' => NULL,
                'city' => NULL,
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'deposit' => NULL,
                'expense' => NULL,
                'tax_no' => NULL,
                'user_id' => NULL,
                'points' => NULL,
                'created_at' => '2026-07-14 12:08:24',
                'updated_at' => '2026-07-14 12:08:24',
            ),
            3 => 
            array (
                'id' => 4,
                'customer_group_id' => 1,
                'name' => 'Rofiq Hasan',
                'company_name' => NULL,
                'email' => 'Rafiq@gmail.com',
                'phone_number' => '01928112807',
                'address' => NULL,
                'city' => NULL,
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'deposit' => NULL,
                'expense' => NULL,
                'tax_no' => NULL,
                'user_id' => NULL,
                'points' => NULL,
                'created_at' => '2026-07-14 13:40:31',
                'updated_at' => '2026-07-14 13:40:31',
            ),
            4 => 
            array (
                'id' => 5,
                'customer_group_id' => 1,
                'name' => 'Sofiq Khan',
                'company_name' => NULL,
                'email' => NULL,
                'phone_number' => '01721905566',
                'address' => NULL,
                'city' => NULL,
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'deposit' => NULL,
                'expense' => NULL,
                'tax_no' => NULL,
                'user_id' => NULL,
                'points' => NULL,
                'created_at' => '2026-07-14 14:28:33',
                'updated_at' => '2026-07-14 14:28:33',
            ),
        ));
        
        
    }
}