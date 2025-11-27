<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'boss_khulna',
                'email' => 'khulna@avijatry.com',
                'password' => '$2y$12$tXfEWQ5ZuyXrBW6ciwC5yeAqLFonZVYwKDYlZv3LfiNNWHjEz/X5K',
                'remember_token' => NULL,
                'created_at' => '2023-08-12 10:51:23',
                'updated_at' => '2025-11-13 14:09:35',
                'phone' => '0',
                'company_name' => 'Avijatry Khulna',
                'role_id' => 1,
                'biller_id' => NULL,
                'warehouse_id' => NULL,
                'is_active' => 1,
                'is_deleted' => 0,
            ),
            1 => 
            array (
                'id' => 12,
                'name' => 'Emrul',
                'email' => 'emrul@gmail.com',
                'password' => '$2y$10$/AfGtq1mtUiIUJs17PNHCOIkPsYO6/foKvsT5nc4Q9gJ/NVpFyYRi',
                'remember_token' => NULL,
                'created_at' => '2025-11-14 21:08:59',
                'updated_at' => '2025-11-17 14:08:43',
                'phone' => '01',
                'company_name' => NULL,
                'role_id' => 2,
                'biller_id' => NULL,
                'warehouse_id' => NULL,
                'is_active' => 1,
                'is_deleted' => 0,
            ),
        ));
        
        
    }
}