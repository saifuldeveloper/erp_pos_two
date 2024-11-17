<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('units')->delete();
        
        \DB::table('units')->insert(array (
            0 => 
            array (
                'id' => 1,
                'unit_name' => 'Pair',
                'operator' => '*',
                'operation_value' => 1,
                'base_unit' => NULL,
                'is_active' => 1,
                'created_at' => '2024-10-07 16:12:13',
                'updated_at' => '2024-10-07 16:12:28',
            ),
        ));
        
        
    }
}