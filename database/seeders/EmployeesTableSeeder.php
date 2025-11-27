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
                'salary_history' => NULL,
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
                'salary_history' => NULL,
                'is_active' => 0,
                'created_at' => '2025-02-15 21:54:25',
                'updated_at' => '2025-03-20 23:05:02',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Sakil',
                'email' => NULL,
                'phone_number' => '01996145624',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => '03',
                'image' => NULL,
                'address' => 'Tootpara',
                'city' => NULL,
                'country' => NULL,
                'salary' => '8000.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2025-10-05 23:03:15',
                'updated_at' => '2025-10-05 23:03:15',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Al-Amin',
                'email' => NULL,
                'phone_number' => '01516581487',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => '04',
                'image' => NULL,
                'address' => 'Rajapur',
                'city' => NULL,
                'country' => NULL,
                'salary' => '14500.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2025-10-07 22:31:48',
                'updated_at' => '2025-10-07 22:31:48',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Amin',
                'email' => 'e@gh.com',
                'phone_number' => '016',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => '05',
                'image' => NULL,
                'address' => 'Rajapur',
                'city' => NULL,
                'country' => NULL,
                'salary' => '3000.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2025-10-09 22:08:33',
                'updated_at' => '2025-10-09 22:09:04',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Said',
                'email' => NULL,
                'phone_number' => '01797447249',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => '02',
                'image' => NULL,
                'address' => 'Rajapur',
                'city' => NULL,
                'country' => NULL,
                'salary' => '11500.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2025-10-20 22:00:44',
                'updated_at' => '2025-10-20 22:00:44',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Imrul',
                'email' => NULL,
                'phone_number' => '01928219070',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => '01',
                'image' => NULL,
                'address' => 'Khulna',
                'city' => NULL,
                'country' => NULL,
                'salary' => '15000.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2025-10-20 22:01:26',
                'updated_at' => '2025-10-20 22:01:26',
            ),
        ));
        
        
    }
}