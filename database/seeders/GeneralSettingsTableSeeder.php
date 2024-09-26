<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GeneralSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('general_settings')->delete();
        
        \DB::table('general_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'site_title' => 'Pos',
                'site_logo' => '20240926032857.png',
                'is_rtl' => 0,
                'created_at' => '2023-06-21 05:00:00',
                'updated_at' => '2024-09-26 15:28:57',
                'currency' => '1',
                'package_id' => NULL,
                'staff_access' => 'all',
                'without_stock' => 'no',
                'date_format' => 'd-m-Y',
                'developed_by' => 'SaifulDeveloper',
                'invoice_format' => 'standard',
                'decimal' => 2,
                'state' => 1,
                'theme' => 'default.css',
                'modules' => NULL,
                'currency_position' => 'prefix',
                'expiry_date' => NULL,
                'is_zatca' => 0,
                'company_name' => NULL,
                'vat_registration_number' => NULL,
            ),
        ));
        
        
    }
}