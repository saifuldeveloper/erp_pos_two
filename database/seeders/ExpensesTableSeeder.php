<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExpensesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('expenses')->delete();
        
        \DB::table('expenses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'reference_no' => 'er-20260628-015311',
                'expense_category_id' => 2,
                'warehouse_id' => 1,
                'amount' => 100.0,
                'note' => NULL,
                'account_id' => 1,
                'user_id' => 1,
                'cash_register_id' => NULL,
                'created_at' => '2026-06-28 12:00:00',
                'updated_at' => '2026-06-28 13:53:11',
            ),
        ));
        
        
    }
}