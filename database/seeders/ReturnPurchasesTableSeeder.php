<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReturnPurchasesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('return_purchases')->delete();
        
        
        
    }
}