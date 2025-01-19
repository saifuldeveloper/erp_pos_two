<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MoneyTransfersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('money_transfers')->delete();
        
        
        
    }
}