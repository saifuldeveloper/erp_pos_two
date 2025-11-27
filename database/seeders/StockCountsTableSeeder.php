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
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-02-15 22:17:02',
                'updated_at' => '2025-03-08 22:32:30',
            ),
            4 => 
            array (
                'id' => 5,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-02-15 22:18:33',
                'updated_at' => '2025-03-08 22:34:20',
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
            6 => 
            array (
                'id' => 7,
                'warehouse_id' => 4,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 5,
                'resolved_by' => 5,
                'created_at' => '2025-03-08 22:34:58',
                'updated_at' => '2025-03-22 01:14:42',
            ),
            7 => 
            array (
                'id' => 8,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 6,
                'resolved_by' => 6,
                'created_at' => '2025-03-22 04:39:50',
                'updated_at' => '2025-03-22 04:43:29',
            ),
            8 => 
            array (
                'id' => 9,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-03-22 04:43:45',
                'updated_at' => '2025-05-01 04:51:22',
            ),
            9 => 
            array (
                'id' => 10,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-05-01 04:51:43',
                'updated_at' => '2025-05-01 04:54:16',
            ),
            10 => 
            array (
                'id' => 11,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-05-01 05:02:01',
                'updated_at' => '2025-10-02 13:41:51',
            ),
            11 => 
            array (
                'id' => 12,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 15:05:56',
                'updated_at' => '2025-10-02 15:07:59',
            ),
            12 => 
            array (
                'id' => 13,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 15:08:08',
                'updated_at' => '2025-10-02 15:08:47',
            ),
            13 => 
            array (
                'id' => 14,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 15:09:20',
                'updated_at' => '2025-10-02 15:09:49',
            ),
            14 => 
            array (
                'id' => 15,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 15:10:02',
                'updated_at' => '2025-10-02 15:10:38',
            ),
            15 => 
            array (
                'id' => 16,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 15:10:45',
                'updated_at' => '2025-10-02 15:11:33',
            ),
            16 => 
            array (
                'id' => 17,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 15:11:40',
                'updated_at' => '2025-10-02 15:13:37',
            ),
            17 => 
            array (
                'id' => 18,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 15:13:43',
                'updated_at' => '2025-10-02 15:14:22',
            ),
            18 => 
            array (
                'id' => 19,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 15:14:38',
                'updated_at' => '2025-10-02 15:16:00',
            ),
            19 => 
            array (
                'id' => 20,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 15:16:12',
                'updated_at' => '2025-10-02 15:18:31',
            ),
            20 => 
            array (
                'id' => 21,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 15:18:37',
                'updated_at' => '2025-10-02 15:19:52',
            ),
            21 => 
            array (
                'id' => 22,
                'warehouse_id' => 4,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 15:20:05',
                'updated_at' => '2025-10-05 12:17:23',
            ),
            22 => 
            array (
                'id' => 23,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-05 12:17:36',
                'updated_at' => '2025-10-05 15:14:48',
            ),
            23 => 
            array (
                'id' => 24,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-05 15:16:00',
                'updated_at' => '2025-10-06 18:39:00',
            ),
            24 => 
            array (
                'id' => 25,
                'warehouse_id' => 4,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 18:41:45',
                'updated_at' => '2025-10-06 18:45:20',
            ),
            25 => 
            array (
                'id' => 26,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 18:59:50',
                'updated_at' => '2025-10-06 20:27:07',
            ),
            26 => 
            array (
                'id' => 27,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 20:29:47',
                'updated_at' => '2025-10-06 20:40:29',
            ),
            27 => 
            array (
                'id' => 28,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 21:26:54',
                'updated_at' => '2025-10-06 21:27:54',
            ),
            28 => 
            array (
                'id' => 29,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 21:46:26',
                'updated_at' => '2025-10-06 21:47:54',
            ),
            29 => 
            array (
                'id' => 30,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 22:12:52',
                'updated_at' => '2025-10-06 22:35:37',
            ),
            30 => 
            array (
                'id' => 31,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 22:37:58',
                'updated_at' => '2025-10-06 22:38:19',
            ),
            31 => 
            array (
                'id' => 32,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 22:39:34',
                'updated_at' => '2025-10-06 22:42:11',
            ),
            32 => 
            array (
                'id' => 33,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 22:42:21',
                'updated_at' => '2025-10-06 22:43:24',
            ),
        ));
        
        
    }
}