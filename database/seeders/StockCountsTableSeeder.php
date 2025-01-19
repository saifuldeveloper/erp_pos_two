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
        
        \DB::table('stock_counts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'reference_no' => 'scr-20241221-085736',
                'warehouse_id' => 1,
                'category_id' => NULL,
                'brand_id' => NULL,
                'user_id' => 1,
                'type' => 'full',
                'initial_file' => '20241221-085736.csv',
                'final_file' => NULL,
                'note' => NULL,
                'is_adjusted' => 0,
                'created_at' => '2024-12-21 08:57:36',
                'updated_at' => '2024-12-21 08:57:36',
            ),
        ));
        
        
    }
}