<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GiftCardsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('gift_cards')->delete();
        
        \DB::table('gift_cards')->insert(array (
            0 => 
            array (
                'id' => 1,
                'card_no' => '2013192904335784',
                'amount' => 1.0,
                'expense' => 0.0,
                'customer_id' => NULL,
                'user_id' => 6,
                'expired_date' => '2025-02-28',
                'created_by' => 1,
                'is_active' => 1,
                'created_at' => '2025-02-01 12:28:29',
                'updated_at' => '2025-02-01 12:28:29',
            ),
        ));
        
        
    }
}