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
                'unit_code' => NULL,
                'unit_name' => 'Pair',
                'base_unit' => NULL,
                'operator' => '*',
                'operation_value' => 1.0,
                'is_active' => 1,
                'created_at' => '2025-04-19 19:10:31',
                'updated_at' => '2025-04-19 19:10:44',
            ),
            1 => 
            array (
                'id' => 2,
                'unit_code' => NULL,
                'unit_name' => 'Pieces',
                'base_unit' => NULL,
                'operator' => '*',
                'operation_value' => 1.0,
                'is_active' => 1,
                'created_at' => '2025-04-19 19:10:55',
                'updated_at' => '2025-04-19 19:10:55',
            ),
        ));
        
        
    }
}