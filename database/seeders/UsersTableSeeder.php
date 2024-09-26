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
                'email' => 'admin@admin.com',
                'password' => '$2y$10$rRChF/FGAX59PKQFLjq57OKYvtukc97v4DM1XdO6jRKr2yev9uqKK',
                'remember_token' => NULL,
                'created_at' => '2023-08-12 10:51:23',
                'updated_at' => '2023-08-12 13:57:31',
                'phone' => '+1-800-0000001',
                'company_name' => 'My Company',
                'role_id' => 1,
                'biller_id' => 1,
                'warehouse_id' => 1,
                'is_active' => 1,
                'is_deleted' => 0,
            ),
        ));
        
        
    }
}