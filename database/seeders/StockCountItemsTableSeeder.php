<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StockCountItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('stock_count_items')->delete();
        
        
        
    }
}