<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CashRegistersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cash_registers')->delete();
        
        \DB::table('cash_registers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'cash_in_hand' => 50000.0,
                'user_id' => 1,
                'warehouse_id' => 1,
                'status' => 1,
                'created_at' => '2024-12-12 05:19:13',
                'updated_at' => '2024-12-12 05:19:13',
            ),
        ));
        
        
    }
}