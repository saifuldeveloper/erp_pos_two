<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('accounts')->delete();
        
        \DB::table('accounts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'account_no' => 'Avijatry Khulna',
                'name' => 'Hand Cash',
                'initial_balance' => 0.0,
                'total_balance' => -282500.0,
                'note' => 'Khulna Branch',
                'is_default' => 1,
                'is_active' => 1,
                'created_at' => '2024-10-07 18:35:08',
                'updated_at' => '2025-11-17 22:00:41',
            ),
            1 => 
            array (
                'id' => 2,
                'account_no' => '12345678900058',
                'name' => 'Brac Bank',
                'initial_balance' => 0.0,
                'total_balance' => 0.0,
                'note' => 'Paltan Branch',
                'is_default' => NULL,
                'is_active' => 0,
                'created_at' => '2024-12-21 07:01:11',
                'updated_at' => '2024-12-29 07:13:11',
            ),
        ));
        
        
    }
}