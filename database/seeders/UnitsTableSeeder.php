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
                'unit_code' => 'Pcs',
                'unit_name' => 'Piece',
                'base_unit' => NULL,
                'operator' => '*',
                'operation_value' => 1.0,
                'is_active' => 1,
                'created_at' => '2024-10-07 18:17:57',
                'updated_at' => '2024-10-07 18:17:57',
            ),
        ));
        
        
    }
}