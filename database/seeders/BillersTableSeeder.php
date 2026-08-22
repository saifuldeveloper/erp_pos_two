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
                'name' => 'Aaaa',
                'image' => NULL,
                'company_name' => 'Aaaa',
                'vat_number' => NULL,
                'email' => 'a@e.com',
                'phone_number' => '01',
                'address' => 'Aa',
                'city' => 'N/A',
                'state' => NULL,
                'postal_code' => NULL,
                'country' => NULL,
                'is_active' => 1,
                'created_at' => '2026-07-26 17:48:05',
                'updated_at' => '2026-07-26 17:48:05',
            ),
        ));
        
        
    }
}