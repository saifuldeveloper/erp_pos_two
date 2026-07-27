<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExpenseCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('expense_categories')->delete();
        
        \DB::table('expense_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '1',
                'name' => 'Daily Expence',
                'is_active' => 1,
                'created_at' => '2026-06-28 13:50:25',
                'updated_at' => '2026-06-28 13:50:43',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '2',
                'name' => 'Tiffen',
                'is_active' => 1,
                'created_at' => '2026-06-28 13:52:06',
                'updated_at' => '2026-06-28 13:52:06',
            ),
        ));
        
        
    }
}