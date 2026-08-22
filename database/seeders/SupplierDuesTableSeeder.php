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
            8 => 
            array (
                'id' => 9,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '25000.00',
                'payment_ids' => '[5724,5725,5726,5727,5728,5729]',
                'note' => 'Pubali',
                'created_at' => '2025-11-21 03:55:19',
                'updated_at' => '2025-11-21 03:55:19',
            ),
            9 => 
            array (
                'id' => 10,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '45000.00',
                'payment_ids' => '[5770,5771,5772,5773,5774,5775,5776,5777]',
                'note' => NULL,
                'created_at' => '2025-11-25 04:06:38',
                'updated_at' => '2025-11-25 04:06:38',
            ),
            10 => 
            array (
                'id' => 11,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '20000.00',
                'payment_ids' => '[5788,5789,5790]',
                'note' => NULL,
                'created_at' => '2025-11-26 03:56:00',
                'updated_at' => '2025-11-26 03:56:00',
            ),
            11 => 
            array (
                'id' => 12,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '100000.00',
                'payment_ids' => '[5964,5965,5966,5967,5968,5969,5970,5971,5972,5973,5974,5975,5976,5977,5978,5979,5980,5981]',
                'note' => 'Pubali Bank dep.',
                'created_at' => '2025-12-09 04:13:27',
                'updated_at' => '2025-12-09 04:13:27',
            ),
            12 => 
            array (
                'id' => 13,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '48000.00',
                'payment_ids' => '[5999,6000,6001,6002,6003,6004,6005]',
                'note' => NULL,
                'created_at' => '2025-12-10 04:41:13',
                'updated_at' => '2025-12-10 04:41:13',
            ),
            13 => 
            array (
                'id' => 14,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '33000.00',
                'payment_ids' => '[6152,6153,6154,6155,6156,6157]',
                'note' => NULL,
                'created_at' => '2025-12-18 04:08:50',
                'updated_at' => '2025-12-18 04:08:50',
            ),
            14 => 
            array (
                'id' => 15,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '52000.00',
                'payment_ids' => '[6185,6186,6187,6188,6189,6190,6191,6192,6193]',
                'note' => NULL,
                'created_at' => '2025-12-19 04:36:29',
                'updated_at' => '2025-12-19 04:36:29',
            ),
            15 => 
            array (
                'id' => 16,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '63000.00',
                'payment_ids' => '[6241,6242,6243,6244,6245,6246,6247,6248,6249,6250,6251,6252]',
                'note' => NULL,
                'created_at' => '2025-12-22 04:14:07',
                'updated_at' => '2025-12-22 04:14:07',
            ),
            16 => 
            array (
                'id' => 17,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '34500.00',
                'payment_ids' => '[6300,6301,6302,6303,6304,6305,6306]',
                'note' => NULL,
                'created_at' => '2025-12-25 04:12:44',
                'updated_at' => '2025-12-25 04:12:44',
            ),
            17 => 
            array (
                'id' => 18,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '100000.00',
                'payment_ids' => '[6379,6380,6381,6382,6383,6384,6385,6386,6387,6388,6389,6390,6391]',
                'note' => NULL,
                'created_at' => '2025-12-29 04:01:37',
                'updated_at' => '2025-12-29 04:01:37',
            ),
            18 => 
            array (
                'id' => 19,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '62000.00',
                'payment_ids' => '[6516,6517,6518,6519,6520,6521,6522,6523,6524,6525]',
                'note' => NULL,
                'created_at' => '2026-01-06 04:15:33',
                'updated_at' => '2026-01-06 04:15:33',
            ),
            19 => 
            array (
                'id' => 20,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '15000.00',
                'payment_ids' => '[6545,6546]',
                'note' => NULL,
                'created_at' => '2026-01-07 04:11:19',
                'updated_at' => '2026-01-07 04:11:19',
            ),
            20 => 
            array (
                'id' => 21,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '15000.00',
                'payment_ids' => '[6559,6560,6561]',
                'note' => NULL,
                'created_at' => '2026-01-08 05:00:47',
                'updated_at' => '2026-01-08 05:00:47',
            ),
            21 => 
            array (
                'id' => 22,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '60000.00',
                'payment_ids' => '[6620,6621,6622,6623,6624,6625,6626,6627,6628]',
                'note' => NULL,
                'created_at' => '2026-01-12 04:09:18',
                'updated_at' => '2026-01-12 04:09:18',
            ),
            22 => 
            array (
                'id' => 23,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '25000.00',
                'payment_ids' => '[6652,6653,6654]',
                'note' => NULL,
                'created_at' => '2026-01-14 04:11:47',
                'updated_at' => '2026-01-14 04:11:47',
            ),
            23 => 
            array (
                'id' => 24,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '17000.00',
                'payment_ids' => '[6675,6676,6677]',
                'note' => NULL,
                'created_at' => '2026-01-16 03:53:43',
                'updated_at' => '2026-01-16 03:53:43',
            ),
            24 => 
            array (
                'id' => 25,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '28500.00',
                'payment_ids' => '[6714,6715,6716,6717,6718]',
                'note' => NULL,
                'created_at' => '2026-01-20 03:54:04',
                'updated_at' => '2026-01-20 03:54:04',
            ),
            25 => 
            array (
                'id' => 26,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '40000.00',
                'payment_ids' => '[6782,6783,6784,6785,6786,6787,6788]',
                'note' => NULL,
                'created_at' => '2026-01-28 04:03:04',
                'updated_at' => '2026-01-28 04:03:05',
            ),
            26 => 
            array (
                'id' => 27,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '20000.00',
                'payment_ids' => '[6789,6790,6791,6792]',
                'note' => NULL,
                'created_at' => '2026-01-28 04:12:37',
                'updated_at' => '2026-01-28 04:12:37',
            ),
            27 => 
            array (
                'id' => 28,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '15000.00',
                'payment_ids' => '[6865,6866,6867,6868]',
                'note' => NULL,
                'created_at' => '2026-02-06 04:21:13',
                'updated_at' => '2026-02-06 04:21:13',
            ),
            28 => 
            array (
                'id' => 29,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '28000.00',
                'payment_ids' => '[6900,6901,6902,6903,6904,6905]',
                'note' => NULL,
                'created_at' => '2026-02-10 04:53:48',
                'updated_at' => '2026-02-10 04:53:48',
            ),
            29 => 
            array (
                'id' => 30,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '40500.00',
                'payment_ids' => '[6947,6948,6949,6950,6951]',
                'note' => NULL,
                'created_at' => '2026-02-16 04:15:25',
                'updated_at' => '2026-02-16 04:15:25',
            ),
            30 => 
            array (
                'id' => 31,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '30000.00',
                'payment_ids' => '[6958,6959,6960,6961,6962]',
                'note' => NULL,
                'created_at' => '2026-02-17 04:39:00',
                'updated_at' => '2026-02-17 04:39:00',
            ),
            31 => 
            array (
                'id' => 32,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '20000.00',
                'payment_ids' => '[6994,6995,6996,6997]',
                'note' => NULL,
                'created_at' => '2026-02-19 04:13:34',
                'updated_at' => '2026-02-19 04:13:34',
            ),
            32 => 
            array (
                'id' => 33,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '24500.00',
                'payment_ids' => '[7036,7037,7038,7039]',
                'note' => NULL,
                'created_at' => '2026-02-23 04:23:13',
                'updated_at' => '2026-02-23 04:23:13',
            ),
            33 => 
            array (
                'id' => 34,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '23000.00',
                'payment_ids' => '[7065,7066,7067,7068]',
                'note' => NULL,
                'created_at' => '2026-02-25 05:08:34',
                'updated_at' => '2026-02-25 05:08:34',
            ),
            34 => 
            array (
                'id' => 35,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '64500.00',
                'payment_ids' => '[7120,7121,7122,7123,7124,7125,7126,7127,7128,7129,7130,7131,7132,7133]',
                'note' => NULL,
                'created_at' => '2026-02-27 07:14:26',
                'updated_at' => '2026-02-27 07:14:26',
            ),
            35 => 
            array (
                'id' => 36,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '63500.00',
                'payment_ids' => '[7214,7215,7216,7217,7218,7219,7220,7221,7222,7223]',
                'note' => NULL,
                'created_at' => '2026-03-01 06:13:28',
                'updated_at' => '2026-03-01 06:13:28',
            ),
            36 => 
            array (
                'id' => 37,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '30000.00',
                'payment_ids' => '[7238,7239,7240,7241,7242,7243,7244]',
                'note' => NULL,
                'created_at' => '2026-03-01 21:04:27',
                'updated_at' => '2026-03-01 21:04:27',
            ),
            37 => 
            array (
                'id' => 38,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '8930.00',
                'payment_ids' => '[7566,7567,7568]',
                'note' => NULL,
                'created_at' => '2026-03-07 07:49:00',
                'updated_at' => '2026-03-07 07:49:01',
            ),
            38 => 
            array (
                'id' => 39,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '142500.00',
                'payment_ids' => '[7569,7570,7571,7572,7573,7574,7575,7576,7577,7578,7579,7580,7581,7582,7583,7584,7585,7586,7587,7588,7589,7590,7591,7592,7593,7594,7595,7596,7597,7598,7599,7600,7601,7602,7603,7604,7605]',
                'note' => NULL,
                'created_at' => '2026-03-07 07:53:51',
                'updated_at' => '2026-03-07 07:53:51',
            ),
            39 => 
            array (
                'id' => 40,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '139500.00',
                'payment_ids' => '[7777,7778,7779,7780,7781,7782,7783,7784,7785,7786,7787,7788,7789,7790,7791,7792,7793,7794,7795,7796,7797,7798,7799,7800,7801,7802,7803]',
                'note' => NULL,
                'created_at' => '2026-03-09 07:17:59',
                'updated_at' => '2026-03-09 07:18:00',
            ),
            40 => 
            array (
                'id' => 41,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '95000.00',
                'payment_ids' => '[7880,7881,7882,7883,7884,7885,7886,7887,7888,7889,7890,7891,7892,7893,7894,7895,7896,7897]',
                'note' => NULL,
                'created_at' => '2026-03-10 07:08:41',
                'updated_at' => '2026-03-10 07:08:41',
            ),
            41 => 
            array (
                'id' => 42,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '95500.00',
                'payment_ids' => '[7981,7982,7983,7984,7985,7986,7987,7988,7989,7990,7991,7992,7993,7994,7995,7996,7997,7998,7999,8000,8001,8002,8003,8004,8005,8006]',
                'note' => NULL,
                'created_at' => '2026-03-11 07:21:42',
                'updated_at' => '2026-03-11 07:21:42',
            ),
            42 => 
            array (
                'id' => 43,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '146500.00',
                'payment_ids' => '[8107,8108,8109,8110,8111,8112,8113,8114,8115,8116,8117,8118,8119,8120,8121,8122,8123,8124,8125,8126,8127,8128,8129,8130,8131,8132,8133,8134,8135,8136,8137,8138,8139,8140,8141,8142,8143,8144]',
                'note' => NULL,
                'created_at' => '2026-03-12 08:03:39',
                'updated_at' => '2026-03-12 08:03:39',
            ),
            43 => 
            array (
                'id' => 44,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '114000.00',
                'payment_ids' => '[8238,8239,8240,8241,8242,8243,8244,8245,8246,8247,8248,8249,8250,8251,8252,8253,8254,8255,8256,8257,8258,8259,8260,8261,8262,8263,8264,8265,8266,8267,8268]',
                'note' => NULL,
                'created_at' => '2026-03-13 07:28:30',
                'updated_at' => '2026-03-13 07:28:31',
            ),
            44 => 
            array (
                'id' => 45,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '99000.00',
                'payment_ids' => '[8358,8359,8360,8361,8362,8363,8364,8365,8366,8367,8368,8369,8370,8371,8372,8373,8374,8375,8376,8377,8378,8379,8380,8381]',
                'note' => NULL,
                'created_at' => '2026-03-14 07:25:10',
                'updated_at' => '2026-03-14 07:25:11',
            ),
            45 => 
            array (
                'id' => 46,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '109000.00',
                'payment_ids' => '[8576,8577,8578,8579,8580,8581,8582,8583,8584,8585,8586,8587,8588,8589,8590,8591,8592,8593,8594,8595,8596,8597,8598,8599,8600,8601,8602,8603,8604,8605,8606,8607,8608]',
                'note' => NULL,
                'created_at' => '2026-03-16 07:18:38',
                'updated_at' => '2026-03-16 07:18:39',
            ),
            46 => 
            array (
                'id' => 47,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '158000.00',
                'payment_ids' => '[8612,8613,8614,8615,8616,8617,8618,8619,8620,8621,8622,8623,8624,8625,8626,8627,8628,8629,8630,8631,8632,8633,8634,8635,8636,8637,8638,8639,8640,8641,8642,8643,8644,8645,8646,8647,8648,8649,8650,8651,8652,8653,8654,8655]',
                'note' => NULL,
                'created_at' => '2026-03-16 07:57:22',
                'updated_at' => '2026-03-16 07:57:23',
            ),
            47 => 
            array (
                'id' => 48,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '218500.00',
                'payment_ids' => '[8979,8980,8981,8982,8983,8984,8985,8986,8987,8988,8989,8990,8991,8992,8993,8994,8995,8996,8997,8998,8999,9000,9001,9002,9003,9004,9005,9006,9007,9008,9009,9010,9011,9012,9013,9014,9015,9016,9017,9018,9019,9020,9021,9022,9023,9024,9025,9026,9027,9028,9029,9030,9031]',
                'note' => NULL,
                'created_at' => '2026-03-19 08:01:20',
                'updated_at' => '2026-03-19 08:01:21',
            ),
            48 => 
            array (
                'id' => 49,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '212000.00',
                'payment_ids' => '[9160,9161,9162,9163,9164,9165,9166,9167,9168,9169,9170,9171,9172,9173,9174,9175,9176,9177,9178,9179,9180,9181,9182,9183,9184,9185,9186,9187,9188,9189,9190,9191,9192,9193,9194,9195,9196,9197,9198,9199]',
                'note' => NULL,
                'created_at' => '2026-03-20 07:44:47',
                'updated_at' => '2026-03-20 07:44:47',
            ),
            49 => 
            array (
                'id' => 50,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '161000.00',
                'payment_ids' => '[9433,9434,9435,9436,9437,9438,9439,9440,9441,9442,9443,9444,9445,9446,9447,9448,9449,9450,9451,9452,9453,9454,9455,9456,9457,9458,9459,9460,9461]',
                'note' => NULL,
                'created_at' => '2026-03-31 04:05:42',
                'updated_at' => '2026-03-31 04:05:43',
            ),
            50 => 
            array (
                'id' => 51,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '73000.00',
                'payment_ids' => '[9462,9463,9464,9465,9466,9467,9468,9469,9470,9471,9472,9473,9474,9475,9476]',
                'note' => NULL,
                'created_at' => '2026-03-31 04:07:42',
                'updated_at' => '2026-03-31 04:07:42',
            ),
            51 => 
            array (
                'id' => 52,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '24500.00',
                'payment_ids' => '[9561,9562,9563,9564,9565]',
                'note' => NULL,
                'created_at' => '2026-04-15 02:24:34',
                'updated_at' => '2026-04-15 02:24:34',
            ),
            52 => 
            array (
                'id' => 53,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '72500.00',
                'payment_ids' => '[9899,9900,9901,9902,9903,9904,9905,9906,9907,9908,9909,9910,9911,9912,9913,9914]',
                'note' => NULL,
                'created_at' => '2026-05-26 05:55:29',
                'updated_at' => '2026-05-26 05:55:30',
            ),
            53 => 
            array (
                'id' => 54,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '69000.00',
                'payment_ids' => '[9973,9974,9975,9976,9977,9978,9979,9980,9981,9982,9983,9984,9985,9986,9987,9988,9989]',
                'note' => NULL,
                'created_at' => '2026-05-27 06:28:43',
                'updated_at' => '2026-05-27 06:28:43',
            ),
            54 => 
            array (
                'id' => 55,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '81000.00',
                'payment_ids' => '[10067,10068,10069,10070,10071,10072,10073,10074]',
                'note' => NULL,
                'created_at' => '2026-05-28 10:31:12',
                'updated_at' => '2026-05-28 10:31:12',
            ),
            55 => 
            array (
                'id' => 56,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '37000.00',
                'payment_ids' => '[10163,10164,10165,10166,10167,10168]',
                'note' => NULL,
                'created_at' => '2026-06-11 11:44:39',
                'updated_at' => '2026-06-11 11:44:40',
            ),
            56 => 
            array (
                'id' => 57,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '21000.00',
                'payment_ids' => '[10176,10177,10178,10179]',
                'note' => NULL,
                'created_at' => '2026-06-11 21:52:06',
                'updated_at' => '2026-06-11 21:52:06',
            ),
            57 => 
            array (
                'id' => 58,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '12000.00',
                'payment_ids' => '[10194,10195]',
                'note' => NULL,
                'created_at' => '2026-06-14 21:25:10',
                'updated_at' => '2026-06-14 21:25:10',
            ),
            58 => 
            array (
                'id' => 59,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '12000.00',
                'payment_ids' => '[10210,10211]',
                'note' => NULL,
                'created_at' => '2026-06-16 21:35:48',
                'updated_at' => '2026-06-16 21:35:48',
            ),
            59 => 
            array (
                'id' => 60,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '12000.00',
                'payment_ids' => '[10219]',
                'note' => NULL,
                'created_at' => '2026-06-17 21:43:11',
                'updated_at' => '2026-06-17 21:43:11',
            ),
            60 => 
            array (
                'id' => 61,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '10000.00',
                'payment_ids' => '[10230]',
                'note' => NULL,
                'created_at' => '2026-06-20 21:28:15',
                'updated_at' => '2026-06-20 21:28:15',
            ),
            61 => 
            array (
                'id' => 62,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '8500.00',
                'payment_ids' => '[10231]',
                'note' => NULL,
                'created_at' => '2026-06-20 21:55:51',
                'updated_at' => '2026-06-20 21:55:51',
            ),
            62 => 
            array (
                'id' => 63,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '8500.00',
                'payment_ids' => '[10251]',
                'note' => NULL,
                'created_at' => '2026-06-22 21:45:47',
                'updated_at' => '2026-06-22 21:45:47',
            ),
            63 => 
            array (
                'id' => 64,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '6000.00',
                'payment_ids' => '[10258]',
                'note' => NULL,
                'created_at' => '2026-06-23 21:51:06',
                'updated_at' => '2026-06-23 21:51:06',
            ),
            64 => 
            array (
                'id' => 65,
                'supplier_id' => 2,
                'account_id' => 1,
                'amount' => '7500.00',
                'payment_ids' => '[10297]',
                'note' => NULL,
                'created_at' => '2026-06-29 21:40:58',
                'updated_at' => '2026-06-29 21:40:58',
            ),
            65 => 
            array (
                'id' => 66,
                'supplier_id' => 2,
                'account_id' => 1,
                'amount' => '14000.00',
                'payment_ids' => '[10298,10299,10300]',
                'note' => NULL,
                'created_at' => '2026-06-29 21:54:30',
                'updated_at' => '2026-06-29 21:54:30',
            ),
            66 => 
            array (
                'id' => 67,
                'supplier_id' => 2,
                'account_id' => 1,
                'amount' => '7500.00',
                'payment_ids' => '[10304]',
                'note' => NULL,
                'created_at' => '2026-06-30 21:48:26',
                'updated_at' => '2026-06-30 21:48:26',
            ),
            67 => 
            array (
                'id' => 68,
                'supplier_id' => 2,
                'account_id' => 1,
                'amount' => '17000.00',
                'payment_ids' => '[10363,10364,10365]',
                'note' => NULL,
                'created_at' => '2026-07-09 22:51:02',
                'updated_at' => '2026-07-09 22:51:02',
            ),
            68 => 
            array (
                'id' => 69,
                'supplier_id' => 2,
                'account_id' => 1,
                'amount' => '8000.00',
                'payment_ids' => '[10371,10372]',
                'note' => NULL,
                'created_at' => '2026-07-11 21:51:57',
                'updated_at' => '2026-07-11 21:51:57',
            ),
            69 => 
            array (
                'id' => 70,
                'supplier_id' => 2,
                'account_id' => 1,
                'amount' => '16000.00',
                'payment_ids' => '[10391,10392]',
                'note' => NULL,
                'created_at' => '2026-07-13 22:41:23',
                'updated_at' => '2026-07-13 22:41:23',
            ),
            70 => 
            array (
                'id' => 71,
                'supplier_id' => 2,
                'account_id' => 1,
                'amount' => '14000.00',
                'payment_ids' => '[10410,10411,10412]',
                'note' => NULL,
                'created_at' => '2026-07-15 22:00:36',
                'updated_at' => '2026-07-15 22:00:36',
            ),
            71 => 
            array (
                'id' => 72,
                'supplier_id' => 2,
                'account_id' => 1,
                'amount' => '9000.00',
                'payment_ids' => '[10421,10422]',
                'note' => NULL,
                'created_at' => '2026-07-16 22:09:48',
                'updated_at' => '2026-07-16 22:09:48',
            ),
        ));
        
        
    }
}