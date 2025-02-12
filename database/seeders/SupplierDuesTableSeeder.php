<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupplierDuesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('supplier_dues')->delete();
        
        
        
    }
}