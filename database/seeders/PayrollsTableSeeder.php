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
                'id' => 1,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251005-110412',
                'employee_id' => 3,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 8000.0,
                'amount' => 7000.0,
                'paying_method' => '0',
                'note' => 'September Salary',
                'created_at' => '2025-10-05 23:03:00',
                'updated_at' => '2025-10-05 23:04:12',
            ),
            1 => 
            array (
                'id' => 2,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251007-103233',
                'employee_id' => 4,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 14500.0,
                'amount' => 3000.0,
                'paying_method' => '0',
                'note' => NULL,
                'created_at' => '2025-10-06 22:32:00',
                'updated_at' => '2025-10-07 22:32:33',
            ),
            2 => 
            array (
                'id' => 3,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251009-100939',
                'employee_id' => 4,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 14500.0,
                'amount' => 7500.0,
                'paying_method' => '0',
                'note' => 'September',
                'created_at' => '2025-10-09 22:09:00',
                'updated_at' => '2025-10-09 22:09:39',
            ),
            3 => 
            array (
                'id' => 4,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251009-101040',
                'employee_id' => 5,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 3000.0,
                'amount' => 5500.0,
                'paying_method' => '0',
                'note' => 'August+September',
                'created_at' => '2025-10-09 22:09:00',
                'updated_at' => '2025-10-09 22:10:40',
            ),
            4 => 
            array (
                'id' => 5,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251020-100243',
                'employee_id' => 3,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 8000.0,
                'amount' => 4000.0,
                'paying_method' => '0',
                'note' => NULL,
                'created_at' => '2025-10-20 22:02:00',
                'updated_at' => '2025-10-20 22:02:43',
            ),
            5 => 
            array (
                'id' => 6,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251020-100306',
                'employee_id' => 4,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 14500.0,
                'amount' => 7250.0,
                'paying_method' => '0',
                'note' => NULL,
                'created_at' => '2025-10-20 22:02:00',
                'updated_at' => '2025-10-20 22:03:06',
            ),
            6 => 
            array (
                'id' => 7,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251020-100319',
                'employee_id' => 5,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 3000.0,
                'amount' => 1500.0,
                'paying_method' => '0',
                'note' => NULL,
                'created_at' => '2025-10-20 22:03:00',
                'updated_at' => '2025-10-20 22:03:19',
            ),
            7 => 
            array (
                'id' => 8,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251020-100333',
                'employee_id' => 6,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 11500.0,
                'amount' => 2250.0,
                'paying_method' => '0',
                'note' => NULL,
                'created_at' => '2025-10-20 22:03:00',
                'updated_at' => '2025-10-20 22:03:33',
            ),
            8 => 
            array (
                'id' => 9,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251020-100345',
                'employee_id' => 7,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 15000.0,
                'amount' => 7500.0,
                'paying_method' => '0',
                'note' => NULL,
                'created_at' => '2025-10-20 22:03:00',
                'updated_at' => '2025-10-20 22:03:45',
            ),
            9 => 
            array (
                'id' => 10,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251106-093109',
                'employee_id' => 3,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 8000.0,
                'amount' => 4000.0,
                'paying_method' => '0',
                'note' => 'October',
                'created_at' => '2025-11-06 21:30:00',
                'updated_at' => '2025-11-06 21:31:09',
            ),
            10 => 
            array (
                'id' => 11,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251106-093141',
                'employee_id' => 4,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 14500.0,
                'amount' => 7250.0,
                'paying_method' => '0',
                'note' => 'October',
                'created_at' => '2025-11-06 21:31:00',
                'updated_at' => '2025-11-06 21:31:41',
            ),
            11 => 
            array (
                'id' => 12,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251106-093155',
                'employee_id' => 5,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 3000.0,
                'amount' => 1500.0,
                'paying_method' => '0',
                'note' => 'October',
                'created_at' => '2025-11-06 21:31:00',
                'updated_at' => '2025-11-06 21:31:55',
            ),
            12 => 
            array (
                'id' => 13,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251106-093221',
                'employee_id' => 6,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 11500.0,
                'amount' => 5750.0,
                'paying_method' => '0',
                'note' => 'October',
                'created_at' => '2025-11-06 21:31:00',
                'updated_at' => '2025-11-06 21:32:21',
            ),
            13 => 
            array (
                'id' => 14,
                'payroll_type_id' => '1',
                'reference_no' => 'payroll-20251106-093236',
                'employee_id' => 7,
                'account_id' => 1,
                'user_id' => 1,
                'salary' => 15000.0,
                'amount' => 7500.0,
                'paying_method' => '0',
                'note' => 'October',
                'created_at' => '2025-11-06 21:32:00',
                'updated_at' => '2025-11-06 21:32:36',
            ),
        ));
        
        
    }
}