<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PosSettingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pos_setting')->delete();
        
        \DB::table('pos_setting')->insert(array (
            0 => 
            array (
                'id' => 1,
                'customer_id' => 1,
                'warehouse_id' => 1,
                'biller_id' => 1,
                'product_number' => 4,
                'keybord_active' => 0,
                'is_table' => 0,
                'stripe_public_key' => NULL,
                'stripe_secret_key' => NULL,
                'paypal_live_api_username' => NULL,
                'paypal_live_api_password' => NULL,
                'paypal_live_api_secret' => NULL,
                'payment_options' => 'cash',
                'invoice_option' => 'A4',
                'created_at' => '2024-10-08 19:59:44',
                'updated_at' => '2024-10-08 19:59:44',
            ),
        ));
        
        
    }
}