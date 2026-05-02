<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CouriersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('couriers')->delete();
        
        \DB::table('couriers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Pathao',
                'phone_number' => NULL,
                'address' => NULL,
                'client_id' => '5xe7XNja7r',
                'client_secret' => 'LtoMKIpNd04fdLAtZtzbOE2lxE4QviLArVihrzt7',
                'store_id' => '174804',
                'username' => 'mdrafael7@gmail.com',
                'password' => '123456',
                'is_active' => 1,
                'created_at' => '2026-02-23 05:52:45',
                'updated_at' => '2026-02-23 05:54:59',
            ),
        ));
        
        
    }
}