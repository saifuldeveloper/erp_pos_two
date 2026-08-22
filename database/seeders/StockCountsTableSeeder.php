<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StockCountsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('stock_counts')->delete();
        
        
        
    }
}