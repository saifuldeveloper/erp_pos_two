<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransfersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('transfers')->delete();
        
        \DB::table('transfers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'reference_no' => 'tr-20260619-034214',
                'user_id' => 1,
                'status' => 1,
                'from_warehouse_id' => 2,
                'to_warehouse_id' => 1,
                'item' => 2,
                'total_qty' => 2.0,
                'total_tax' => 0.0,
                'total_cost' => 1116.0,
                'shipping_cost' => NULL,
                'grand_total' => 1116.0,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-06-19 00:00:00',
                'updated_at' => '2026-06-19 15:42:14',
            ),
            1 => 
            array (
                'id' => 2,
                'reference_no' => 'tr-20260620-032707',
                'user_id' => 5,
                'status' => 1,
                'from_warehouse_id' => 2,
                'to_warehouse_id' => 1,
                'item' => 4,
                'total_qty' => 4.0,
                'total_tax' => 0.0,
                'total_cost' => 8400.0,
                'shipping_cost' => NULL,
                'grand_total' => 8400.0,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-06-20 00:00:00',
                'updated_at' => '2026-06-20 15:27:07',
            ),
            2 => 
            array (
                'id' => 3,
                'reference_no' => 'tr-20260620-033033',
                'user_id' => 5,
                'status' => 1,
                'from_warehouse_id' => 2,
                'to_warehouse_id' => 1,
                'item' => 2,
                'total_qty' => 2.0,
                'total_tax' => 0.0,
                'total_cost' => 939.0,
                'shipping_cost' => NULL,
                'grand_total' => 939.0,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-06-20 00:00:00',
                'updated_at' => '2026-06-20 15:30:33',
            ),
            3 => 
            array (
                'id' => 4,
                'reference_no' => 'tr-20260620-063053',
                'user_id' => 5,
                'status' => 1,
                'from_warehouse_id' => 2,
                'to_warehouse_id' => 1,
                'item' => 5,
                'total_qty' => 5.0,
                'total_tax' => 0.0,
                'total_cost' => 4235.0,
                'shipping_cost' => NULL,
                'grand_total' => 4235.0,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-06-20 00:00:00',
                'updated_at' => '2026-06-20 18:30:53',
            ),
            4 => 
            array (
                'id' => 5,
                'reference_no' => 'tr-20260621-071448',
                'user_id' => 5,
                'status' => 1,
                'from_warehouse_id' => 2,
                'to_warehouse_id' => 1,
                'item' => 1,
                'total_qty' => 1.0,
                'total_tax' => 0.0,
                'total_cost' => 780.0,
                'shipping_cost' => NULL,
                'grand_total' => 780.0,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-06-21 00:00:00',
                'updated_at' => '2026-06-21 19:14:48',
            ),
            5 => 
            array (
                'id' => 6,
                'reference_no' => 'tr-20260622-011732',
                'user_id' => 1,
                'status' => 1,
                'from_warehouse_id' => 2,
                'to_warehouse_id' => 1,
                'item' => 27,
                'total_qty' => 27.0,
                'total_tax' => 0.0,
                'total_cost' => 22116.0,
                'shipping_cost' => NULL,
                'grand_total' => 22116.0,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-06-22 00:00:00',
                'updated_at' => '2026-06-22 01:17:32',
            ),
            6 => 
            array (
                'id' => 7,
                'reference_no' => 'tr-20260622-122935',
                'user_id' => 1,
                'status' => 1,
                'from_warehouse_id' => 2,
                'to_warehouse_id' => 1,
                'item' => 23,
                'total_qty' => 23.0,
                'total_tax' => 0.0,
                'total_cost' => 23940.0,
                'shipping_cost' => NULL,
                'grand_total' => 23940.0,
                'document' => NULL,
                'note' => NULL,
                'created_at' => '2026-06-22 00:00:00',
                'updated_at' => '2026-06-22 12:29:35',
            ),
        ));
        
        
    }
}