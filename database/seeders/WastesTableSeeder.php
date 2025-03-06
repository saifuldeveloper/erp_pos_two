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
                'receiver_type' => 'customer',
                'receiver_id' => 970,
                'receiver_name' => 'MITHU SB.',
                'note' => 'Mithu saheb 1023 article 40 size er ekta niche',
                'total_price' => '1495.00',
                'status' => 1,
                'created_at' => '2025-03-07 05:35:28',
                'updated_at' => '2025-03-07 05:35:28',
            ),
        ));
        
        
    }
}