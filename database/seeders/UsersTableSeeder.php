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
                'password' => '$2y$10$fYc3BnW7xZVgxZDTD8pNIu7u1hoQZNUAVI5AYx0GQEz1IbjkT92we',
                'remember_token' => NULL,
                'created_at' => '2023-08-12 10:51:23',
                'updated_at' => '2026-08-06 23:15:36',
                'phone' => '01816461193',
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
                'name' => 'Shafiq Islam',
                'email' => 'www.shofic@gmail.com',
                'password' => '$2y$10$/AfGtq1mtUiIUJs17PNHCOIkPsYO6/foKvsT5nc4Q9gJ/NVpFyYRi',
                'remember_token' => NULL,
                'created_at' => '2025-11-14 21:08:59',
                'updated_at' => '2026-07-21 14:10:36',
                'phone' => '01712090037',
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