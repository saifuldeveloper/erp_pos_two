<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TablesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tables')->delete();
        
        \DB::table('tables')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Buston',
                'number_of_person' => 5,
                'description' => NULL,
                'is_active' => 0,
                'created_at' => '2024-12-11 01:09:07',
                'updated_at' => '2024-12-21 00:57:48',
            ),
        ));
        
        
    }
}