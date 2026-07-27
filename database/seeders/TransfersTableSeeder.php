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
                'reference_no' => 'tr-20260726-054821-6a65f40531131',
                'user_id' => 1,
                'status' => 1,
                'from_warehouse_id' => 2,
                'to_warehouse_id' => 1,
                'item' => 1,
                'total_qty' => 1.0,
                'total_tax' => 0.0,
                'total_cost' => 1000.0,
                'shipping_cost' => 0.0,
                'grand_total' => 1000.0,
                'document' => NULL,
                'note' => 'Auto-transfer created during POS sale #2',
                'created_at' => '2026-07-26 17:48:21',
                'updated_at' => '2026-07-26 17:48:21',
            ),
        ));
        
        
    }
}