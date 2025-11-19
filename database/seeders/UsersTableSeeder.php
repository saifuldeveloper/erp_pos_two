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
                'name' => 'boss_cumilla',
                'email' => 'cumilla@avijatry.com',
                'password' => '$2y$12$GmvJozHFbJm35heJXqVT8eylKoCpBq26zlFVF0c644RfiJz4aWXxG',
                'remember_token' => NULL,
                'created_at' => '2023-08-12 16:51:23',
                'updated_at' => '2025-01-06 16:45:37',
                'phone' => '+880123456789',
                'company_name' => 'Avijatry cumilla',
                'role_id' => 1,
                'biller_id' => NULL,
                'warehouse_id' => NULL,
                'is_active' => 1,
                'is_deleted' => 0,
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'Jahidul',
                'email' => 'jahidul49@gmail.com',
                'password' => '$2y$10$cnu/ob4LbY1GuTsjfjeun.6e6JxoUHIgbEonfPJAxx/jF05Qle3ge',
                'remember_token' => NULL,
                'created_at' => '2025-11-13 21:37:25',
                'updated_at' => '2025-11-13 21:44:31',
                'phone' => '01629166721',
                'company_name' => NULL,
                'role_id' => 1,
                'biller_id' => 2,
                'warehouse_id' => NULL,
                'is_active' => 1,
                'is_deleted' => 0,
            ),
        ));
        
        
    }
}