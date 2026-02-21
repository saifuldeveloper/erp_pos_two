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
                'created_at' => '2024-10-07 10:12:13',
                'updated_at' => '2024-10-07 10:12:28',
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
                'created_at' => '2025-01-04 14:09:56',
                'updated_at' => '2025-01-07 06:18:02',
            ),
            2 => 
            array (
                'id' => 3,
                'unit_code' => NULL,
                'unit_name' => '120',
                'base_unit' => NULL,
                'operator' => '*',
                'operation_value' => 1.0,
                'is_active' => 0,
                'created_at' => '2025-01-06 18:40:20',
                'updated_at' => '2025-01-06 18:40:39',
            ),
        ));
        
        
    }
}