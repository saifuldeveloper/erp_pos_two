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
                'site_title' => 'Avijatry Retailer',
                'site_logo' => '20260725025259.png',
                'currency' => '1',
                'currency_position' => 'prefix',
                'staff_access' => 'all',
                'date_format' => 'd-m-Y',
                'theme' => 'default.css',
                'developed_by' => NULL,
                'invoice_format' => 'standard',
                'state' => 1,
                'is_rtl' => 0,
                'decimal' => 2,
                'expiry_date' => NULL,
                'package_id' => NULL,
                'is_zatca' => 0,
                'company_name' => 'Avijatry',
                'vat_registration_number' => NULL,
                'without_stock' => 'no',
                'modules' => NULL,
                'created_at' => '2023-06-21 05:00:00',
                'updated_at' => '2026-07-25 14:52:59',
            ),
        ));
        
        
    }
}