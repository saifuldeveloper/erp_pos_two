<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CouriersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('couriers')->delete();
        
        
        
    }
}