<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductVariantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_variants')->delete();
        
        \DB::table('product_variants')->insert(array (
            0 => 
            array (
                'id' => 1,
                'product_id' => 3,
                'variant_id' => 1,
                'position' => 1,
                'item_code' => 'Black/40-R-3',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 0.0,
                'created_at' => '2026-06-28 13:03:54',
                'updated_at' => '2026-06-28 13:21:16',
            ),
            1 => 
            array (
                'id' => 2,
                'product_id' => 3,
                'variant_id' => 2,
                'position' => 2,
                'item_code' => 'Black/41-R-3',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 0.0,
                'created_at' => '2026-06-28 13:03:54',
                'updated_at' => '2026-06-28 13:21:16',
            ),
            2 => 
            array (
                'id' => 3,
                'product_id' => 4,
                'variant_id' => 3,
                'position' => 1,
                'item_code' => 'Black/39-R-4',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 0.0,
                'created_at' => '2026-06-28 16:14:27',
                'updated_at' => '2026-07-26 14:37:00',
            ),
            3 => 
            array (
                'id' => 4,
                'product_id' => 4,
                'variant_id' => 1,
                'position' => 2,
                'item_code' => 'Black/40-R-4',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 0.0,
                'created_at' => '2026-06-28 16:14:27',
                'updated_at' => '2026-07-26 14:37:00',
            ),
            4 => 
            array (
                'id' => 5,
                'product_id' => 4,
                'variant_id' => 2,
                'position' => 3,
                'item_code' => 'Black/41-R-4',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 0.0,
                'created_at' => '2026-06-28 16:14:27',
                'updated_at' => '2026-07-26 14:37:00',
            ),
            5 => 
            array (
                'id' => 6,
                'product_id' => 4,
                'variant_id' => 4,
                'position' => 4,
                'item_code' => 'Black/42-R-4',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 0.0,
                'created_at' => '2026-06-28 16:14:27',
                'updated_at' => '2026-07-26 14:37:00',
            ),
            6 => 
            array (
                'id' => 7,
                'product_id' => 5,
                'variant_id' => 5,
                'position' => 1,
                'item_code' => 'Black/21-R-5',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 0.0,
                'created_at' => '2026-07-26 14:16:17',
                'updated_at' => '2026-07-26 14:16:17',
            ),
            7 => 
            array (
                'id' => 8,
                'product_id' => 5,
                'variant_id' => 6,
                'position' => 2,
                'item_code' => 'Black/22-R-5',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 0.0,
                'created_at' => '2026-07-26 14:16:17',
                'updated_at' => '2026-07-26 14:16:17',
            ),
            8 => 
            array (
                'id' => 9,
                'product_id' => 5,
                'variant_id' => 7,
                'position' => 3,
                'item_code' => 'Black/23-R-5',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 0.0,
                'created_at' => '2026-07-26 14:16:17',
                'updated_at' => '2026-07-26 14:16:17',
            ),
            9 => 
            array (
                'id' => 10,
                'product_id' => 5,
                'variant_id' => 8,
                'position' => 4,
                'item_code' => 'Black/24-R-5',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 0.0,
                'created_at' => '2026-07-26 14:16:17',
                'updated_at' => '2026-07-26 14:16:17',
            ),
            10 => 
            array (
                'id' => 11,
                'product_id' => 5,
                'variant_id' => 9,
                'position' => 5,
                'item_code' => 'Black/25-R-5',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 0.0,
                'created_at' => '2026-07-26 14:16:17',
                'updated_at' => '2026-07-26 14:16:17',
            ),
            11 => 
            array (
                'id' => 12,
                'product_id' => 6,
                'variant_id' => 10,
                'position' => 1,
                'item_code' => 'Green/21-R-6',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 2.0,
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:42:35',
            ),
            12 => 
            array (
                'id' => 13,
                'product_id' => 6,
                'variant_id' => 11,
                'position' => 2,
                'item_code' => 'Green/22-R-6',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 2.0,
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:42:35',
            ),
            13 => 
            array (
                'id' => 14,
                'product_id' => 6,
                'variant_id' => 12,
                'position' => 3,
                'item_code' => 'Green/23-R-6',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 4.0,
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:42:35',
            ),
            14 => 
            array (
                'id' => 15,
                'product_id' => 6,
                'variant_id' => 13,
                'position' => 4,
                'item_code' => 'Green/24-R-6',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 2.0,
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:42:35',
            ),
            15 => 
            array (
                'id' => 16,
                'product_id' => 6,
                'variant_id' => 14,
                'position' => 5,
                'item_code' => 'Green/25-R-6',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 2.0,
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:42:35',
            ),
            16 => 
            array (
                'id' => 17,
                'product_id' => 6,
                'variant_id' => 15,
                'position' => 6,
                'item_code' => 'Red/21-R-6',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 2.0,
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:42:35',
            ),
            17 => 
            array (
                'id' => 18,
                'product_id' => 6,
                'variant_id' => 16,
                'position' => 7,
                'item_code' => 'Red/22-R-6',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 4.0,
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:42:35',
            ),
            18 => 
            array (
                'id' => 19,
                'product_id' => 6,
                'variant_id' => 17,
                'position' => 8,
                'item_code' => 'Red/23-R-6',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 2.0,
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:42:35',
            ),
            19 => 
            array (
                'id' => 20,
                'product_id' => 6,
                'variant_id' => 18,
                'position' => 9,
                'item_code' => 'Red/24-R-6',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 2.0,
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:42:35',
            ),
            20 => 
            array (
                'id' => 21,
                'product_id' => 6,
                'variant_id' => 19,
                'position' => 10,
                'item_code' => 'Red/25-R-6',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 2.0,
                'created_at' => '2026-07-26 14:25:50',
                'updated_at' => '2026-07-26 14:42:35',
            ),
            21 => 
            array (
                'id' => 22,
                'product_id' => 7,
                'variant_id' => 11,
                'position' => 1,
                'item_code' => 'Green/22-R-7',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 5.0,
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:43:01',
            ),
            22 => 
            array (
                'id' => 23,
                'product_id' => 7,
                'variant_id' => 20,
                'position' => 2,
                'item_code' => 'Green/12-R-7',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 15.0,
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:43:01',
            ),
            23 => 
            array (
                'id' => 24,
                'product_id' => 7,
                'variant_id' => 21,
                'position' => 3,
                'item_code' => 'Green/1232-R-7',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 5.0,
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:43:01',
            ),
            24 => 
            array (
                'id' => 25,
                'product_id' => 7,
                'variant_id' => 22,
                'position' => 4,
                'item_code' => 'Green/32-R-7',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 5.0,
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:43:01',
            ),
            25 => 
            array (
                'id' => 26,
                'product_id' => 7,
                'variant_id' => 23,
                'position' => 5,
                'item_code' => 'Green/321-R-7',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 5.0,
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:43:01',
            ),
            26 => 
            array (
                'id' => 27,
                'product_id' => 7,
                'variant_id' => 16,
                'position' => 6,
                'item_code' => 'Red/22-R-7',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 0.0,
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 17:48:21',
            ),
            27 => 
            array (
                'id' => 28,
                'product_id' => 7,
                'variant_id' => 24,
                'position' => 7,
                'item_code' => 'Red/12-R-7',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 5.0,
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:43:01',
            ),
            28 => 
            array (
                'id' => 29,
                'product_id' => 7,
                'variant_id' => 25,
                'position' => 8,
                'item_code' => 'Red/1232-R-7',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 10.0,
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:43:01',
            ),
            29 => 
            array (
                'id' => 30,
                'product_id' => 7,
                'variant_id' => 26,
                'position' => 9,
                'item_code' => 'Red/32-R-7',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 5.0,
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:43:01',
            ),
            30 => 
            array (
                'id' => 31,
                'product_id' => 7,
                'variant_id' => 27,
                'position' => 10,
                'item_code' => 'Red/321-R-7',
                'additional_cost' => NULL,
                'additional_price' => NULL,
                'qty' => 5.0,
                'created_at' => '2026-07-26 14:35:47',
                'updated_at' => '2026-07-26 14:43:01',
            ),
        ));
        
        
    }
}