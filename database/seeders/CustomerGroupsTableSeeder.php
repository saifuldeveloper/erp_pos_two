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
                'name' => 'General',
                'percentage' => '0',
                'is_active' => 1,
                'created_at' => '2024-09-28 04:16:09',
                'updated_at' => '2024-09-28 04:16:09',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Whole Sale',
                'percentage' => '10',
                'is_active' => 1,
                'created_at' => '2024-09-28 04:16:22',
                'updated_at' => '2024-09-28 04:16:22',
            ),
        ));
        
        
    }
}