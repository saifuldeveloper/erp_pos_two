<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DiscountsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('discounts')->delete();
        
        \DB::table('discounts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'December 24 Discount',
                'applicable_for' => 'All',
                'product_list' => '',
                'valid_from' => '2024-12-27',
                'valid_till' => '2024-12-31',
                'type' => 'percentage',
                'value' => 10.0,
                'minimum_qty' => 1.0,
                'maximum_qty' => 200.0,
                'days' => 'Mon,Tue,Wed,Thu,Fri,Sat,Sun',
                'is_active' => 0,
                'created_at' => '2024-12-27 12:31:55',
                'updated_at' => '2024-12-31 17:18:56',
            ),
        ));
        
        
    }
}