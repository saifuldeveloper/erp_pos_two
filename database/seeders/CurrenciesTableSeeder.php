<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('currencies')->delete();
        
        \DB::table('currencies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Taka',
                'code' => '৳',
                'exchange_rate' => 1.0,
                'is_active' => 1,
                'created_at' => '2024-09-26 15:34:55',
                'updated_at' => '2024-09-26 15:34:55',
            ),
        ));
        
        
    }
}