<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('departments')->delete();
        
        \DB::table('departments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Salesman',
                'is_active' => 0,
                'created_at' => '2024-12-19 11:51:07',
                'updated_at' => '2025-02-18 19:11:58',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Sales',
                'is_active' => 0,
                'created_at' => '2025-02-15 21:53:18',
                'updated_at' => '2025-02-18 19:12:03',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Full Time',
                'is_active' => 1,
                'created_at' => '2025-02-18 19:12:22',
                'updated_at' => '2025-02-18 19:12:22',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Contractual',
                'is_active' => 1,
                'created_at' => '2025-02-18 19:12:42',
                'updated_at' => '2025-02-18 19:12:42',
            ),
        ));
        
        
    }
}