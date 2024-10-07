<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('brands')->delete();
        
        \DB::table('brands')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'apple',
                'image' => NULL,
                'is_active' => 1,
                'created_at' => '2024-10-07 18:17:29',
                'updated_at' => '2024-10-07 18:17:29',
            ),
        ));
        
        
    }
}