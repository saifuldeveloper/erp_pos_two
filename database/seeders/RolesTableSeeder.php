<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin',
                'description' => 'Admins have full access to the system',
                'is_active' => 1,
                'created_at' => '2018-06-01 22:46:44',
                'updated_at' => '2023-06-21 13:38:36',
                'guard_name' => 'web',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Owner',
                'description' => 'Full access to the system except technical aspects.',
                'is_active' => 1,
                'created_at' => '2018-10-22 01:38:13',
                'updated_at' => '2023-09-16 23:07:38',
                'guard_name' => 'web',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Manager',
                'description' => 'Cashier has limited access to sales data',
                'is_active' => 1,
                'created_at' => '2018-06-01 23:05:27',
                'updated_at' => '2024-12-22 01:37:46',
                'guard_name' => 'web',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'Billers',
                'description' => 'Billerss can access their own data',
                'is_active' => 1,
                'created_at' => '2020-11-05 05:43:16',
                'updated_at' => '2020-11-14 23:24:15',
                'guard_name' => 'web',
            ),
            4 => 
            array (
                'id' => 6,
            'name' => 'Admin (Demo)',
                'description' => 'Demo admin with restricted access to system settings',
                'is_active' => 0,
                'created_at' => '2023-08-12 07:55:13',
                'updated_at' => '2024-12-22 01:41:38',
                'guard_name' => 'web',
            ),
            5 => 
            array (
                'id' => 7,
                'name' => 'Salesman',
                'description' => NULL,
                'is_active' => 0,
                'created_at' => '2024-12-11 02:11:03',
                'updated_at' => '2024-12-21 00:58:10',
                'guard_name' => 'web',
            ),
            6 => 
            array (
                'id' => 8,
                'name' => 'Management',
                'description' => NULL,
                'is_active' => 1,
                'created_at' => '2024-12-22 01:23:34',
                'updated_at' => '2024-12-22 01:23:34',
                'guard_name' => 'web',
            ),
        ));
        
        
    }
}