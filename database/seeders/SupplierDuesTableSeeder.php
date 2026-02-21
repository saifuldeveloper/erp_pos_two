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
                'created_at' => '2025-10-05 17:00:55',
                'updated_at' => '2025-10-05 17:00:55',
            ),
            1 => 
            array (
                'id' => 2,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '15000.00',
                'payment_ids' => '[5341,5342,5343,5344]',
            'note' => 'Cash Deposit (Tagada)',
                'created_at' => '2025-10-07 16:25:17',
                'updated_at' => '2025-10-07 16:26:47',
            ),
            2 => 
            array (
                'id' => 3,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '25000.00',
                'payment_ids' => '[5380,5381,5382,5383,5384]',
                'note' => NULL,
                'created_at' => '2025-10-12 15:51:10',
                'updated_at' => '2025-10-12 15:51:11',
            ),
            3 => 
            array (
                'id' => 4,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '25000.00',
                'payment_ids' => '[5450,5451,5452,5453,5454,5455,5456]',
                'note' => NULL,
                'created_at' => '2025-10-20 15:26:20',
                'updated_at' => '2025-10-20 15:26:20',
            ),
            4 => 
            array (
                'id' => 5,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '37500.00',
                'payment_ids' => '[5479,5480,5481,5482,5483,5484,5485,5486,5487,5488]',
                'note' => NULL,
                'created_at' => '2025-10-22 15:55:38',
                'updated_at' => '2025-10-22 15:55:38',
            ),
            5 => 
            array (
                'id' => 6,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '20000.00',
                'payment_ids' => '[5516,5517,5518,5519,5520,5521,5522]',
                'note' => NULL,
                'created_at' => '2025-10-27 15:53:14',
                'updated_at' => '2025-10-27 15:53:14',
            ),
            6 => 
            array (
                'id' => 7,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '30000.00',
                'payment_ids' => '[5648,5649,5650,5651,5652,5653,5654]',
                'note' => 'Pubali Bank dep.',
                'created_at' => '2025-11-15 16:48:10',
                'updated_at' => '2025-11-15 16:48:10',
            ),
            7 => 
            array (
                'id' => 8,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '40000.00',
                'payment_ids' => '[5674,5675,5676,5677,5678,5679,5680,5681,5682,5683]',
                'note' => 'Pubali',
                'created_at' => '2025-11-17 16:00:41',
                'updated_at' => '2025-11-17 16:00:42',
            ),
            8 => 
            array (
                'id' => 9,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '25000.00',
                'payment_ids' => '[5724,5725,5726,5727,5728,5729]',
                'note' => 'Pubali',
                'created_at' => '2025-11-20 21:55:19',
                'updated_at' => '2025-11-20 21:55:19',
            ),
            9 => 
            array (
                'id' => 10,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '45000.00',
                'payment_ids' => '[5770,5771,5772,5773,5774,5775,5776,5777]',
                'note' => NULL,
                'created_at' => '2025-11-24 22:06:38',
                'updated_at' => '2025-11-24 22:06:38',
            ),
            10 => 
            array (
                'id' => 11,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '20000.00',
                'payment_ids' => '[5788,5789,5790]',
                'note' => NULL,
                'created_at' => '2025-11-25 21:56:00',
                'updated_at' => '2025-11-25 21:56:00',
            ),
            11 => 
            array (
                'id' => 12,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '100000.00',
                'payment_ids' => '[5964,5965,5966,5967,5968,5969,5970,5971,5972,5973,5974,5975,5976,5977,5978,5979,5980,5981]',
                'note' => 'Pubali Bank dep.',
                'created_at' => '2025-12-08 22:13:27',
                'updated_at' => '2025-12-08 22:13:27',
            ),
            12 => 
            array (
                'id' => 13,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '48000.00',
                'payment_ids' => '[5999,6000,6001,6002,6003,6004,6005]',
                'note' => NULL,
                'created_at' => '2025-12-09 22:41:13',
                'updated_at' => '2025-12-09 22:41:13',
            ),
            13 => 
            array (
                'id' => 14,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '33000.00',
                'payment_ids' => '[6152,6153,6154,6155,6156,6157]',
                'note' => NULL,
                'created_at' => '2025-12-17 22:08:50',
                'updated_at' => '2025-12-17 22:08:50',
            ),
            14 => 
            array (
                'id' => 15,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '52000.00',
                'payment_ids' => '[6185,6186,6187,6188,6189,6190,6191,6192,6193]',
                'note' => NULL,
                'created_at' => '2025-12-18 22:36:29',
                'updated_at' => '2025-12-18 22:36:29',
            ),
            15 => 
            array (
                'id' => 16,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '63000.00',
                'payment_ids' => '[6241,6242,6243,6244,6245,6246,6247,6248,6249,6250,6251,6252]',
                'note' => NULL,
                'created_at' => '2025-12-21 22:14:07',
                'updated_at' => '2025-12-21 22:14:07',
            ),
            16 => 
            array (
                'id' => 17,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '34500.00',
                'payment_ids' => '[6300,6301,6302,6303,6304,6305,6306]',
                'note' => NULL,
                'created_at' => '2025-12-24 22:12:44',
                'updated_at' => '2025-12-24 22:12:44',
            ),
            17 => 
            array (
                'id' => 18,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '100000.00',
                'payment_ids' => '[6379,6380,6381,6382,6383,6384,6385,6386,6387,6388,6389,6390,6391]',
                'note' => NULL,
                'created_at' => '2025-12-28 22:01:37',
                'updated_at' => '2025-12-28 22:01:37',
            ),
            18 => 
            array (
                'id' => 19,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '62000.00',
                'payment_ids' => '[6516,6517,6518,6519,6520,6521,6522,6523,6524,6525]',
                'note' => NULL,
                'created_at' => '2026-01-05 22:15:33',
                'updated_at' => '2026-01-05 22:15:33',
            ),
            19 => 
            array (
                'id' => 20,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '15000.00',
                'payment_ids' => '[6545,6546]',
                'note' => NULL,
                'created_at' => '2026-01-06 22:11:19',
                'updated_at' => '2026-01-06 22:11:19',
            ),
            20 => 
            array (
                'id' => 21,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '15000.00',
                'payment_ids' => '[6559,6560,6561]',
                'note' => NULL,
                'created_at' => '2026-01-07 23:00:47',
                'updated_at' => '2026-01-07 23:00:47',
            ),
            21 => 
            array (
                'id' => 22,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '60000.00',
                'payment_ids' => '[6620,6621,6622,6623,6624,6625,6626,6627,6628]',
                'note' => NULL,
                'created_at' => '2026-01-11 22:09:18',
                'updated_at' => '2026-01-11 22:09:18',
            ),
            22 => 
            array (
                'id' => 23,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '25000.00',
                'payment_ids' => '[6652,6653,6654]',
                'note' => NULL,
                'created_at' => '2026-01-13 22:11:47',
                'updated_at' => '2026-01-13 22:11:47',
            ),
            23 => 
            array (
                'id' => 24,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '17000.00',
                'payment_ids' => '[6675,6676,6677]',
                'note' => NULL,
                'created_at' => '2026-01-15 21:53:43',
                'updated_at' => '2026-01-15 21:53:43',
            ),
            24 => 
            array (
                'id' => 25,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '28500.00',
                'payment_ids' => '[6714,6715,6716,6717,6718]',
                'note' => NULL,
                'created_at' => '2026-01-19 21:54:04',
                'updated_at' => '2026-01-19 21:54:04',
            ),
            25 => 
            array (
                'id' => 26,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '40000.00',
                'payment_ids' => '[6782,6783,6784,6785,6786,6787,6788]',
                'note' => NULL,
                'created_at' => '2026-01-27 22:03:04',
                'updated_at' => '2026-01-27 22:03:05',
            ),
            26 => 
            array (
                'id' => 27,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '20000.00',
                'payment_ids' => '[6789,6790,6791,6792]',
                'note' => NULL,
                'created_at' => '2026-01-27 22:12:37',
                'updated_at' => '2026-01-27 22:12:37',
            ),
            27 => 
            array (
                'id' => 28,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '15000.00',
                'payment_ids' => '[6865,6866,6867,6868]',
                'note' => NULL,
                'created_at' => '2026-02-05 22:21:13',
                'updated_at' => '2026-02-05 22:21:13',
            ),
            28 => 
            array (
                'id' => 29,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '28000.00',
                'payment_ids' => '[6900,6901,6902,6903,6904,6905]',
                'note' => NULL,
                'created_at' => '2026-02-09 22:53:48',
                'updated_at' => '2026-02-09 22:53:48',
            ),
            29 => 
            array (
                'id' => 30,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '40500.00',
                'payment_ids' => '[6947,6948,6949,6950,6951]',
                'note' => NULL,
                'created_at' => '2026-02-15 22:15:25',
                'updated_at' => '2026-02-15 22:15:25',
            ),
            30 => 
            array (
                'id' => 31,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '30000.00',
                'payment_ids' => '[6958,6959,6960,6961,6962]',
                'note' => NULL,
                'created_at' => '2026-02-16 22:39:00',
                'updated_at' => '2026-02-16 22:39:00',
            ),
            31 => 
            array (
                'id' => 32,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '20000.00',
                'payment_ids' => '[6994,6995,6996,6997]',
                'note' => NULL,
                'created_at' => '2026-02-18 22:13:34',
                'updated_at' => '2026-02-18 22:13:34',
            ),
        ));
        
        
    }
}