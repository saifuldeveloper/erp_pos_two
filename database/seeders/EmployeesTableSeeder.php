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
                'name' => 'Md Jahidul Hoq',
                'email' => NULL,
                'phone_number' => '01959551394',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => '0001',
                'image' => NULL,
                'address' => 'Muradnagar, Cumilla',
                'city' => NULL,
                'country' => NULL,
                'salary' => '17000.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2025-04-26 17:18:13',
                'updated_at' => '2025-04-26 17:18:13',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Abdul Malek',
                'email' => NULL,
                'phone_number' => '01608413932',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => '0002',
                'image' => NULL,
                'address' => 'Kajpur, Narayanganj',
                'city' => NULL,
                'country' => NULL,
                'salary' => '18000.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2025-04-26 17:23:14',
                'updated_at' => '2025-04-26 17:23:14',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Md Faysal Sarker',
                'email' => NULL,
                'phone_number' => '01301412140',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => '0003',
                'image' => NULL,
                'address' => 'Kajiyatol, Muradnagar, Cumilla',
                'city' => NULL,
                'country' => NULL,
                'salary' => '13000.00',
                'salary_history' => '[{"date":"2026-05-06","current_salary":"11000.00","adjustment_amount":"2000","final_salary":"13000.00"}]',
                'is_active' => 1,
                'created_at' => '2025-04-26 17:24:31',
                'updated_at' => '2026-05-06 20:00:45',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Setu Babu',
                'email' => NULL,
                'phone_number' => '01828547733',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => '0004',
                'image' => NULL,
                'address' => 'Dokkhin Thakur Para, Cumilla Sadar',
                'city' => NULL,
                'country' => NULL,
                'salary' => '15000.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2025-04-26 17:26:20',
                'updated_at' => '2025-04-26 17:26:20',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Md Masum',
                'email' => NULL,
                'phone_number' => '01317612477',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => '0004',
                'image' => NULL,
                'address' => 'Raitola, Muradnagar, Cumilla',
                'city' => NULL,
                'country' => NULL,
                'salary' => '10000.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2025-04-26 17:27:17',
                'updated_at' => '2025-04-26 17:27:17',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Shahadat',
                'email' => NULL,
                'phone_number' => '01322215736',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => NULL,
                'image' => NULL,
                'address' => NULL,
                'city' => NULL,
                'country' => NULL,
                'salary' => '8000.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2025-10-09 13:49:23',
                'updated_at' => '2025-10-09 13:49:23',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Eid Extra Worker Salary 2026',
                'email' => NULL,
                'phone_number' => '00000',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => NULL,
                'image' => NULL,
                'address' => NULL,
                'city' => NULL,
                'country' => NULL,
                'salary' => '40000.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2026-03-02 23:51:09',
                'updated_at' => '2026-03-02 23:51:09',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Hamim',
                'email' => NULL,
                'phone_number' => '01950070219',
                'department_id' => 3,
                'user_id' => NULL,
                'staff_id' => NULL,
                'image' => NULL,
                'address' => 'Dawlatpur',
                'city' => NULL,
                'country' => NULL,
                'salary' => '7000.00',
                'salary_history' => NULL,
                'is_active' => 1,
                'created_at' => '2026-05-05 18:46:24',
                'updated_at' => '2026-05-05 18:46:24',
            ),
        ));
        
        
    }
}