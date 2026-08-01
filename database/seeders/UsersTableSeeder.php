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
                'password' => '$2y$12$Yc6HK5nHS8Qf.xCBMreqx.6bpAFSbqajZMphe5GGYBXUxhGn/RQ42',
                'remember_token' => NULL,
                'phone' => '+880123456789',
                'company_name' => 'Avijatry Retailer',
                'role_id' => 1,
                'is_active' => 1,
                'is_deleted' => 0,
                'biller_id' => NULL,
                'warehouse_id' => NULL,
                'created_at' => '2023-08-12 10:51:23',
                'updated_at' => '2025-01-06 10:45:37',
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'Jahidul',
                'email' => 'jahidul49@gmail.com',
                'password' => '$2y$10$cnu/ob4LbY1GuTsjfjeun.6e6JxoUHIgbEonfPJAxx/jF05Qle3ge',
                'remember_token' => NULL,
                'phone' => '01629166721',
                'company_name' => NULL,
                'role_id' => 1,
                'is_active' => 0,
                'is_deleted' => 1,
                'biller_id' => 2,
                'warehouse_id' => NULL,
                'created_at' => '2025-11-13 15:37:25',
                'updated_at' => '2025-11-19 05:46:44',
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'Jahid',
                'email' => 'jahidul@gmail.com',
                'password' => '$2y$10$D.ldXkkKp/Q3ZMobQtfDyORbAWkt7pxGUt6s5DWP2cD6MpOKovcDa',
                'remember_token' => NULL,
                'phone' => '01',
                'company_name' => NULL,
                'role_id' => 3,
                'is_active' => 1,
                'is_deleted' => 0,
                'biller_id' => 3,
                'warehouse_id' => 1,
                'created_at' => '2025-11-19 09:35:40',
                'updated_at' => '2025-11-19 09:37:44',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'md_jahid',
                'email' => 'jahid@gmail.com',
                'password' => '$2y$10$JjhsKQYHFRlhd/179HYYjOaVTUt5zkwllSZcvkyK2xa5Ivv.do3sG',
                'remember_token' => NULL,
                'phone' => '017',
                'company_name' => NULL,
                'role_id' => 1,
                'is_active' => 1,
                'is_deleted' => 0,
                'biller_id' => NULL,
                'warehouse_id' => NULL,
                'created_at' => '2026-01-28 11:32:59',
                'updated_at' => '2026-01-28 11:32:59',
            ),
        ));
        
        
    }
}