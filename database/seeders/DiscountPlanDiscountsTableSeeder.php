<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DiscountPlanDiscountsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('discount_plan_discounts')->delete();
        
        \DB::table('discount_plan_discounts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'discount_id' => 1,
                'discount_plan_id' => 1,
                'created_at' => '2024-12-27 18:31:55',
                'updated_at' => '2024-12-27 18:31:55',
            ),
        ));
        
        
    }
}