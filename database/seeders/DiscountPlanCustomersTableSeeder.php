<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DiscountPlanCustomersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('discount_plan_customers')->delete();
        
        \DB::table('discount_plan_customers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'discount_plan_id' => 1,
                'customer_id' => 1,
                'created_at' => '2024-12-27 18:26:59',
                'updated_at' => '2024-12-27 18:26:59',
            ),
        ));
        
        
    }
}