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
                'amount' => '40000.00',
                'payment_ids' => '[3763,3764,3765,3766,3767,3768,3769,3770,3771,3772,3773,3774,3775,3776,3777,3778,3779,3780,3781,3782,3783]',
                'note' => 'Pubali Bank',
                'created_at' => '2025-11-06 11:44:40',
                'updated_at' => '2025-11-06 11:46:40',
            ),
            1 => 
            array (
                'id' => 2,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '110000.00',
                'payment_ids' => '[3878,3879,3880,3881,3882,3883,3884,3885,3886,3887,3888,3889,3890,3891,3892,3893,3894,3895,3896,3897,3898,3899,3900,3901,3902,3903,3904,3905,3906,3907,3908,3909,3910,3911,3912,3913,3914,3915,3916]',
                'note' => 'Pubali Bank',
                'created_at' => '2025-11-09 10:52:25',
                'updated_at' => '2025-11-09 10:52:25',
            ),
            2 => 
            array (
                'id' => 3,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '10000.00',
                'payment_ids' => '[3994,3995,3996]',
                'note' => 'Baksh Payment',
                'created_at' => '2025-11-11 20:07:43',
                'updated_at' => '2025-11-11 20:07:43',
            ),
            3 => 
            array (
                'id' => 4,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '20000.00',
                'payment_ids' => '[4001,4002,4003,4004]',
                'note' => 'Pubali Bank',
                'created_at' => '2025-11-12 12:08:25',
                'updated_at' => '2025-11-12 12:08:25',
            ),
            4 => 
            array (
                'id' => 5,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '25000.00',
                'payment_ids' => '[4065,4066,4067,4068,4069,4070]',
                'note' => 'Pubali Bank',
                'created_at' => '2025-11-15 11:27:22',
                'updated_at' => '2025-11-15 11:27:44',
            ),
            5 => 
            array (
                'id' => 6,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '70000.00',
                'payment_ids' => '[4124,4125,4126,4127,4128,4129,4130,4131,4132,4133,4134,4135,4136,4137,4138,4139,4140,4141,4142,4143,4144]',
                'note' => 'Pubali Bank',
                'created_at' => '2025-11-16 22:17:25',
                'updated_at' => '2025-11-16 22:17:26',
            ),
            6 => 
            array (
                'id' => 7,
                'supplier_id' => 1,
                'account_id' => 1,
                'amount' => '20000.00',
                'payment_ids' => '[4153,4154,4155,4156,4157,4158,4159,4160,4161,4162,4163,4164,4165,4166]',
                'note' => 'Pubali Bank',
                'created_at' => '2025-11-17 19:36:30',
                'updated_at' => '2025-11-17 19:36:31',
            ),
        ));
        
        
    }
}