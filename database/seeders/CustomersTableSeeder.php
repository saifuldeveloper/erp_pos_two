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
                'name' => 'Walking Customer',
                'company_name' => NULL,
                'email' => NULL,
                'phone_number' => '12345678',
                'tax_no' => NULL,
                'address' => 'Uttara',
                'city' => 'Dhaka',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'points' => NULL,
                'is_active' => 1,
                'created_at' => '2024-10-07 18:23:05',
                'updated_at' => '2024-10-07 18:23:05',
                'deposit' => NULL,
                'expense' => NULL,
            ),
        ));
        
        
    }
}