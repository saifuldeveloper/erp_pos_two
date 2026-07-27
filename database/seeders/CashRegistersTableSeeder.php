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
        
        
        
    }
}