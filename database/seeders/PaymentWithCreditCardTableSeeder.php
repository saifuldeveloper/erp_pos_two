<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentWithCreditCardTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payment_with_credit_card')->delete();
        
        
        
    }
}