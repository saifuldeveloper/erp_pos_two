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
                'account_no' => 'Avijatry Comilla',
                'name' => 'Hand Cash',
                'initial_balance' => 0.0,
                'total_balance' => -295000.0,
                'note' => 'Khulna Branch',
                'is_default' => 1,
                'is_active' => 1,
                'created_at' => '2024-10-08 00:35:08',
                'updated_at' => '2025-11-17 19:36:30',
            ),
        ));
        
        
    }
}