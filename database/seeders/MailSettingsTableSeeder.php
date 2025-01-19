<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MailSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mail_settings')->delete();
        
        
        
    }
}