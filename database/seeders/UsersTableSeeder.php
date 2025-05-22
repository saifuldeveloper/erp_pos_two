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
                'name' => 'admin',
                'email' => 'khulna@avijatry.com',
                'password' => '$2y$10$rRChF/FGAX59PKQFLjq57OKYvtukc97v4DM1XdO6jRKr2yev9uqKK',
                'remember_token' => NULL,
                'created_at' => '2023-08-12 10:51:23',
                'updated_at' => '2025-03-21 21:46:39',
                'phone' => '+8801928219070',
                'company_name' => 'Avijatry Khulna',
                'role_id' => 1,
                'biller_id' => NULL,
                'warehouse_id' => NULL,
                'is_active' => 1,
                'is_deleted' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Giacomo Rodgers',
                'email' => 'dena@mailinator.com',
                'password' => '$2y$10$s6b9c5XMJyuusULHFcnAt.22bOXv9jHztH.H4LoPTkk6B5bAFy/wG',
                'remember_token' => NULL,
                'created_at' => '2024-12-18 07:54:42',
                'updated_at' => '2024-12-18 07:54:47',
            'phone' => '+1 (883) 798-1681',
                'company_name' => NULL,
                'role_id' => 1,
                'biller_id' => NULL,
                'warehouse_id' => NULL,
                'is_active' => 0,
                'is_deleted' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'rafael',
                'email' => 'mdrafael7@gmail.com',
                'password' => '$2y$10$P6NP7mVHdXanX69M4umXz.HhpYEj118hPBSkXEHaJWoNcN8vOlmMO',
                'remember_token' => NULL,
                'created_at' => '2024-12-22 07:20:13',
                'updated_at' => '2024-12-29 05:09:14',
                'phone' => '01816461193',
                'company_name' => 'Avijatry',
                'role_id' => 1,
                'biller_id' => NULL,
                'warehouse_id' => NULL,
                'is_active' => 1,
                'is_deleted' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Imrulkayes',
                'email' => 'imrulkayes@gmail.com',
                'password' => '$2y$10$Y82aNCeuUmaX4e9JQVvdM.J4lCtMlFn0ZAA4BiAUlJjlOn/tMMFbO',
                'remember_token' => NULL,
                'created_at' => '2024-12-22 07:33:41',
                'updated_at' => '2024-12-23 07:09:53',
                'phone' => '000000000',
                'company_name' => NULL,
                'role_id' => 3,
                'biller_id' => 2,
                'warehouse_id' => 1,
                'is_active' => 0,
                'is_deleted' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Saim',
                'email' => 'iamarian64@gmail.com',
                'password' => '$2y$10$ZfpjmmlTVQsBDtJUIt6DMe.C3.UF/GhqqNHDKjWjTQec78MYZQhZi',
                'remember_token' => NULL,
                'created_at' => '2024-12-22 07:43:21',
                'updated_at' => '2024-12-23 07:07:27',
                'phone' => '01333372533',
                'company_name' => 'Avijatry',
                'role_id' => 8,
                'biller_id' => 2,
                'warehouse_id' => 1,
                'is_active' => 1,
                'is_deleted' => 0,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'abdullah',
                'email' => 'ab@gmail.com',
                'password' => '$2y$10$uYly5e0L3yeOQiZF1k/E6uHWYnQLGMBaqX6VsgxonKJ1V1u78AeLW',
                'remember_token' => NULL,
                'created_at' => '2024-12-23 03:11:41',
                'updated_at' => '2024-12-28 09:05:12',
                'phone' => '01779-439274',
                'company_name' => 'Avijatry',
                'role_id' => 8,
                'biller_id' => 2,
                'warehouse_id' => 1,
                'is_active' => 1,
                'is_deleted' => 0,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'imrul',
                'email' => 'imrul@avijatry.com',
                'password' => '$2y$10$2UlVs529g0AVbEMhwMsJDOl6jyYsx3surziL4XFqUHE0581livzv6',
                'remember_token' => NULL,
                'created_at' => '2024-12-23 07:14:17',
                'updated_at' => '2024-12-23 07:18:22',
                'phone' => '0122222',
                'company_name' => NULL,
                'role_id' => 5,
                'biller_id' => NULL,
                'warehouse_id' => NULL,
                'is_active' => 0,
                'is_deleted' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Imrul',
                'email' => 'imrul@avijatry.com',
                'password' => '$2y$10$gU1wGg2c1lgCUTs1.NwkTOE8CcfvA2hTm0rSFEkzuFaa2WXd5nEeK',
                'remember_token' => NULL,
                'created_at' => '2025-01-06 00:03:56',
                'updated_at' => '2025-01-06 10:43:07',
                'phone' => '‭+880 19 2821 9070‬',
                'company_name' => 'Avijatry Khulna',
                'role_id' => 1,
                'biller_id' => 2,
                'warehouse_id' => 1,
                'is_active' => 0,
                'is_deleted' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Imrul',
                'email' => 'as123@gmail.com',
                'password' => '$2y$10$56ldER4neOjc1d8Sj2dSAOi95bmGQ3uEE76/SRYXIoLz2MCQ670e6',
                'remember_token' => NULL,
                'created_at' => '2025-01-06 10:43:43',
                'updated_at' => '2025-01-06 10:46:48',
                'phone' => '‭+8801928219070‬',
                'company_name' => NULL,
                'role_id' => 8,
                'biller_id' => 2,
                'warehouse_id' => 1,
                'is_active' => 1,
                'is_deleted' => 0,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'kurban',
                'email' => 'kurban@avijatry.com',
                'password' => '$2y$10$my6/Lk6JI9l45USOdnEbVOxnCam8U2RrHfE0CZzkZWfWFZ4U32VXq',
                'remember_token' => NULL,
                'created_at' => '2025-03-30 22:02:49',
                'updated_at' => '2025-04-15 22:25:19',
                'phone' => '01956449453',
                'company_name' => NULL,
                'role_id' => 8,
                'biller_id' => 2,
                'warehouse_id' => 1,
                'is_active' => 0,
                'is_deleted' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'kurban',
                'email' => 'kurban@avijatry.com',
                'password' => '$2y$10$XIQQvCDq5XsWwQ7tMFzS7.MG1hNJn7x5B4lNCFVnUjJknfmUgP9ae',
                'remember_token' => NULL,
                'created_at' => '2025-04-21 02:00:48',
                'updated_at' => '2025-04-21 02:02:57',
                'phone' => '01956449453',
                'company_name' => NULL,
                'role_id' => 8,
                'biller_id' => 2,
                'warehouse_id' => 1,
                'is_active' => 0,
                'is_deleted' => 1,
            ),
        ));
        
        
    }
}