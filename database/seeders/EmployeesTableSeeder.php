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
            1 => 
            array (
                'id' => 2,
                'name' => 'Kurban',
                'email' => 'kurban@avijatry.com',
                'phone_number' => '+8801956449453',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => '161024-313001',
                'image' => NULL,
                'address' => 'Khulna',
                'city' => 'Khulna',
                'country' => 'Bangladesh',
                'salary' => '12500.00',
                'is_active' => 1,
                'created_at' => '2025-02-15 21:54:25',
                'updated_at' => '2025-02-18 19:16:25',
            ),
        ));
        
        
    }
}