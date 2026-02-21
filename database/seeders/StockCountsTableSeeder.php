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
                'created_at' => '2025-02-12 12:21:50',
                'updated_at' => '2025-02-15 16:14:37',
            ),
            1 => 
            array (
                'id' => 2,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 3,
                'resolved_by' => 3,
                'created_at' => '2025-02-15 16:15:05',
                'updated_at' => '2025-02-18 12:59:36',
            ),
            2 => 
            array (
                'id' => 3,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 3,
                'resolved_by' => 3,
                'created_at' => '2025-02-15 16:16:48',
                'updated_at' => '2025-02-18 13:10:11',
            ),
            3 => 
            array (
                'id' => 4,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-02-15 16:17:02',
                'updated_at' => '2025-03-08 16:32:30',
            ),
            4 => 
            array (
                'id' => 5,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-02-15 16:18:33',
                'updated_at' => '2025-03-08 16:34:20',
            ),
            5 => 
            array (
                'id' => 6,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-02-15 16:19:31',
                'updated_at' => '2025-02-15 16:22:35',
            ),
            6 => 
            array (
                'id' => 7,
                'warehouse_id' => 4,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 5,
                'resolved_by' => 5,
                'created_at' => '2025-03-08 16:34:58',
                'updated_at' => '2025-03-21 19:14:42',
            ),
            7 => 
            array (
                'id' => 8,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 6,
                'resolved_by' => 6,
                'created_at' => '2025-03-21 22:39:50',
                'updated_at' => '2025-03-21 22:43:29',
            ),
            8 => 
            array (
                'id' => 9,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-03-21 22:43:45',
                'updated_at' => '2025-04-30 22:51:22',
            ),
            9 => 
            array (
                'id' => 10,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-04-30 22:51:43',
                'updated_at' => '2025-04-30 22:54:16',
            ),
            10 => 
            array (
                'id' => 11,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-04-30 23:02:01',
                'updated_at' => '2025-10-02 07:41:51',
            ),
            11 => 
            array (
                'id' => 12,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 09:05:56',
                'updated_at' => '2025-10-02 09:07:59',
            ),
            12 => 
            array (
                'id' => 13,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 09:08:08',
                'updated_at' => '2025-10-02 09:08:47',
            ),
            13 => 
            array (
                'id' => 14,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 09:09:20',
                'updated_at' => '2025-10-02 09:09:49',
            ),
            14 => 
            array (
                'id' => 15,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 09:10:02',
                'updated_at' => '2025-10-02 09:10:38',
            ),
            15 => 
            array (
                'id' => 16,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 09:10:45',
                'updated_at' => '2025-10-02 09:11:33',
            ),
            16 => 
            array (
                'id' => 17,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 09:11:40',
                'updated_at' => '2025-10-02 09:13:37',
            ),
            17 => 
            array (
                'id' => 18,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 09:13:43',
                'updated_at' => '2025-10-02 09:14:22',
            ),
            18 => 
            array (
                'id' => 19,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 09:14:38',
                'updated_at' => '2025-10-02 09:16:00',
            ),
            19 => 
            array (
                'id' => 20,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 09:16:12',
                'updated_at' => '2025-10-02 09:18:31',
            ),
            20 => 
            array (
                'id' => 21,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 09:18:37',
                'updated_at' => '2025-10-02 09:19:52',
            ),
            21 => 
            array (
                'id' => 22,
                'warehouse_id' => 4,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-02 09:20:05',
                'updated_at' => '2025-10-05 06:17:23',
            ),
            22 => 
            array (
                'id' => 23,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-05 06:17:36',
                'updated_at' => '2025-10-05 09:14:48',
            ),
            23 => 
            array (
                'id' => 24,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-05 09:16:00',
                'updated_at' => '2025-10-06 12:39:00',
            ),
            24 => 
            array (
                'id' => 25,
                'warehouse_id' => 4,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 12:41:45',
                'updated_at' => '2025-10-06 12:45:20',
            ),
            25 => 
            array (
                'id' => 26,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 12:59:50',
                'updated_at' => '2025-10-06 14:27:07',
            ),
            26 => 
            array (
                'id' => 27,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 14:29:47',
                'updated_at' => '2025-10-06 14:40:29',
            ),
            27 => 
            array (
                'id' => 28,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 15:26:54',
                'updated_at' => '2025-10-06 15:27:54',
            ),
            28 => 
            array (
                'id' => 29,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 15:46:26',
                'updated_at' => '2025-10-06 15:47:54',
            ),
            29 => 
            array (
                'id' => 30,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 16:12:52',
                'updated_at' => '2025-10-06 16:35:37',
            ),
            30 => 
            array (
                'id' => 31,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 16:37:58',
                'updated_at' => '2025-10-06 16:38:19',
            ),
            31 => 
            array (
                'id' => 32,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 16:39:34',
                'updated_at' => '2025-10-06 16:42:11',
            ),
            32 => 
            array (
                'id' => 33,
                'warehouse_id' => 1,
                'is_completed' => 1,
                'is_resolved' => 1,
                'completed_by' => 1,
                'resolved_by' => 1,
                'created_at' => '2025-10-06 16:42:21',
                'updated_at' => '2025-10-06 16:43:24',
            ),
        ));
        
        
    }
}