<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupplierDuesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('supplier_dues')->delete();
        
        \DB::table('supplier_dues')->insert(array (
            0 => 
            array (
                'id' => 1,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '90000.00',
                'payment_ids' => '[5301,5302,5303,5304,5305,5306,5307,5308,5309,5310,5311,5312,5313,5314,5315,5316,5317,5318,5319,5320,5321]',
                'note' => 'Pubali Bank',
                'created_at' => '2025-10-05 23:00:55',
                'updated_at' => '2025-10-05 23:00:55',
            ),
            1 => 
            array (
                'id' => 2,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '15000.00',
                'payment_ids' => '[5341,5342,5343,5344]',
            'note' => 'Cash Deposit (Tagada)',
                'created_at' => '2025-10-07 22:25:17',
                'updated_at' => '2025-10-07 22:26:47',
            ),
            2 => 
            array (
                'id' => 3,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '25000.00',
                'payment_ids' => '[5380,5381,5382,5383,5384]',
                'note' => NULL,
                'created_at' => '2025-10-12 21:51:10',
                'updated_at' => '2025-10-12 21:51:11',
            ),
            3 => 
            array (
                'id' => 4,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '25000.00',
                'payment_ids' => '[5450,5451,5452,5453,5454,5455,5456]',
                'note' => NULL,
                'created_at' => '2025-10-20 21:26:20',
                'updated_at' => '2025-10-20 21:26:20',
            ),
            4 => 
            array (
                'id' => 5,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '37500.00',
                'payment_ids' => '[5479,5480,5481,5482,5483,5484,5485,5486,5487,5488]',
                'note' => NULL,
                'created_at' => '2025-10-22 21:55:38',
                'updated_at' => '2025-10-22 21:55:38',
            ),
            5 => 
            array (
                'id' => 6,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '20000.00',
                'payment_ids' => '[5516,5517,5518,5519,5520,5521,5522]',
                'note' => NULL,
                'created_at' => '2025-10-27 21:53:14',
                'updated_at' => '2025-10-27 21:53:14',
            ),
            6 => 
            array (
                'id' => 7,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '30000.00',
                'payment_ids' => '[5648,5649,5650,5651,5652,5653,5654]',
                'note' => 'Pubali Bank dep.',
                'created_at' => '2025-11-15 22:48:10',
                'updated_at' => '2025-11-15 22:48:10',
            ),
            7 => 
            array (
                'id' => 8,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '40000.00',
                'payment_ids' => '[5674,5675,5676,5677,5678,5679,5680,5681,5682,5683]',
                'note' => 'Pubali',
                'created_at' => '2025-11-17 22:00:41',
                'updated_at' => '2025-11-17 22:00:42',
            ),
        ));
        
        
    }
}