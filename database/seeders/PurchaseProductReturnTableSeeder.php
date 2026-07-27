<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseProductReturnTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_product_return')->delete();
        
        
        
    }
}