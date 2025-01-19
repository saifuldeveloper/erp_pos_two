<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductTransferTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_transfer')->delete();
        
        
        
    }
}