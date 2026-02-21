<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GiftReceivesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('gift_receives')->delete();
        
        \DB::table('gift_receives')->insert(array (
            0 => 
            array (
                'id' => 1,
                'purchase_id' => '72',
                'gift_transaction_id' => '5',
                'name' => 'চাবির রিং',
                'quantity' => 100,
                'quantity_received' => 80,
                'created_at' => '2024-12-19 05:40:56',
                'updated_at' => '2024-12-19 05:40:56',
            ),
            1 => 
            array (
                'id' => 2,
                'purchase_id' => '72',
                'gift_transaction_id' => '6',
                'name' => 'লে ব্যাগ',
                'quantity' => 50,
                'quantity_received' => 40,
                'created_at' => '2024-12-19 05:40:56',
                'updated_at' => '2024-12-19 05:40:56',
            ),
            2 => 
            array (
                'id' => 3,
                'purchase_id' => '73',
                'gift_transaction_id' => '5',
                'name' => 'চাবির রিং',
                'quantity' => 100,
                'quantity_received' => 100,
                'created_at' => '2024-12-19 05:45:23',
                'updated_at' => '2024-12-19 05:45:23',
            ),
            3 => 
            array (
                'id' => 4,
                'purchase_id' => '73',
                'gift_transaction_id' => '6',
                'name' => 'লে ব্যাগ',
                'quantity' => 50,
                'quantity_received' => 50,
                'created_at' => '2024-12-19 05:45:23',
                'updated_at' => '2024-12-19 05:45:23',
            ),
            4 => 
            array (
                'id' => 5,
                'purchase_id' => '75',
                'gift_transaction_id' => '7',
                'name' => 'চাবির রিং',
                'quantity' => 100,
                'quantity_received' => 100,
                'created_at' => '2024-12-21 00:44:29',
                'updated_at' => '2024-12-21 00:44:29',
            ),
            5 => 
            array (
                'id' => 6,
                'purchase_id' => '75',
                'gift_transaction_id' => '8',
                'name' => 'লে-বক্স',
                'quantity' => 50,
                'quantity_received' => 50,
                'created_at' => '2024-12-21 00:44:29',
                'updated_at' => '2024-12-21 00:44:29',
            ),
            6 => 
            array (
                'id' => 7,
                'purchase_id' => '75',
                'gift_transaction_id' => '9',
                'name' => 'লে ব্যাগ',
                'quantity' => 50,
                'quantity_received' => 50,
                'created_at' => '2024-12-21 00:44:29',
                'updated_at' => '2024-12-21 00:44:29',
            ),
            7 => 
            array (
                'id' => 8,
                'purchase_id' => '76',
                'gift_transaction_id' => '7',
                'name' => 'চাবির রিং',
                'quantity' => 100,
                'quantity_received' => 100,
                'created_at' => '2024-12-21 00:47:39',
                'updated_at' => '2024-12-21 00:47:39',
            ),
            8 => 
            array (
                'id' => 9,
                'purchase_id' => '76',
                'gift_transaction_id' => '8',
                'name' => 'লে-বক্স',
                'quantity' => 50,
                'quantity_received' => 50,
                'created_at' => '2024-12-21 00:47:39',
                'updated_at' => '2024-12-21 00:47:39',
            ),
            9 => 
            array (
                'id' => 10,
                'purchase_id' => '76',
                'gift_transaction_id' => '9',
                'name' => 'লে ব্যাগ',
                'quantity' => 50,
                'quantity_received' => 50,
                'created_at' => '2024-12-21 00:47:39',
                'updated_at' => '2024-12-21 00:47:39',
            ),
            10 => 
            array (
                'id' => 11,
                'purchase_id' => '77',
                'gift_transaction_id' => '7',
                'name' => 'চাবির রিং',
                'quantity' => 100,
                'quantity_received' => 100,
                'created_at' => '2024-12-21 00:51:47',
                'updated_at' => '2024-12-21 00:51:47',
            ),
            11 => 
            array (
                'id' => 12,
                'purchase_id' => '77',
                'gift_transaction_id' => '8',
                'name' => 'লে-বক্স',
                'quantity' => 50,
                'quantity_received' => 50,
                'created_at' => '2024-12-21 00:51:47',
                'updated_at' => '2024-12-21 00:51:47',
            ),
            12 => 
            array (
                'id' => 13,
                'purchase_id' => '77',
                'gift_transaction_id' => '9',
                'name' => 'লে ব্যাগ',
                'quantity' => 50,
                'quantity_received' => 50,
                'created_at' => '2024-12-21 00:51:47',
                'updated_at' => '2024-12-21 00:51:47',
            ),
            13 => 
            array (
                'id' => 14,
                'purchase_id' => '78',
                'gift_transaction_id' => '7',
                'name' => 'চাবির রিং',
                'quantity' => 100,
                'quantity_received' => 100,
                'created_at' => '2024-12-22 00:14:37',
                'updated_at' => '2024-12-22 00:14:37',
            ),
            14 => 
            array (
                'id' => 15,
                'purchase_id' => '78',
                'gift_transaction_id' => '8',
                'name' => 'লে-বক্স',
                'quantity' => 50,
                'quantity_received' => 50,
                'created_at' => '2024-12-22 00:14:37',
                'updated_at' => '2024-12-22 00:14:37',
            ),
            15 => 
            array (
                'id' => 16,
                'purchase_id' => '78',
                'gift_transaction_id' => '9',
                'name' => 'লে ব্যাগ',
                'quantity' => 50,
                'quantity_received' => 50,
                'created_at' => '2024-12-22 00:14:37',
                'updated_at' => '2024-12-22 00:14:37',
            ),
        ));
        
        
    }
}