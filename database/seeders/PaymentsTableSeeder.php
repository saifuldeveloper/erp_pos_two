<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payments')->delete();
        
        \DB::table('payments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'purchase_id' => NULL,
                'sale_id' => 2,
                'cash_register_id' => NULL,
                'account_id' => 1,
                'payment_reference' => 'spr-20260726-054821',
                'user_id' => 1,
                'amount' => 2000.0,
                'used_points' => NULL,
                'paying_method' => 'Cash',
                'payment_note' => NULL,
                'due_payment' => 0,
                'created_at' => '2026-07-26 17:48:21',
                'updated_at' => '2026-07-26 17:48:21',
                'change' => 0.0,
            ),
        ));
        
        
    }
}