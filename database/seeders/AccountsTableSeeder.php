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
                'total_balance' => -1219000.0,
                'note' => 'Khulna Branch',
                'is_default' => NULL,
                'is_active' => 1,
                'created_at' => '2024-10-07 12:35:08',
                'updated_at' => '2026-02-18 22:13:34',
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
                'created_at' => '2024-12-21 01:01:11',
                'updated_at' => '2024-12-29 01:13:11',
            ),
            2 => 
            array (
                'id' => 3,
                'account_no' => '9890188686',
                'name' => 'POS Pubali',
                'initial_balance' => 386300.599999999976716935634613037109375,
                'total_balance' => 386300.599999999976716935634613037109375,
                'note' => NULL,
                'is_default' => 1,
                'is_active' => 1,
                'created_at' => '2026-01-07 13:44:10',
                'updated_at' => '2026-01-07 13:44:43',
            ),
        ));
        
        
    }
}