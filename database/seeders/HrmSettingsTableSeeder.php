<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HrmSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('hrm_settings')->delete();
        
        \DB::table('hrm_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'checkin' => '10:00am',
                'checkout' => '6:00am',
                'created_at' => '2024-03-19 15:41:09',
                'updated_at' => '2024-04-24 15:34:31',
            ),
        ));
        
        
    }
}