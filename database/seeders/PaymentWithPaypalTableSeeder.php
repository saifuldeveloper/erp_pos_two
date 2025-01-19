<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentWithPaypalTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payment_with_paypal')->delete();
        
        
        
    }
}