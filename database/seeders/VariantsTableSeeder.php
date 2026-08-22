<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VariantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('variants')->delete();
        
        \DB::table('variants')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Black/40',
                'created_at' => '2026-06-28 13:03:54',
                'updated_at' => '2026-06-28 13:03:54',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Black/41',
                'created_at' => '2026-06-28 13:03:54',
                'updated_at' => '2026-06-28 13:03:54',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Black/39',
                'created_at' => '2026-06-28 16:14:27',
                'updated_at' => '2026-06-28 16:14:27',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Black/42',
                'created_at' => '2026-06-28 16:14:27',
                'updated_at' => '2026-06-28 16:14:27',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Black/21',
                'created_at' => '2026-07-26 14:16:17',
                'updated_at' => '2026-07-26 14:16:17',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Black/22',
                'created_at' => '2026-07-26 14:16:17',
                'updated_at' => '2026-07-26 14:16:17',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Black/23',
                'created_at' => '2026-07-26 14:16:17',
                'updated_at' => '2026-07-26 14:16:17',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Black/24',
                'created_at' => '2026-07-26 14:16:17',
                'updated_at' => '2026-07-26 14:16:17',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Black/25',
                'created_at' => '2026-07-26 14:16:17',
                'updated_at' => '2026-07-26 14:16:17',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Green/21',
                'created_at' => '2026-07-26 14:25:49',
                'updated_at' => '2026-07-26 14:25:49',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Green/22',
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:25:50',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Green/23',
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:25:50',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Green/24',
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:25:50',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Green/25',
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:25:50',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Red/21',
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:25:50',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Red/22',
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:25:50',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Red/23',
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:25:50',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Red/24',
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:25:50',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Red/25',
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:25:50',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Green/12',
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:35:47',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Green/1232',
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:35:47',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Green/32',
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:35:47',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Green/321',
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:35:47',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Red/12',
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:35:47',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Red/1232',
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:35:47',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Red/32',
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:35:47',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Red/321',
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:35:47',
            ),
        ));
        
        
    }
}