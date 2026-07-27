<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('employees')->delete();
        
        \DB::table('employees')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Antor',
                'email' => NULL,
                'phone_number' => '0000',
                'department_id' => 1,
                'user_id' => NULL,
                'staff_id' => NULL,
                'image' => NULL,
                'address' => NULL,
                'city' => NULL,
                'country' => NULL,
                'salary' => '120000000.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2026-06-28 14:10:26',
                'updated_at' => '2026-06-28 14:10:26',
            ),
        ));
        
        
    }
}