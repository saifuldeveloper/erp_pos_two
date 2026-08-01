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
                'sale_id' => 2,
                'payment_reference' => 'spr-20260726-054821',
                'amount' => 2000.0,
                'paying_method' => 'Cash',
                'payment_note' => NULL,
                'due_payment' => 0,
                'purchase_id' => NULL,
                'user_id' => 1,
                'account_id' => 1,
                'cash_register_id' => NULL,
                'used_points' => NULL,
                'change' => 0.0,
                'created_at' => '2026-07-26 17:48:21',
                'updated_at' => '2026-07-26 17:48:21',
            ),
        ));
        
        
    }
}