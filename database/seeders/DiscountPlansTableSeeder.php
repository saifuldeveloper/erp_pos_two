<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DiscountPlansTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('discount_plans')->delete();
        
        \DB::table('discount_plans')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '10% Discount',
                'is_active' => 0,
                'created_at' => '2024-12-27 06:26:59',
                'updated_at' => '2024-12-31 11:19:15',
            ),
        ));
        
        
    }
}