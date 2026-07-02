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
                'completed_by' => 5,
                'resolved_by' => 5,
                'created_at' => '2026-05-19 17:21:53',
                'updated_at' => '2026-06-18 12:47:38',
            ),
            1 => 
            array (
                'id' => 2,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2026-06-18 12:50:21',
                'updated_at' => '2026-06-23 01:33:32',
            ),
            2 => 
            array (
                'id' => 3,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2026-06-23 02:11:53',
                'updated_at' => '2026-06-23 02:23:38',
            ),
            3 => 
            array (
                'id' => 4,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2026-06-23 02:44:54',
                'updated_at' => '2026-06-23 22:26:10',
            ),
            4 => 
            array (
                'id' => 5,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2026-06-23 22:27:01',
                'updated_at' => '2026-06-23 23:33:09',
            ),
            5 => 
            array (
                'id' => 6,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2026-06-23 23:34:02',
                'updated_at' => '2026-06-23 23:36:51',
            ),
            6 => 
            array (
                'id' => 7,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2026-06-24 00:23:46',
                'updated_at' => '2026-06-24 00:24:25',
            ),
            7 => 
            array (
                'id' => 8,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2026-06-24 11:27:20',
                'updated_at' => '2026-06-24 23:44:06',
            ),
            8 => 
            array (
                'id' => 9,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2026-06-24 23:51:21',
                'updated_at' => '2026-06-24 23:52:20',
            ),
        ));
        
        
    }
}