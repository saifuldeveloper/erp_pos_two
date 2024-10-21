<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('customer_groups')->delete();
        
        \DB::table('customer_groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'General Customer',
                'percentage' => '0',
                'is_active' => 1,
                'created_at' => '2024-10-07 20:06:18',
                'updated_at' => '2024-10-07 20:06:18',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'wholesale Customer',
                'percentage' => '0',
                'is_active' => 1,
                'created_at' => '2024-10-07 20:06:37',
                'updated_at' => '2024-10-07 20:06:37',
            ),
        ));
        
        
    }
}