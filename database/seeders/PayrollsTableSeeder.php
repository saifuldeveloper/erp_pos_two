<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PayrollsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('payrolls')->delete();

        \DB::table('payrolls')->insert(array (
            0 =>
            array (
                'id' => 2,
                'payroll_type_id' => 1,
                'reference_no' => 'payroll-20250218-071831',
                'employee_id' => 2,
                'account_id' => 1,
                'user_id' => 3,
                'salary' => 12500.0,
                'amount' => 2500.0,
                'paying_method' => '0',
                'note' => NULL,
                'created_at' => '2025-02-18 12:12:00',
                'updated_at' => '2025-02-18 19:18:31',
            ),
        ));


    }
}
