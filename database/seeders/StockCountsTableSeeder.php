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
                'warehouse_id' => 1,
                'is_completed' => 0,
                'is_resolved' => 0,
                'completed_by' => NULL,
                'resolved_by' => NULL,
                'created_at' => '2026-05-19 17:21:53',
                'updated_at' => '2026-05-19 17:21:53',
            ),
        ));
        
        
    }
}