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
                'product_id' => 2,
                'variant_id' => 28,
                'position' => 1,
                'item_code' => 'Black/10-R-2',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:37:39',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'product_id' => 2,
                'variant_id' => 29,
                'position' => 2,
                'item_code' => 'Black/12-R-2',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:37:39',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'product_id' => 2,
                'variant_id' => 30,
                'position' => 3,
                'item_code' => 'Black/14-R-2',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:37:39',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'product_id' => 2,
                'variant_id' => 31,
                'position' => 4,
                'item_code' => 'Black/16-R-2',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:37:39',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'product_id' => 2,
                'variant_id' => 32,
                'position' => 5,
                'item_code' => 'Black/18-R-2',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:37:39',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'product_id' => 2,
                'variant_id' => 33,
                'position' => 6,
                'item_code' => 'Black/20-R-2',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:37:39',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'product_id' => 3,
                'variant_id' => 34,
                'position' => 1,
                'item_code' => 'Red/01-R-3',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:38:24',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'product_id' => 3,
                'variant_id' => 35,
                'position' => 2,
                'item_code' => 'Red/02-R-3',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:38:24',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'product_id' => 3,
                'variant_id' => 36,
                'position' => 3,
                'item_code' => 'Red/03-R-3',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:38:24',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'product_id' => 3,
                'variant_id' => 37,
                'position' => 4,
                'item_code' => 'Red/04-R-3',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:38:24',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'product_id' => 3,
                'variant_id' => 38,
                'position' => 5,
                'item_code' => 'Red/05-R-3',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:38:24',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'product_id' => 3,
                'variant_id' => 39,
                'position' => 6,
                'item_code' => 'Red/06-R-3',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:38:24',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'product_id' => 4,
                'variant_id' => 40,
                'position' => 1,
                'item_code' => 'Green/40-R-4',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:39:24',
                'updated_at' => '2026-08-22 15:42:15',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'product_id' => 4,
                'variant_id' => 41,
                'position' => 2,
                'item_code' => 'Green/41-R-4',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:39:24',
                'updated_at' => '2026-08-22 15:42:15',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'product_id' => 4,
                'variant_id' => 42,
                'position' => 3,
                'item_code' => 'Green/42-R-4',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:39:24',
                'updated_at' => '2026-08-22 15:42:15',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'product_id' => 4,
                'variant_id' => 43,
                'position' => 4,
                'item_code' => 'Green/43-R-4',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:39:24',
                'updated_at' => '2026-08-22 15:42:15',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'product_id' => 4,
                'variant_id' => 44,
                'position' => 5,
                'item_code' => 'Green/44-R-4',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:39:24',
                'updated_at' => '2026-08-22 15:42:15',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'product_id' => 4,
                'variant_id' => 45,
                'position' => 6,
                'item_code' => 'Green/45-R-4',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:39:24',
                'updated_at' => '2026-08-22 15:42:15',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'product_id' => 4,
                'variant_id' => 46,
                'position' => 7,
                'item_code' => 'Green/46-R-4',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:39:24',
                'updated_at' => '2026-08-22 15:42:15',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'product_id' => 5,
                'variant_id' => 33,
                'position' => 1,
                'item_code' => 'Black/20-R-5',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:40:06',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'product_id' => 5,
                'variant_id' => 5,
                'position' => 2,
                'item_code' => 'Black/21-R-5',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:40:06',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'product_id' => 5,
                'variant_id' => 6,
                'position' => 3,
                'item_code' => 'Black/22-R-5',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:40:06',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'product_id' => 5,
                'variant_id' => 7,
                'position' => 4,
                'item_code' => 'Black/23-R-5',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:40:06',
                'updated_at' => '2026-08-22 15:42:16',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'product_id' => 5,
                'variant_id' => 8,
                'position' => 5,
                'item_code' => 'Black/24-R-5',
                'additional_price' => NULL,
                'created_at' => '2026-08-22 13:40:06',
                'updated_at' => '2026-08-22 15:42:15',
                'qty' => 2.0,
                'additional_cost' => NULL,
            ),
        ));
        
        
    }
}