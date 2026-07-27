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
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2026-06-28 12:54:47',
                'updated_at' => '2026-07-26 17:51:30',
            ),
            1 => 
            array (
                'id' => 2,
                'warehouse_id' => 2,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2026-07-26 17:51:37',
                'updated_at' => '2026-07-26 19:24:48',
            ),
            2 => 
            array (
                'id' => 3,
                'warehouse_id' => 1,
                'is_completed' => 0,
                'is_resolved' => 0,
                'completed_by' => NULL,
                'resolved_by' => NULL,
                'created_at' => '2026-07-27 11:23:50',
                'updated_at' => '2026-07-27 11:23:50',
            ),
        ));
        
        
    }
}