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
                'image' => '20241007040713.png',
                'is_active' => 1,
                'created_at' => '2024-10-07 16:07:13',
                'updated_at' => '2024-10-07 16:07:13',
            ),
            1 =>
            array (
                'id' => 2,
                'title' => 'Apex',
                'image' => '20241007040726.jpeg',
                'is_active' => 1,
                'created_at' => '2024-10-07 16:07:26',
                'updated_at' => '2024-10-07 16:07:26',
            ),
            2 =>
            array (
                'id' => 3,
                'title' => 'Bata',
                'image' => '20241007040816.png',
                'is_active' => 1,
                'created_at' => '2024-10-07 16:08:16',
                'updated_at' => '2024-10-07 16:08:16',
            ),
            3 =>
            array (
                'id' => 4,
                'title' => 'Lotto',
                'image' => '20241007040829.png',
                'is_active' => 1,
                'created_at' => '2024-10-07 16:08:29',
                'updated_at' => '2024-10-07 16:08:29',
            ),
        ));


    }
}
