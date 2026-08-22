<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSalesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_sales')->delete();
        
        
        
    }
}