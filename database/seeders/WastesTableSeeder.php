<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WastesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('wastes')->delete();
        
        \DB::table('wastes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'receiver_type' => 'customer',
                'receiver_id' => 970,
                'receiver_name' => 'MITHU SB.',
                'note' => 'Mithu saheb 1023 article 40 size er ekta niche',
                'total_price' => '1495.00',
                'status' => 1,
                'created_at' => '2025-03-06 23:35:28',
                'updated_at' => '2025-03-06 23:35:28',
            ),
            1 => 
            array (
                'id' => 2,
                'receiver_type' => 'customer',
                'receiver_id' => 2680,
                'receiver_name' => 'SAKIL BEYAI',
            'note' => 'Contract employee Mamun EID GIFT - (779-42), (472-38)',
                'total_price' => '1975.00',
                'status' => 1,
                'created_at' => '2025-04-13 17:42:31',
                'updated_at' => '2025-04-13 18:18:46',
            ),
            2 => 
            array (
                'id' => 3,
                'receiver_type' => 'customer',
                'receiver_id' => 2741,
                'receiver_name' => 'KURBAN EMPLOYEE',
            'note' => 'KURBAN EID GIFT - (941-35), (907-37), (182-40)',
                'total_price' => '4270.00',
                'status' => 1,
                'created_at' => '2025-04-13 17:48:35',
                'updated_at' => '2025-04-13 18:20:38',
            ),
            3 => 
            array (
                'id' => 4,
                'receiver_type' => 'customer',
                'receiver_id' => 2681,
                'receiver_name' => 'LITON VAI',
            'note' => 'Contract employee Liton EID GIFT - (180-41), (1075-38)',
                'total_price' => '1945.00',
                'status' => 1,
                'created_at' => '2025-04-13 17:53:25',
                'updated_at' => '2025-04-13 18:23:02',
            ),
            4 => 
            array (
                'id' => 5,
                'receiver_type' => 'customer',
                'receiver_id' => 2743,
                'receiver_name' => 'SAIHD EMPLOYEE',
            'note' => 'Saihd Employee EID GIFT - (1125-42), (817-26), (R-7-41)',
                'total_price' => '4130.00',
                'status' => 1,
                'created_at' => '2025-04-13 18:03:47',
                'updated_at' => '2025-04-13 18:24:38',
            ),
            5 => 
            array (
                'id' => 6,
                'receiver_type' => 'customer',
                'receiver_id' => 2742,
                'receiver_name' => 'AL',
            'note' => 'Al-Amin EID GIFT - (C5-40), (1021-40), (53A-7)',
                'total_price' => '4145.00',
                'status' => 1,
                'created_at' => '2025-04-13 18:10:07',
                'updated_at' => '2025-04-13 18:25:28',
            ),
            6 => 
            array (
                'id' => 7,
                'receiver_type' => 'customer',
                'receiver_id' => 2680,
                'receiver_name' => 'SAKIL BEYAI',
                'note' => 'Contract employee Sakil EID GIFT',
                'total_price' => '2095.00',
                'status' => 1,
                'created_at' => '2025-04-13 18:14:37',
                'updated_at' => '2025-04-13 18:14:37',
            ),
            7 => 
            array (
                'id' => 8,
                'receiver_type' => 'customer',
                'receiver_id' => 2612,
                'receiver_name' => 'DISHAN',
                'note' => 'Contract employee Dishan EID GIFT',
                'total_price' => '2210.00',
                'status' => 1,
                'created_at' => '2025-04-13 18:15:45',
                'updated_at' => '2025-04-13 18:15:45',
            ),
            8 => 
            array (
                'id' => 9,
                'receiver_type' => 'customer',
                'receiver_id' => 2378,
                'receiver_name' => 'SAKIRUL',
                'note' => 'Contract employee Sakirul EID GIFT',
                'total_price' => '2095.00',
                'status' => 1,
                'created_at' => '2025-04-13 18:17:28',
                'updated_at' => '2025-04-13 18:17:28',
            ),
            9 => 
            array (
                'id' => 10,
                'receiver_type' => 'customer',
                'receiver_id' => 979,
                'receiver_name' => 'PINTU SB.',
            'note' => 'EID GIFT (R-57-37), (763-41), (998-34)',
                'total_price' => '5040.00',
                'status' => 1,
                'created_at' => '2025-04-13 19:54:24',
                'updated_at' => '2025-04-13 19:54:24',
            ),
            10 => 
            array (
                'id' => 11,
                'receiver_type' => 'customer',
                'receiver_id' => 215,
                'receiver_name' => 'SOHEL TAJ',
                'note' => 'Contract employee Sohel EID GIFT',
                'total_price' => '2040.00',
                'status' => 1,
                'created_at' => '2025-04-13 19:59:11',
                'updated_at' => '2025-04-13 19:59:11',
            ),
            11 => 
            array (
                'id' => 12,
                'receiver_type' => 'customer',
                'receiver_id' => 2744,
                'receiver_name' => 'SABBIR EMPLOYEE',
            'note' => 'SABBIR EID GIFT (1021-39)',
                'total_price' => '2095.00',
                'status' => 1,
                'created_at' => '2025-04-13 20:09:45',
                'updated_at' => '2025-04-13 20:09:45',
            ),
            12 => 
            array (
                'id' => 13,
                'receiver_type' => 'customer',
                'receiver_id' => 1,
                'receiver_name' => 'Walking Customer',
            'note' => 'Aynul Vai Dhaka (1008-39), (777-42)',
                'total_price' => '4285.00',
                'status' => 1,
                'created_at' => '2025-04-13 20:13:49',
                'updated_at' => '2025-04-13 20:13:49',
            ),
            13 => 
            array (
                'id' => 14,
                'receiver_type' => 'customer',
                'receiver_id' => 1,
                'receiver_name' => 'Walking Customer',
            'note' => 'Contract employee Rony EID GIFT (R-81)',
                'total_price' => '2095.00',
                'status' => 1,
                'created_at' => '2025-04-13 20:16:02',
                'updated_at' => '2025-04-13 20:16:02',
            ),
            14 => 
            array (
                'id' => 15,
                'receiver_type' => 'customer',
                'receiver_id' => 2,
                'receiver_name' => 'Imrul Kayes',
                'note' => 'Emrul EID GIFT',
                'total_price' => '5085.00',
                'status' => 1,
                'created_at' => '2025-04-14 19:33:41',
                'updated_at' => '2025-04-14 19:33:41',
            ),
            15 => 
            array (
                'id' => 16,
                'receiver_type' => 'customer',
                'receiver_id' => 1,
                'receiver_name' => 'Walking Customer',
            'note' => 'Contract employee ERAZ EID GIFT (1021-43)',
                'total_price' => '2095.00',
                'status' => 1,
                'created_at' => '2025-04-14 20:00:12',
                'updated_at' => '2025-04-14 20:00:12',
            ),
            16 => 
            array (
                'id' => 17,
                'receiver_type' => 'customer',
                'receiver_id' => 1,
                'receiver_name' => 'Walking Customer',
                'note' => 'Buya',
                'total_price' => '995.00',
                'status' => 1,
                'created_at' => '2025-05-03 15:24:16',
                'updated_at' => '2025-05-03 15:24:16',
            ),
            17 => 
            array (
                'id' => 18,
                'receiver_type' => 'supplier',
                'receiver_id' => 2,
                'receiver_name' => 'China',
                'note' => NULL,
                'total_price' => '0.00',
                'status' => 1,
                'created_at' => '2025-10-02 08:33:57',
                'updated_at' => '2025-10-02 08:33:57',
            ),
            18 => 
            array (
                'id' => 19,
                'receiver_type' => 'supplier',
                'receiver_id' => 2,
                'receiver_name' => 'China',
                'note' => NULL,
                'total_price' => '3345.00',
                'status' => 1,
                'created_at' => '2025-10-02 08:35:24',
                'updated_at' => '2025-10-02 08:35:24',
            ),
            19 => 
            array (
                'id' => 21,
                'receiver_type' => 'supplier',
                'receiver_id' => 2,
                'receiver_name' => 'China',
                'note' => '1 pair',
                'total_price' => '2195.00',
                'status' => 1,
                'created_at' => '2025-10-05 05:19:31',
                'updated_at' => '2025-10-05 05:19:31',
            ),
            20 => 
            array (
                'id' => 22,
                'receiver_type' => 'supplier',
                'receiver_id' => 2,
                'receiver_name' => 'China',
                'note' => NULL,
                'total_price' => '1150.00',
                'status' => 1,
                'created_at' => '2025-10-05 05:20:45',
                'updated_at' => '2025-10-05 05:20:45',
            ),
        ));
        
        
    }
}