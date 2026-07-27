<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WastesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('wastes')->delete();
        
        \DB::table('wastes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'receiver_type' => 'supplier',
                'receiver_id' => 1,
                'receiver_name' => 'Avijatry',
                'note' => NULL,
                'total_price' => '1500.00',
                'status' => 1,
                'created_at' => '2026-06-28 13:48:51',
                'updated_at' => '2026-06-28 13:48:51',
            ),
        ));
        
        
    }
}