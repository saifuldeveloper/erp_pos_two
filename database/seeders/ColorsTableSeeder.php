<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('colors')->delete();
        
        \DB::table('colors')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Black',
                'code' => NULL,
                'created_at' => '2026-06-28 12:37:07',
                'updated_at' => '2026-06-28 12:37:07',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Green',
                'code' => NULL,
                'created_at' => '2026-06-28 12:37:17',
                'updated_at' => '2026-06-28 12:37:17',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Red',
                'code' => NULL,
                'created_at' => '2026-06-28 12:37:27',
                'updated_at' => '2026-06-28 12:37:27',
            ),
        ));
        
        
    }
}