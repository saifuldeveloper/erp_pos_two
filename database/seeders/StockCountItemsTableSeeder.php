<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StockCountItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('stock_count_items')->delete();
        
        \DB::table('stock_count_items')->insert(array (
            0 => 
            array (
                'id' => 37,
                'stock_count_id' => 1,
                'product_id' => 7,
                'item_code' => 'Red/321-R-7',
                'current_quantity' => 1,
                'updated_quantity' => 5,
                'created_at' => '2026-07-26 17:50:56',
                'updated_at' => '2026-07-26 17:50:56',
            ),
            1 => 
            array (
                'id' => 38,
                'stock_count_id' => 1,
                'product_id' => 7,
                'item_code' => 'Red/32-R-7',
                'current_quantity' => 1,
                'updated_quantity' => 5,
                'created_at' => '2026-07-26 17:50:56',
                'updated_at' => '2026-07-26 17:50:56',
            ),
            2 => 
            array (
                'id' => 39,
                'stock_count_id' => 1,
                'product_id' => 7,
                'item_code' => 'Red/1232-R-7',
                'current_quantity' => 2,
                'updated_quantity' => 10,
                'created_at' => '2026-07-26 17:50:56',
                'updated_at' => '2026-07-26 17:50:56',
            ),
            3 => 
            array (
                'id' => 40,
                'stock_count_id' => 1,
                'product_id' => 7,
                'item_code' => 'Red/12-R-7',
                'current_quantity' => 1,
                'updated_quantity' => 5,
                'created_at' => '2026-07-26 17:50:56',
                'updated_at' => '2026-07-26 17:50:56',
            ),
            4 => 
            array (
                'id' => 41,
                'stock_count_id' => 1,
                'product_id' => 7,
                'item_code' => 'Green/321-R-7',
                'current_quantity' => 1,
                'updated_quantity' => 5,
                'created_at' => '2026-07-26 17:50:56',
                'updated_at' => '2026-07-26 17:50:56',
            ),
            5 => 
            array (
                'id' => 42,
                'stock_count_id' => 1,
                'product_id' => 7,
                'item_code' => 'Green/32-R-7',
                'current_quantity' => 1,
                'updated_quantity' => 5,
                'created_at' => '2026-07-26 17:50:56',
                'updated_at' => '2026-07-26 17:50:56',
            ),
            6 => 
            array (
                'id' => 43,
                'stock_count_id' => 1,
                'product_id' => 7,
                'item_code' => 'Green/1232-R-7',
                'current_quantity' => 1,
                'updated_quantity' => 5,
                'created_at' => '2026-07-26 17:50:56',
                'updated_at' => '2026-07-26 17:50:56',
            ),
            7 => 
            array (
                'id' => 44,
                'stock_count_id' => 1,
                'product_id' => 7,
                'item_code' => 'Green/12-R-7',
                'current_quantity' => 3,
                'updated_quantity' => 15,
                'created_at' => '2026-07-26 17:50:56',
                'updated_at' => '2026-07-26 17:50:56',
            ),
            8 => 
            array (
                'id' => 45,
                'stock_count_id' => 1,
                'product_id' => 7,
                'item_code' => 'Green/22-R-7',
                'current_quantity' => 1,
                'updated_quantity' => 5,
                'created_at' => '2026-07-26 17:50:56',
                'updated_at' => '2026-07-26 17:50:56',
            ),
            9 => 
            array (
                'id' => 57,
                'stock_count_id' => 2,
                'product_id' => 6,
                'item_code' => 'Green/21-R-6',
                'current_quantity' => 1,
                'updated_quantity' => 2,
                'created_at' => '2026-07-26 18:48:52',
                'updated_at' => '2026-07-26 18:48:52',
            ),
            10 => 
            array (
                'id' => 58,
                'stock_count_id' => 2,
                'product_id' => 6,
                'item_code' => 'Green/22-R-6',
                'current_quantity' => 1,
                'updated_quantity' => 2,
                'created_at' => '2026-07-26 18:48:52',
                'updated_at' => '2026-07-26 18:48:52',
            ),
            11 => 
            array (
                'id' => 59,
                'stock_count_id' => 2,
                'product_id' => 6,
                'item_code' => 'Green/23-R-6',
                'current_quantity' => 2,
                'updated_quantity' => 4,
                'created_at' => '2026-07-26 18:48:52',
                'updated_at' => '2026-07-26 18:48:52',
            ),
            12 => 
            array (
                'id' => 60,
                'stock_count_id' => 2,
                'product_id' => 6,
                'item_code' => 'Green/24-R-6',
                'current_quantity' => 1,
                'updated_quantity' => 2,
                'created_at' => '2026-07-26 18:48:52',
                'updated_at' => '2026-07-26 18:48:52',
            ),
            13 => 
            array (
                'id' => 61,
                'stock_count_id' => 2,
                'product_id' => 6,
                'item_code' => 'Green/25-R-6',
                'current_quantity' => 1,
                'updated_quantity' => 2,
                'created_at' => '2026-07-26 18:48:52',
                'updated_at' => '2026-07-26 18:48:52',
            ),
            14 => 
            array (
                'id' => 62,
                'stock_count_id' => 2,
                'product_id' => 6,
                'item_code' => 'Red/21-R-6',
                'current_quantity' => 1,
                'updated_quantity' => 2,
                'created_at' => '2026-07-26 18:48:53',
                'updated_at' => '2026-07-26 18:48:53',
            ),
            15 => 
            array (
                'id' => 63,
                'stock_count_id' => 2,
                'product_id' => 6,
                'item_code' => 'Red/22-R-6',
                'current_quantity' => 2,
                'updated_quantity' => 4,
                'created_at' => '2026-07-26 18:48:53',
                'updated_at' => '2026-07-26 18:48:53',
            ),
            16 => 
            array (
                'id' => 64,
                'stock_count_id' => 2,
                'product_id' => 6,
                'item_code' => 'Red/23-R-6',
                'current_quantity' => 1,
                'updated_quantity' => 2,
                'created_at' => '2026-07-26 18:48:53',
                'updated_at' => '2026-07-26 18:48:53',
            ),
            17 => 
            array (
                'id' => 65,
                'stock_count_id' => 2,
                'product_id' => 6,
                'item_code' => 'Red/24-R-6',
                'current_quantity' => 1,
                'updated_quantity' => 2,
                'created_at' => '2026-07-26 18:48:53',
                'updated_at' => '2026-07-26 18:48:53',
            ),
            18 => 
            array (
                'id' => 66,
                'stock_count_id' => 2,
                'product_id' => 6,
                'item_code' => 'Red/25-R-6',
                'current_quantity' => 1,
                'updated_quantity' => 2,
                'created_at' => '2026-07-26 18:48:53',
                'updated_at' => '2026-07-26 18:48:53',
            ),
            19 => 
            array (
                'id' => 67,
                'stock_count_id' => 2,
                'product_id' => 2,
                'item_code' => 'R-2',
                'current_quantity' => 6,
                'updated_quantity' => 11,
                'created_at' => '2026-07-26 18:48:53',
                'updated_at' => '2026-07-26 18:48:53',
            ),
        ));
        
        
    }
}