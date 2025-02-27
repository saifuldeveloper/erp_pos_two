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
                'warehouse_id' => 4,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-02-12 18:21:50',
                'updated_at' => '2025-02-15 22:14:37',
            ),
            1 => 
            array (
                'id' => 2,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 3,
                'resolved_by' => 3,
                'created_at' => '2025-02-15 22:15:05',
                'updated_at' => '2025-02-18 18:59:36',
            ),
            2 => 
            array (
                'id' => 3,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 3,
                'resolved_by' => 3,
                'created_at' => '2025-02-15 22:16:48',
                'updated_at' => '2025-02-18 19:10:11',
            ),
            3 => 
            array (
                'id' => 4,
                'warehouse_id' => 1,
                'is_completed' => 0,
                'is_resolved' => 0,
                'completed_by' => NULL,
                'resolved_by' => NULL,
                'created_at' => '2025-02-15 22:17:02',
                'updated_at' => '2025-02-15 22:17:02',
            ),
            4 => 
            array (
                'id' => 5,
                'warehouse_id' => 1,
                'is_completed' => 0,
                'is_resolved' => 0,
                'completed_by' => NULL,
                'resolved_by' => NULL,
                'created_at' => '2025-02-15 22:18:33',
                'updated_at' => '2025-02-15 22:18:33',
            ),
            5 => 
            array (
                'id' => 6,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-02-15 22:19:31',
                'updated_at' => '2025-02-15 22:22:35',
            ),
        ));
        
        
    }
}