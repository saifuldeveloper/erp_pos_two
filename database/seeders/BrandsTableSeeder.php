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
                'title' => 'Avijatry',
                'image' => '20260628123405.png',
                'is_active' => 0,
                'created_at' => '2026-06-28 12:34:05',
                'updated_at' => '2026-06-28 12:34:22',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Avijatry',
                'image' => '20260628123539.png',
                'is_active' => 1,
                'created_at' => '2026-06-28 12:35:39',
                'updated_at' => '2026-06-28 12:35:39',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Bata',
                'image' => NULL,
                'is_active' => 1,
                'created_at' => '2026-06-28 12:58:39',
                'updated_at' => '2026-06-28 12:58:39',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Loto',
                'image' => NULL,
                'is_active' => 1,
                'created_at' => '2026-06-28 12:58:48',
                'updated_at' => '2026-06-28 12:58:48',
            ),
        ));
        
        
    }
}