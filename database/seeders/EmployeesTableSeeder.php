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
                'name' => 'Kamal Hosan',
                'email' => 'kamalavijatry@gmail.com',
                'phone_number' => '01845448568',
                'department_id' => 1,
                'user_id' => NULL,
                'staff_id' => '000001',
                'image' => '20241219115230.jpg',
                'address' => 'Muradnagar, Comilla',
                'city' => 'Muradnagar',
                'country' => NULL,
                'salary' => '50000.00',
                'is_active' => 0,
                'created_at' => '2024-12-19 11:52:31',
                'updated_at' => '2024-12-28 09:03:49',
            ),
        ));
        
        
    }
}