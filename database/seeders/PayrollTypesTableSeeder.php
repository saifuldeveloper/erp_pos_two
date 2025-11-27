<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PayrollTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payroll_types')->delete();
        
        \DB::table('payroll_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Salary',
                'slug' => 'salary',
                'status' => 'Active',
                'created_at' => '2025-04-08 21:38:02',
                'updated_at' => '2025-04-08 21:49:13',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Overtime',
                'slug' => 'overtime',
                'status' => 'Active',
                'created_at' => '2025-04-08 21:39:11',
                'updated_at' => '2025-04-08 21:50:06',
            ),
        ));
        
        
    }
}