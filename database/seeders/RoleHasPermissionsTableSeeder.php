<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_has_permissions')->delete();
        
        \DB::table('role_has_permissions')->insert(array (
            0 => 
            array (
                'permission_id' => 4,
                'role_id' => 1,
            ),
            1 => 
            array (
                'permission_id' => 4,
                'role_id' => 2,
            ),
            2 => 
            array (
                'permission_id' => 4,
                'role_id' => 3,
            ),
            3 => 
            array (
                'permission_id' => 4,
                'role_id' => 6,
            ),
            4 => 
            array (
                'permission_id' => 4,
                'role_id' => 8,
            ),
            5 => 
            array (
                'permission_id' => 5,
                'role_id' => 1,
            ),
            6 => 
            array (
                'permission_id' => 5,
                'role_id' => 2,
            ),
            7 => 
            array (
                'permission_id' => 5,
                'role_id' => 3,
            ),
            8 => 
            array (
                'permission_id' => 5,
                'role_id' => 6,
            ),
            9 => 
            array (
                'permission_id' => 5,
                'role_id' => 8,
            ),
            10 => 
            array (
                'permission_id' => 6,
                'role_id' => 1,
            ),
            11 => 
            array (
                'permission_id' => 6,
                'role_id' => 2,
            ),
            12 => 
            array (
                'permission_id' => 6,
                'role_id' => 3,
            ),
            13 => 
            array (
                'permission_id' => 6,
                'role_id' => 6,
            ),
            14 => 
            array (
                'permission_id' => 6,
                'role_id' => 8,
            ),
            15 => 
            array (
                'permission_id' => 7,
                'role_id' => 1,
            ),
            16 => 
            array (
                'permission_id' => 7,
                'role_id' => 2,
            ),
            17 => 
            array (
                'permission_id' => 7,
                'role_id' => 3,
            ),
            18 => 
            array (
                'permission_id' => 7,
                'role_id' => 5,
            ),
            19 => 
            array (
                'permission_id' => 7,
                'role_id' => 6,
            ),
            20 => 
            array (
                'permission_id' => 7,
                'role_id' => 8,
            ),
            21 => 
            array (
                'permission_id' => 8,
                'role_id' => 1,
            ),
            22 => 
            array (
                'permission_id' => 8,
                'role_id' => 2,
            ),
            23 => 
            array (
                'permission_id' => 8,
                'role_id' => 3,
            ),
            24 => 
            array (
                'permission_id' => 8,
                'role_id' => 6,
            ),
            25 => 
            array (
                'permission_id' => 8,
                'role_id' => 8,
            ),
            26 => 
            array (
                'permission_id' => 9,
                'role_id' => 1,
            ),
            27 => 
            array (
                'permission_id' => 9,
                'role_id' => 2,
            ),
            28 => 
            array (
                'permission_id' => 9,
                'role_id' => 3,
            ),
            29 => 
            array (
                'permission_id' => 9,
                'role_id' => 6,
            ),
            30 => 
            array (
                'permission_id' => 9,
                'role_id' => 8,
            ),
            31 => 
            array (
                'permission_id' => 10,
                'role_id' => 1,
            ),
            32 => 
            array (
                'permission_id' => 10,
                'role_id' => 2,
            ),
            33 => 
            array (
                'permission_id' => 10,
                'role_id' => 3,
            ),
            34 => 
            array (
                'permission_id' => 10,
                'role_id' => 6,
            ),
            35 => 
            array (
                'permission_id' => 10,
                'role_id' => 8,
            ),
            36 => 
            array (
                'permission_id' => 11,
                'role_id' => 1,
            ),
            37 => 
            array (
                'permission_id' => 11,
                'role_id' => 2,
            ),
            38 => 
            array (
                'permission_id' => 11,
                'role_id' => 3,
            ),
            39 => 
            array (
                'permission_id' => 11,
                'role_id' => 6,
            ),
            40 => 
            array (
                'permission_id' => 11,
                'role_id' => 8,
            ),
            41 => 
            array (
                'permission_id' => 12,
                'role_id' => 1,
            ),
            42 => 
            array (
                'permission_id' => 12,
                'role_id' => 2,
            ),
            43 => 
            array (
                'permission_id' => 12,
                'role_id' => 3,
            ),
            44 => 
            array (
                'permission_id' => 12,
                'role_id' => 5,
            ),
            45 => 
            array (
                'permission_id' => 12,
                'role_id' => 6,
            ),
            46 => 
            array (
                'permission_id' => 12,
                'role_id' => 8,
            ),
            47 => 
            array (
                'permission_id' => 13,
                'role_id' => 1,
            ),
            48 => 
            array (
                'permission_id' => 13,
                'role_id' => 2,
            ),
            49 => 
            array (
                'permission_id' => 13,
                'role_id' => 3,
            ),
            50 => 
            array (
                'permission_id' => 13,
                'role_id' => 5,
            ),
            51 => 
            array (
                'permission_id' => 13,
                'role_id' => 6,
            ),
            52 => 
            array (
                'permission_id' => 13,
                'role_id' => 8,
            ),
            53 => 
            array (
                'permission_id' => 14,
                'role_id' => 1,
            ),
            54 => 
            array (
                'permission_id' => 14,
                'role_id' => 2,
            ),
            55 => 
            array (
                'permission_id' => 14,
                'role_id' => 3,
            ),
            56 => 
            array (
                'permission_id' => 14,
                'role_id' => 6,
            ),
            57 => 
            array (
                'permission_id' => 14,
                'role_id' => 8,
            ),
            58 => 
            array (
                'permission_id' => 15,
                'role_id' => 1,
            ),
            59 => 
            array (
                'permission_id' => 15,
                'role_id' => 2,
            ),
            60 => 
            array (
                'permission_id' => 15,
                'role_id' => 3,
            ),
            61 => 
            array (
                'permission_id' => 15,
                'role_id' => 6,
            ),
            62 => 
            array (
                'permission_id' => 15,
                'role_id' => 8,
            ),
            63 => 
            array (
                'permission_id' => 16,
                'role_id' => 1,
            ),
            64 => 
            array (
                'permission_id' => 16,
                'role_id' => 2,
            ),
            65 => 
            array (
                'permission_id' => 16,
                'role_id' => 3,
            ),
            66 => 
            array (
                'permission_id' => 16,
                'role_id' => 5,
            ),
            67 => 
            array (
                'permission_id' => 16,
                'role_id' => 6,
            ),
            68 => 
            array (
                'permission_id' => 16,
                'role_id' => 8,
            ),
            69 => 
            array (
                'permission_id' => 17,
                'role_id' => 1,
            ),
            70 => 
            array (
                'permission_id' => 17,
                'role_id' => 2,
            ),
            71 => 
            array (
                'permission_id' => 17,
                'role_id' => 3,
            ),
            72 => 
            array (
                'permission_id' => 17,
                'role_id' => 5,
            ),
            73 => 
            array (
                'permission_id' => 17,
                'role_id' => 6,
            ),
            74 => 
            array (
                'permission_id' => 17,
                'role_id' => 8,
            ),
            75 => 
            array (
                'permission_id' => 18,
                'role_id' => 1,
            ),
            76 => 
            array (
                'permission_id' => 18,
                'role_id' => 2,
            ),
            77 => 
            array (
                'permission_id' => 18,
                'role_id' => 3,
            ),
            78 => 
            array (
                'permission_id' => 18,
                'role_id' => 6,
            ),
            79 => 
            array (
                'permission_id' => 18,
                'role_id' => 8,
            ),
            80 => 
            array (
                'permission_id' => 19,
                'role_id' => 1,
            ),
            81 => 
            array (
                'permission_id' => 19,
                'role_id' => 2,
            ),
            82 => 
            array (
                'permission_id' => 19,
                'role_id' => 3,
            ),
            83 => 
            array (
                'permission_id' => 19,
                'role_id' => 6,
            ),
            84 => 
            array (
                'permission_id' => 19,
                'role_id' => 8,
            ),
            85 => 
            array (
                'permission_id' => 20,
                'role_id' => 1,
            ),
            86 => 
            array (
                'permission_id' => 20,
                'role_id' => 2,
            ),
            87 => 
            array (
                'permission_id' => 20,
                'role_id' => 3,
            ),
            88 => 
            array (
                'permission_id' => 20,
                'role_id' => 6,
            ),
            89 => 
            array (
                'permission_id' => 20,
                'role_id' => 8,
            ),
            90 => 
            array (
                'permission_id' => 21,
                'role_id' => 1,
            ),
            91 => 
            array (
                'permission_id' => 21,
                'role_id' => 2,
            ),
            92 => 
            array (
                'permission_id' => 21,
                'role_id' => 3,
            ),
            93 => 
            array (
                'permission_id' => 21,
                'role_id' => 6,
            ),
            94 => 
            array (
                'permission_id' => 21,
                'role_id' => 8,
            ),
            95 => 
            array (
                'permission_id' => 22,
                'role_id' => 1,
            ),
            96 => 
            array (
                'permission_id' => 22,
                'role_id' => 2,
            ),
            97 => 
            array (
                'permission_id' => 22,
                'role_id' => 3,
            ),
            98 => 
            array (
                'permission_id' => 22,
                'role_id' => 6,
            ),
            99 => 
            array (
                'permission_id' => 22,
                'role_id' => 8,
            ),
            100 => 
            array (
                'permission_id' => 23,
                'role_id' => 1,
            ),
            101 => 
            array (
                'permission_id' => 23,
                'role_id' => 2,
            ),
            102 => 
            array (
                'permission_id' => 23,
                'role_id' => 3,
            ),
            103 => 
            array (
                'permission_id' => 23,
                'role_id' => 6,
            ),
            104 => 
            array (
                'permission_id' => 23,
                'role_id' => 8,
            ),
            105 => 
            array (
                'permission_id' => 24,
                'role_id' => 1,
            ),
            106 => 
            array (
                'permission_id' => 24,
                'role_id' => 2,
            ),
            107 => 
            array (
                'permission_id' => 24,
                'role_id' => 3,
            ),
            108 => 
            array (
                'permission_id' => 24,
                'role_id' => 5,
            ),
            109 => 
            array (
                'permission_id' => 24,
                'role_id' => 6,
            ),
            110 => 
            array (
                'permission_id' => 24,
                'role_id' => 8,
            ),
            111 => 
            array (
                'permission_id' => 25,
                'role_id' => 1,
            ),
            112 => 
            array (
                'permission_id' => 25,
                'role_id' => 2,
            ),
            113 => 
            array (
                'permission_id' => 25,
                'role_id' => 3,
            ),
            114 => 
            array (
                'permission_id' => 25,
                'role_id' => 6,
            ),
            115 => 
            array (
                'permission_id' => 25,
                'role_id' => 8,
            ),
            116 => 
            array (
                'permission_id' => 26,
                'role_id' => 1,
            ),
            117 => 
            array (
                'permission_id' => 26,
                'role_id' => 2,
            ),
            118 => 
            array (
                'permission_id' => 26,
                'role_id' => 3,
            ),
            119 => 
            array (
                'permission_id' => 26,
                'role_id' => 6,
            ),
            120 => 
            array (
                'permission_id' => 26,
                'role_id' => 8,
            ),
            121 => 
            array (
                'permission_id' => 27,
                'role_id' => 1,
            ),
            122 => 
            array (
                'permission_id' => 27,
                'role_id' => 2,
            ),
            123 => 
            array (
                'permission_id' => 27,
                'role_id' => 3,
            ),
            124 => 
            array (
                'permission_id' => 27,
                'role_id' => 6,
            ),
            125 => 
            array (
                'permission_id' => 27,
                'role_id' => 8,
            ),
            126 => 
            array (
                'permission_id' => 28,
                'role_id' => 1,
            ),
            127 => 
            array (
                'permission_id' => 28,
                'role_id' => 2,
            ),
            128 => 
            array (
                'permission_id' => 28,
                'role_id' => 3,
            ),
            129 => 
            array (
                'permission_id' => 28,
                'role_id' => 5,
            ),
            130 => 
            array (
                'permission_id' => 28,
                'role_id' => 6,
            ),
            131 => 
            array (
                'permission_id' => 28,
                'role_id' => 8,
            ),
            132 => 
            array (
                'permission_id' => 29,
                'role_id' => 1,
            ),
            133 => 
            array (
                'permission_id' => 29,
                'role_id' => 2,
            ),
            134 => 
            array (
                'permission_id' => 29,
                'role_id' => 3,
            ),
            135 => 
            array (
                'permission_id' => 29,
                'role_id' => 6,
            ),
            136 => 
            array (
                'permission_id' => 29,
                'role_id' => 8,
            ),
            137 => 
            array (
                'permission_id' => 30,
                'role_id' => 1,
            ),
            138 => 
            array (
                'permission_id' => 30,
                'role_id' => 2,
            ),
            139 => 
            array (
                'permission_id' => 30,
                'role_id' => 3,
            ),
            140 => 
            array (
                'permission_id' => 30,
                'role_id' => 6,
            ),
            141 => 
            array (
                'permission_id' => 30,
                'role_id' => 8,
            ),
            142 => 
            array (
                'permission_id' => 31,
                'role_id' => 1,
            ),
            143 => 
            array (
                'permission_id' => 31,
                'role_id' => 2,
            ),
            144 => 
            array (
                'permission_id' => 31,
                'role_id' => 3,
            ),
            145 => 
            array (
                'permission_id' => 31,
                'role_id' => 6,
            ),
            146 => 
            array (
                'permission_id' => 31,
                'role_id' => 8,
            ),
            147 => 
            array (
                'permission_id' => 32,
                'role_id' => 1,
            ),
            148 => 
            array (
                'permission_id' => 32,
                'role_id' => 2,
            ),
            149 => 
            array (
                'permission_id' => 32,
                'role_id' => 3,
            ),
            150 => 
            array (
                'permission_id' => 32,
                'role_id' => 5,
            ),
            151 => 
            array (
                'permission_id' => 32,
                'role_id' => 6,
            ),
            152 => 
            array (
                'permission_id' => 32,
                'role_id' => 8,
            ),
            153 => 
            array (
                'permission_id' => 33,
                'role_id' => 1,
            ),
            154 => 
            array (
                'permission_id' => 33,
                'role_id' => 2,
            ),
            155 => 
            array (
                'permission_id' => 33,
                'role_id' => 3,
            ),
            156 => 
            array (
                'permission_id' => 33,
                'role_id' => 6,
            ),
            157 => 
            array (
                'permission_id' => 33,
                'role_id' => 8,
            ),
            158 => 
            array (
                'permission_id' => 34,
                'role_id' => 1,
            ),
            159 => 
            array (
                'permission_id' => 34,
                'role_id' => 2,
            ),
            160 => 
            array (
                'permission_id' => 34,
                'role_id' => 3,
            ),
            161 => 
            array (
                'permission_id' => 34,
                'role_id' => 6,
            ),
            162 => 
            array (
                'permission_id' => 34,
                'role_id' => 8,
            ),
            163 => 
            array (
                'permission_id' => 35,
                'role_id' => 1,
            ),
            164 => 
            array (
                'permission_id' => 35,
                'role_id' => 2,
            ),
            165 => 
            array (
                'permission_id' => 35,
                'role_id' => 3,
            ),
            166 => 
            array (
                'permission_id' => 35,
                'role_id' => 6,
            ),
            167 => 
            array (
                'permission_id' => 35,
                'role_id' => 8,
            ),
            168 => 
            array (
                'permission_id' => 36,
                'role_id' => 1,
            ),
            169 => 
            array (
                'permission_id' => 36,
                'role_id' => 2,
            ),
            170 => 
            array (
                'permission_id' => 36,
                'role_id' => 3,
            ),
            171 => 
            array (
                'permission_id' => 36,
                'role_id' => 6,
            ),
            172 => 
            array (
                'permission_id' => 36,
                'role_id' => 8,
            ),
            173 => 
            array (
                'permission_id' => 37,
                'role_id' => 1,
            ),
            174 => 
            array (
                'permission_id' => 37,
                'role_id' => 2,
            ),
            175 => 
            array (
                'permission_id' => 37,
                'role_id' => 3,
            ),
            176 => 
            array (
                'permission_id' => 37,
                'role_id' => 6,
            ),
            177 => 
            array (
                'permission_id' => 37,
                'role_id' => 8,
            ),
            178 => 
            array (
                'permission_id' => 38,
                'role_id' => 1,
            ),
            179 => 
            array (
                'permission_id' => 38,
                'role_id' => 2,
            ),
            180 => 
            array (
                'permission_id' => 38,
                'role_id' => 3,
            ),
            181 => 
            array (
                'permission_id' => 38,
                'role_id' => 6,
            ),
            182 => 
            array (
                'permission_id' => 38,
                'role_id' => 8,
            ),
            183 => 
            array (
                'permission_id' => 39,
                'role_id' => 1,
            ),
            184 => 
            array (
                'permission_id' => 39,
                'role_id' => 2,
            ),
            185 => 
            array (
                'permission_id' => 39,
                'role_id' => 3,
            ),
            186 => 
            array (
                'permission_id' => 39,
                'role_id' => 6,
            ),
            187 => 
            array (
                'permission_id' => 39,
                'role_id' => 8,
            ),
            188 => 
            array (
                'permission_id' => 40,
                'role_id' => 1,
            ),
            189 => 
            array (
                'permission_id' => 40,
                'role_id' => 2,
            ),
            190 => 
            array (
                'permission_id' => 40,
                'role_id' => 3,
            ),
            191 => 
            array (
                'permission_id' => 40,
                'role_id' => 6,
            ),
            192 => 
            array (
                'permission_id' => 40,
                'role_id' => 8,
            ),
            193 => 
            array (
                'permission_id' => 41,
                'role_id' => 1,
            ),
            194 => 
            array (
                'permission_id' => 41,
                'role_id' => 2,
            ),
            195 => 
            array (
                'permission_id' => 41,
                'role_id' => 3,
            ),
            196 => 
            array (
                'permission_id' => 41,
                'role_id' => 6,
            ),
            197 => 
            array (
                'permission_id' => 41,
                'role_id' => 8,
            ),
            198 => 
            array (
                'permission_id' => 42,
                'role_id' => 1,
            ),
            199 => 
            array (
                'permission_id' => 42,
                'role_id' => 2,
            ),
            200 => 
            array (
                'permission_id' => 42,
                'role_id' => 3,
            ),
            201 => 
            array (
                'permission_id' => 42,
                'role_id' => 6,
            ),
            202 => 
            array (
                'permission_id' => 42,
                'role_id' => 8,
            ),
            203 => 
            array (
                'permission_id' => 43,
                'role_id' => 1,
            ),
            204 => 
            array (
                'permission_id' => 43,
                'role_id' => 2,
            ),
            205 => 
            array (
                'permission_id' => 43,
                'role_id' => 3,
            ),
            206 => 
            array (
                'permission_id' => 43,
                'role_id' => 6,
            ),
            207 => 
            array (
                'permission_id' => 43,
                'role_id' => 8,
            ),
            208 => 
            array (
                'permission_id' => 44,
                'role_id' => 1,
            ),
            209 => 
            array (
                'permission_id' => 44,
                'role_id' => 2,
            ),
            210 => 
            array (
                'permission_id' => 44,
                'role_id' => 3,
            ),
            211 => 
            array (
                'permission_id' => 44,
                'role_id' => 6,
            ),
            212 => 
            array (
                'permission_id' => 44,
                'role_id' => 8,
            ),
            213 => 
            array (
                'permission_id' => 45,
                'role_id' => 1,
            ),
            214 => 
            array (
                'permission_id' => 45,
                'role_id' => 2,
            ),
            215 => 
            array (
                'permission_id' => 45,
                'role_id' => 3,
            ),
            216 => 
            array (
                'permission_id' => 45,
                'role_id' => 6,
            ),
            217 => 
            array (
                'permission_id' => 45,
                'role_id' => 8,
            ),
            218 => 
            array (
                'permission_id' => 46,
                'role_id' => 1,
            ),
            219 => 
            array (
                'permission_id' => 46,
                'role_id' => 2,
            ),
            220 => 
            array (
                'permission_id' => 46,
                'role_id' => 3,
            ),
            221 => 
            array (
                'permission_id' => 46,
                'role_id' => 6,
            ),
            222 => 
            array (
                'permission_id' => 46,
                'role_id' => 8,
            ),
            223 => 
            array (
                'permission_id' => 47,
                'role_id' => 1,
            ),
            224 => 
            array (
                'permission_id' => 47,
                'role_id' => 2,
            ),
            225 => 
            array (
                'permission_id' => 47,
                'role_id' => 3,
            ),
            226 => 
            array (
                'permission_id' => 47,
                'role_id' => 6,
            ),
            227 => 
            array (
                'permission_id' => 47,
                'role_id' => 8,
            ),
            228 => 
            array (
                'permission_id' => 48,
                'role_id' => 1,
            ),
            229 => 
            array (
                'permission_id' => 48,
                'role_id' => 2,
            ),
            230 => 
            array (
                'permission_id' => 48,
                'role_id' => 3,
            ),
            231 => 
            array (
                'permission_id' => 48,
                'role_id' => 6,
            ),
            232 => 
            array (
                'permission_id' => 48,
                'role_id' => 8,
            ),
            233 => 
            array (
                'permission_id' => 49,
                'role_id' => 1,
            ),
            234 => 
            array (
                'permission_id' => 49,
                'role_id' => 2,
            ),
            235 => 
            array (
                'permission_id' => 49,
                'role_id' => 3,
            ),
            236 => 
            array (
                'permission_id' => 49,
                'role_id' => 6,
            ),
            237 => 
            array (
                'permission_id' => 49,
                'role_id' => 8,
            ),
            238 => 
            array (
                'permission_id' => 50,
                'role_id' => 1,
            ),
            239 => 
            array (
                'permission_id' => 50,
                'role_id' => 2,
            ),
            240 => 
            array (
                'permission_id' => 50,
                'role_id' => 3,
            ),
            241 => 
            array (
                'permission_id' => 50,
                'role_id' => 6,
            ),
            242 => 
            array (
                'permission_id' => 50,
                'role_id' => 8,
            ),
            243 => 
            array (
                'permission_id' => 51,
                'role_id' => 1,
            ),
            244 => 
            array (
                'permission_id' => 51,
                'role_id' => 2,
            ),
            245 => 
            array (
                'permission_id' => 51,
                'role_id' => 3,
            ),
            246 => 
            array (
                'permission_id' => 51,
                'role_id' => 6,
            ),
            247 => 
            array (
                'permission_id' => 51,
                'role_id' => 8,
            ),
            248 => 
            array (
                'permission_id' => 52,
                'role_id' => 1,
            ),
            249 => 
            array (
                'permission_id' => 52,
                'role_id' => 2,
            ),
            250 => 
            array (
                'permission_id' => 52,
                'role_id' => 3,
            ),
            251 => 
            array (
                'permission_id' => 52,
                'role_id' => 6,
            ),
            252 => 
            array (
                'permission_id' => 52,
                'role_id' => 8,
            ),
            253 => 
            array (
                'permission_id' => 53,
                'role_id' => 1,
            ),
            254 => 
            array (
                'permission_id' => 53,
                'role_id' => 2,
            ),
            255 => 
            array (
                'permission_id' => 53,
                'role_id' => 3,
            ),
            256 => 
            array (
                'permission_id' => 53,
                'role_id' => 6,
            ),
            257 => 
            array (
                'permission_id' => 53,
                'role_id' => 8,
            ),
            258 => 
            array (
                'permission_id' => 54,
                'role_id' => 1,
            ),
            259 => 
            array (
                'permission_id' => 54,
                'role_id' => 2,
            ),
            260 => 
            array (
                'permission_id' => 54,
                'role_id' => 3,
            ),
            261 => 
            array (
                'permission_id' => 54,
                'role_id' => 6,
            ),
            262 => 
            array (
                'permission_id' => 54,
                'role_id' => 8,
            ),
            263 => 
            array (
                'permission_id' => 55,
                'role_id' => 1,
            ),
            264 => 
            array (
                'permission_id' => 55,
                'role_id' => 2,
            ),
            265 => 
            array (
                'permission_id' => 55,
                'role_id' => 3,
            ),
            266 => 
            array (
                'permission_id' => 55,
                'role_id' => 5,
            ),
            267 => 
            array (
                'permission_id' => 55,
                'role_id' => 6,
            ),
            268 => 
            array (
                'permission_id' => 55,
                'role_id' => 8,
            ),
            269 => 
            array (
                'permission_id' => 56,
                'role_id' => 1,
            ),
            270 => 
            array (
                'permission_id' => 56,
                'role_id' => 2,
            ),
            271 => 
            array (
                'permission_id' => 56,
                'role_id' => 3,
            ),
            272 => 
            array (
                'permission_id' => 56,
                'role_id' => 5,
            ),
            273 => 
            array (
                'permission_id' => 56,
                'role_id' => 6,
            ),
            274 => 
            array (
                'permission_id' => 56,
                'role_id' => 8,
            ),
            275 => 
            array (
                'permission_id' => 57,
                'role_id' => 1,
            ),
            276 => 
            array (
                'permission_id' => 57,
                'role_id' => 2,
            ),
            277 => 
            array (
                'permission_id' => 57,
                'role_id' => 3,
            ),
            278 => 
            array (
                'permission_id' => 57,
                'role_id' => 6,
            ),
            279 => 
            array (
                'permission_id' => 57,
                'role_id' => 8,
            ),
            280 => 
            array (
                'permission_id' => 58,
                'role_id' => 1,
            ),
            281 => 
            array (
                'permission_id' => 58,
                'role_id' => 2,
            ),
            282 => 
            array (
                'permission_id' => 58,
                'role_id' => 3,
            ),
            283 => 
            array (
                'permission_id' => 58,
                'role_id' => 6,
            ),
            284 => 
            array (
                'permission_id' => 58,
                'role_id' => 8,
            ),
            285 => 
            array (
                'permission_id' => 59,
                'role_id' => 1,
            ),
            286 => 
            array (
                'permission_id' => 59,
                'role_id' => 2,
            ),
            287 => 
            array (
                'permission_id' => 59,
                'role_id' => 3,
            ),
            288 => 
            array (
                'permission_id' => 59,
                'role_id' => 8,
            ),
            289 => 
            array (
                'permission_id' => 61,
                'role_id' => 1,
            ),
            290 => 
            array (
                'permission_id' => 61,
                'role_id' => 2,
            ),
            291 => 
            array (
                'permission_id' => 61,
                'role_id' => 3,
            ),
            292 => 
            array (
                'permission_id' => 61,
                'role_id' => 5,
            ),
            293 => 
            array (
                'permission_id' => 61,
                'role_id' => 6,
            ),
            294 => 
            array (
                'permission_id' => 61,
                'role_id' => 8,
            ),
            295 => 
            array (
                'permission_id' => 62,
                'role_id' => 1,
            ),
            296 => 
            array (
                'permission_id' => 62,
                'role_id' => 2,
            ),
            297 => 
            array (
                'permission_id' => 62,
                'role_id' => 3,
            ),
            298 => 
            array (
                'permission_id' => 62,
                'role_id' => 6,
            ),
            299 => 
            array (
                'permission_id' => 62,
                'role_id' => 8,
            ),
            300 => 
            array (
                'permission_id' => 63,
                'role_id' => 1,
            ),
            301 => 
            array (
                'permission_id' => 63,
                'role_id' => 2,
            ),
            302 => 
            array (
                'permission_id' => 63,
                'role_id' => 3,
            ),
            303 => 
            array (
                'permission_id' => 63,
                'role_id' => 5,
            ),
            304 => 
            array (
                'permission_id' => 63,
                'role_id' => 6,
            ),
            305 => 
            array (
                'permission_id' => 63,
                'role_id' => 8,
            ),
            306 => 
            array (
                'permission_id' => 64,
                'role_id' => 1,
            ),
            307 => 
            array (
                'permission_id' => 64,
                'role_id' => 2,
            ),
            308 => 
            array (
                'permission_id' => 64,
                'role_id' => 3,
            ),
            309 => 
            array (
                'permission_id' => 64,
                'role_id' => 6,
            ),
            310 => 
            array (
                'permission_id' => 64,
                'role_id' => 8,
            ),
            311 => 
            array (
                'permission_id' => 65,
                'role_id' => 1,
            ),
            312 => 
            array (
                'permission_id' => 65,
                'role_id' => 2,
            ),
            313 => 
            array (
                'permission_id' => 65,
                'role_id' => 3,
            ),
            314 => 
            array (
                'permission_id' => 65,
                'role_id' => 6,
            ),
            315 => 
            array (
                'permission_id' => 65,
                'role_id' => 8,
            ),
            316 => 
            array (
                'permission_id' => 66,
                'role_id' => 1,
            ),
            317 => 
            array (
                'permission_id' => 66,
                'role_id' => 2,
            ),
            318 => 
            array (
                'permission_id' => 66,
                'role_id' => 3,
            ),
            319 => 
            array (
                'permission_id' => 66,
                'role_id' => 6,
            ),
            320 => 
            array (
                'permission_id' => 66,
                'role_id' => 8,
            ),
            321 => 
            array (
                'permission_id' => 67,
                'role_id' => 1,
            ),
            322 => 
            array (
                'permission_id' => 67,
                'role_id' => 2,
            ),
            323 => 
            array (
                'permission_id' => 67,
                'role_id' => 3,
            ),
            324 => 
            array (
                'permission_id' => 67,
                'role_id' => 6,
            ),
            325 => 
            array (
                'permission_id' => 67,
                'role_id' => 8,
            ),
            326 => 
            array (
                'permission_id' => 68,
                'role_id' => 1,
            ),
            327 => 
            array (
                'permission_id' => 68,
                'role_id' => 2,
            ),
            328 => 
            array (
                'permission_id' => 68,
                'role_id' => 3,
            ),
            329 => 
            array (
                'permission_id' => 68,
                'role_id' => 6,
            ),
            330 => 
            array (
                'permission_id' => 68,
                'role_id' => 8,
            ),
            331 => 
            array (
                'permission_id' => 69,
                'role_id' => 1,
            ),
            332 => 
            array (
                'permission_id' => 69,
                'role_id' => 2,
            ),
            333 => 
            array (
                'permission_id' => 69,
                'role_id' => 3,
            ),
            334 => 
            array (
                'permission_id' => 69,
                'role_id' => 6,
            ),
            335 => 
            array (
                'permission_id' => 69,
                'role_id' => 8,
            ),
            336 => 
            array (
                'permission_id' => 70,
                'role_id' => 1,
            ),
            337 => 
            array (
                'permission_id' => 70,
                'role_id' => 2,
            ),
            338 => 
            array (
                'permission_id' => 70,
                'role_id' => 3,
            ),
            339 => 
            array (
                'permission_id' => 70,
                'role_id' => 6,
            ),
            340 => 
            array (
                'permission_id' => 70,
                'role_id' => 8,
            ),
            341 => 
            array (
                'permission_id' => 71,
                'role_id' => 1,
            ),
            342 => 
            array (
                'permission_id' => 71,
                'role_id' => 2,
            ),
            343 => 
            array (
                'permission_id' => 71,
                'role_id' => 3,
            ),
            344 => 
            array (
                'permission_id' => 71,
                'role_id' => 6,
            ),
            345 => 
            array (
                'permission_id' => 71,
                'role_id' => 8,
            ),
            346 => 
            array (
                'permission_id' => 72,
                'role_id' => 1,
            ),
            347 => 
            array (
                'permission_id' => 72,
                'role_id' => 2,
            ),
            348 => 
            array (
                'permission_id' => 72,
                'role_id' => 3,
            ),
            349 => 
            array (
                'permission_id' => 72,
                'role_id' => 6,
            ),
            350 => 
            array (
                'permission_id' => 72,
                'role_id' => 8,
            ),
            351 => 
            array (
                'permission_id' => 73,
                'role_id' => 1,
            ),
            352 => 
            array (
                'permission_id' => 73,
                'role_id' => 2,
            ),
            353 => 
            array (
                'permission_id' => 73,
                'role_id' => 3,
            ),
            354 => 
            array (
                'permission_id' => 73,
                'role_id' => 6,
            ),
            355 => 
            array (
                'permission_id' => 73,
                'role_id' => 8,
            ),
            356 => 
            array (
                'permission_id' => 74,
                'role_id' => 1,
            ),
            357 => 
            array (
                'permission_id' => 74,
                'role_id' => 2,
            ),
            358 => 
            array (
                'permission_id' => 74,
                'role_id' => 3,
            ),
            359 => 
            array (
                'permission_id' => 74,
                'role_id' => 6,
            ),
            360 => 
            array (
                'permission_id' => 74,
                'role_id' => 8,
            ),
            361 => 
            array (
                'permission_id' => 75,
                'role_id' => 1,
            ),
            362 => 
            array (
                'permission_id' => 75,
                'role_id' => 2,
            ),
            363 => 
            array (
                'permission_id' => 75,
                'role_id' => 3,
            ),
            364 => 
            array (
                'permission_id' => 75,
                'role_id' => 6,
            ),
            365 => 
            array (
                'permission_id' => 75,
                'role_id' => 8,
            ),
            366 => 
            array (
                'permission_id' => 76,
                'role_id' => 1,
            ),
            367 => 
            array (
                'permission_id' => 76,
                'role_id' => 2,
            ),
            368 => 
            array (
                'permission_id' => 76,
                'role_id' => 3,
            ),
            369 => 
            array (
                'permission_id' => 76,
                'role_id' => 6,
            ),
            370 => 
            array (
                'permission_id' => 76,
                'role_id' => 8,
            ),
            371 => 
            array (
                'permission_id' => 77,
                'role_id' => 1,
            ),
            372 => 
            array (
                'permission_id' => 77,
                'role_id' => 2,
            ),
            373 => 
            array (
                'permission_id' => 77,
                'role_id' => 3,
            ),
            374 => 
            array (
                'permission_id' => 77,
                'role_id' => 6,
            ),
            375 => 
            array (
                'permission_id' => 77,
                'role_id' => 8,
            ),
            376 => 
            array (
                'permission_id' => 78,
                'role_id' => 1,
            ),
            377 => 
            array (
                'permission_id' => 78,
                'role_id' => 2,
            ),
            378 => 
            array (
                'permission_id' => 78,
                'role_id' => 3,
            ),
            379 => 
            array (
                'permission_id' => 78,
                'role_id' => 6,
            ),
            380 => 
            array (
                'permission_id' => 78,
                'role_id' => 8,
            ),
            381 => 
            array (
                'permission_id' => 79,
                'role_id' => 1,
            ),
            382 => 
            array (
                'permission_id' => 79,
                'role_id' => 2,
            ),
            383 => 
            array (
                'permission_id' => 79,
                'role_id' => 3,
            ),
            384 => 
            array (
                'permission_id' => 79,
                'role_id' => 6,
            ),
            385 => 
            array (
                'permission_id' => 79,
                'role_id' => 8,
            ),
            386 => 
            array (
                'permission_id' => 82,
                'role_id' => 1,
            ),
            387 => 
            array (
                'permission_id' => 82,
                'role_id' => 2,
            ),
            388 => 
            array (
                'permission_id' => 82,
                'role_id' => 3,
            ),
            389 => 
            array (
                'permission_id' => 82,
                'role_id' => 5,
            ),
            390 => 
            array (
                'permission_id' => 82,
                'role_id' => 6,
            ),
            391 => 
            array (
                'permission_id' => 82,
                'role_id' => 8,
            ),
            392 => 
            array (
                'permission_id' => 84,
                'role_id' => 1,
            ),
            393 => 
            array (
                'permission_id' => 84,
                'role_id' => 2,
            ),
            394 => 
            array (
                'permission_id' => 84,
                'role_id' => 3,
            ),
            395 => 
            array (
                'permission_id' => 84,
                'role_id' => 6,
            ),
            396 => 
            array (
                'permission_id' => 84,
                'role_id' => 8,
            ),
            397 => 
            array (
                'permission_id' => 85,
                'role_id' => 1,
            ),
            398 => 
            array (
                'permission_id' => 85,
                'role_id' => 2,
            ),
            399 => 
            array (
                'permission_id' => 85,
                'role_id' => 3,
            ),
            400 => 
            array (
                'permission_id' => 85,
                'role_id' => 6,
            ),
            401 => 
            array (
                'permission_id' => 85,
                'role_id' => 8,
            ),
            402 => 
            array (
                'permission_id' => 86,
                'role_id' => 1,
            ),
            403 => 
            array (
                'permission_id' => 86,
                'role_id' => 2,
            ),
            404 => 
            array (
                'permission_id' => 86,
                'role_id' => 3,
            ),
            405 => 
            array (
                'permission_id' => 86,
                'role_id' => 6,
            ),
            406 => 
            array (
                'permission_id' => 86,
                'role_id' => 8,
            ),
            407 => 
            array (
                'permission_id' => 87,
                'role_id' => 1,
            ),
            408 => 
            array (
                'permission_id' => 87,
                'role_id' => 2,
            ),
            409 => 
            array (
                'permission_id' => 87,
                'role_id' => 3,
            ),
            410 => 
            array (
                'permission_id' => 87,
                'role_id' => 8,
            ),
            411 => 
            array (
                'permission_id' => 88,
                'role_id' => 1,
            ),
            412 => 
            array (
                'permission_id' => 88,
                'role_id' => 2,
            ),
            413 => 
            array (
                'permission_id' => 88,
                'role_id' => 3,
            ),
            414 => 
            array (
                'permission_id' => 88,
                'role_id' => 6,
            ),
            415 => 
            array (
                'permission_id' => 88,
                'role_id' => 8,
            ),
            416 => 
            array (
                'permission_id' => 89,
                'role_id' => 1,
            ),
            417 => 
            array (
                'permission_id' => 89,
                'role_id' => 2,
            ),
            418 => 
            array (
                'permission_id' => 89,
                'role_id' => 3,
            ),
            419 => 
            array (
                'permission_id' => 89,
                'role_id' => 6,
            ),
            420 => 
            array (
                'permission_id' => 89,
                'role_id' => 8,
            ),
            421 => 
            array (
                'permission_id' => 90,
                'role_id' => 1,
            ),
            422 => 
            array (
                'permission_id' => 90,
                'role_id' => 2,
            ),
            423 => 
            array (
                'permission_id' => 90,
                'role_id' => 3,
            ),
            424 => 
            array (
                'permission_id' => 90,
                'role_id' => 6,
            ),
            425 => 
            array (
                'permission_id' => 90,
                'role_id' => 8,
            ),
            426 => 
            array (
                'permission_id' => 91,
                'role_id' => 1,
            ),
            427 => 
            array (
                'permission_id' => 91,
                'role_id' => 2,
            ),
            428 => 
            array (
                'permission_id' => 91,
                'role_id' => 3,
            ),
            429 => 
            array (
                'permission_id' => 91,
                'role_id' => 6,
            ),
            430 => 
            array (
                'permission_id' => 91,
                'role_id' => 8,
            ),
            431 => 
            array (
                'permission_id' => 92,
                'role_id' => 1,
            ),
            432 => 
            array (
                'permission_id' => 92,
                'role_id' => 2,
            ),
            433 => 
            array (
                'permission_id' => 92,
                'role_id' => 3,
            ),
            434 => 
            array (
                'permission_id' => 92,
                'role_id' => 6,
            ),
            435 => 
            array (
                'permission_id' => 92,
                'role_id' => 8,
            ),
            436 => 
            array (
                'permission_id' => 93,
                'role_id' => 1,
            ),
            437 => 
            array (
                'permission_id' => 93,
                'role_id' => 2,
            ),
            438 => 
            array (
                'permission_id' => 93,
                'role_id' => 3,
            ),
            439 => 
            array (
                'permission_id' => 93,
                'role_id' => 5,
            ),
            440 => 
            array (
                'permission_id' => 93,
                'role_id' => 6,
            ),
            441 => 
            array (
                'permission_id' => 93,
                'role_id' => 8,
            ),
            442 => 
            array (
                'permission_id' => 94,
                'role_id' => 1,
            ),
            443 => 
            array (
                'permission_id' => 94,
                'role_id' => 2,
            ),
            444 => 
            array (
                'permission_id' => 94,
                'role_id' => 3,
            ),
            445 => 
            array (
                'permission_id' => 94,
                'role_id' => 6,
            ),
            446 => 
            array (
                'permission_id' => 94,
                'role_id' => 8,
            ),
            447 => 
            array (
                'permission_id' => 95,
                'role_id' => 1,
            ),
            448 => 
            array (
                'permission_id' => 95,
                'role_id' => 2,
            ),
            449 => 
            array (
                'permission_id' => 95,
                'role_id' => 3,
            ),
            450 => 
            array (
                'permission_id' => 95,
                'role_id' => 6,
            ),
            451 => 
            array (
                'permission_id' => 95,
                'role_id' => 8,
            ),
            452 => 
            array (
                'permission_id' => 96,
                'role_id' => 1,
            ),
            453 => 
            array (
                'permission_id' => 96,
                'role_id' => 2,
            ),
            454 => 
            array (
                'permission_id' => 96,
                'role_id' => 3,
            ),
            455 => 
            array (
                'permission_id' => 96,
                'role_id' => 6,
            ),
            456 => 
            array (
                'permission_id' => 96,
                'role_id' => 8,
            ),
            457 => 
            array (
                'permission_id' => 97,
                'role_id' => 1,
            ),
            458 => 
            array (
                'permission_id' => 97,
                'role_id' => 2,
            ),
            459 => 
            array (
                'permission_id' => 97,
                'role_id' => 3,
            ),
            460 => 
            array (
                'permission_id' => 97,
                'role_id' => 6,
            ),
            461 => 
            array (
                'permission_id' => 97,
                'role_id' => 8,
            ),
            462 => 
            array (
                'permission_id' => 98,
                'role_id' => 1,
            ),
            463 => 
            array (
                'permission_id' => 98,
                'role_id' => 2,
            ),
            464 => 
            array (
                'permission_id' => 98,
                'role_id' => 3,
            ),
            465 => 
            array (
                'permission_id' => 98,
                'role_id' => 6,
            ),
            466 => 
            array (
                'permission_id' => 98,
                'role_id' => 8,
            ),
            467 => 
            array (
                'permission_id' => 99,
                'role_id' => 1,
            ),
            468 => 
            array (
                'permission_id' => 99,
                'role_id' => 2,
            ),
            469 => 
            array (
                'permission_id' => 99,
                'role_id' => 3,
            ),
            470 => 
            array (
                'permission_id' => 99,
                'role_id' => 6,
            ),
            471 => 
            array (
                'permission_id' => 99,
                'role_id' => 8,
            ),
            472 => 
            array (
                'permission_id' => 100,
                'role_id' => 1,
            ),
            473 => 
            array (
                'permission_id' => 100,
                'role_id' => 2,
            ),
            474 => 
            array (
                'permission_id' => 100,
                'role_id' => 3,
            ),
            475 => 
            array (
                'permission_id' => 100,
                'role_id' => 8,
            ),
            476 => 
            array (
                'permission_id' => 101,
                'role_id' => 1,
            ),
            477 => 
            array (
                'permission_id' => 101,
                'role_id' => 2,
            ),
            478 => 
            array (
                'permission_id' => 101,
                'role_id' => 3,
            ),
            479 => 
            array (
                'permission_id' => 101,
                'role_id' => 6,
            ),
            480 => 
            array (
                'permission_id' => 101,
                'role_id' => 8,
            ),
            481 => 
            array (
                'permission_id' => 102,
                'role_id' => 1,
            ),
            482 => 
            array (
                'permission_id' => 102,
                'role_id' => 2,
            ),
            483 => 
            array (
                'permission_id' => 102,
                'role_id' => 3,
            ),
            484 => 
            array (
                'permission_id' => 102,
                'role_id' => 6,
            ),
            485 => 
            array (
                'permission_id' => 102,
                'role_id' => 8,
            ),
            486 => 
            array (
                'permission_id' => 106,
                'role_id' => 1,
            ),
            487 => 
            array (
                'permission_id' => 106,
                'role_id' => 2,
            ),
            488 => 
            array (
                'permission_id' => 106,
                'role_id' => 3,
            ),
            489 => 
            array (
                'permission_id' => 106,
                'role_id' => 5,
            ),
            490 => 
            array (
                'permission_id' => 106,
                'role_id' => 6,
            ),
            491 => 
            array (
                'permission_id' => 106,
                'role_id' => 8,
            ),
            492 => 
            array (
                'permission_id' => 107,
                'role_id' => 1,
            ),
            493 => 
            array (
                'permission_id' => 107,
                'role_id' => 2,
            ),
            494 => 
            array (
                'permission_id' => 107,
                'role_id' => 3,
            ),
            495 => 
            array (
                'permission_id' => 107,
                'role_id' => 6,
            ),
            496 => 
            array (
                'permission_id' => 107,
                'role_id' => 8,
            ),
            497 => 
            array (
                'permission_id' => 108,
                'role_id' => 1,
            ),
            498 => 
            array (
                'permission_id' => 108,
                'role_id' => 2,
            ),
            499 => 
            array (
                'permission_id' => 108,
                'role_id' => 3,
            ),
        ));
        \DB::table('role_has_permissions')->insert(array (
            0 => 
            array (
                'permission_id' => 108,
                'role_id' => 6,
            ),
            1 => 
            array (
                'permission_id' => 108,
                'role_id' => 8,
            ),
            2 => 
            array (
                'permission_id' => 109,
                'role_id' => 1,
            ),
            3 => 
            array (
                'permission_id' => 109,
                'role_id' => 2,
            ),
            4 => 
            array (
                'permission_id' => 109,
                'role_id' => 3,
            ),
            5 => 
            array (
                'permission_id' => 109,
                'role_id' => 6,
            ),
            6 => 
            array (
                'permission_id' => 109,
                'role_id' => 8,
            ),
            7 => 
            array (
                'permission_id' => 110,
                'role_id' => 1,
            ),
            8 => 
            array (
                'permission_id' => 110,
                'role_id' => 2,
            ),
            9 => 
            array (
                'permission_id' => 110,
                'role_id' => 3,
            ),
            10 => 
            array (
                'permission_id' => 110,
                'role_id' => 6,
            ),
            11 => 
            array (
                'permission_id' => 110,
                'role_id' => 8,
            ),
            12 => 
            array (
                'permission_id' => 111,
                'role_id' => 1,
            ),
            13 => 
            array (
                'permission_id' => 111,
                'role_id' => 2,
            ),
            14 => 
            array (
                'permission_id' => 111,
                'role_id' => 3,
            ),
            15 => 
            array (
                'permission_id' => 111,
                'role_id' => 6,
            ),
            16 => 
            array (
                'permission_id' => 111,
                'role_id' => 8,
            ),
            17 => 
            array (
                'permission_id' => 112,
                'role_id' => 1,
            ),
            18 => 
            array (
                'permission_id' => 112,
                'role_id' => 2,
            ),
            19 => 
            array (
                'permission_id' => 112,
                'role_id' => 3,
            ),
            20 => 
            array (
                'permission_id' => 112,
                'role_id' => 6,
            ),
            21 => 
            array (
                'permission_id' => 112,
                'role_id' => 8,
            ),
            22 => 
            array (
                'permission_id' => 113,
                'role_id' => 1,
            ),
            23 => 
            array (
                'permission_id' => 113,
                'role_id' => 2,
            ),
            24 => 
            array (
                'permission_id' => 113,
                'role_id' => 3,
            ),
            25 => 
            array (
                'permission_id' => 113,
                'role_id' => 6,
            ),
            26 => 
            array (
                'permission_id' => 113,
                'role_id' => 8,
            ),
            27 => 
            array (
                'permission_id' => 114,
                'role_id' => 1,
            ),
            28 => 
            array (
                'permission_id' => 114,
                'role_id' => 2,
            ),
            29 => 
            array (
                'permission_id' => 114,
                'role_id' => 3,
            ),
            30 => 
            array (
                'permission_id' => 114,
                'role_id' => 6,
            ),
            31 => 
            array (
                'permission_id' => 114,
                'role_id' => 8,
            ),
            32 => 
            array (
                'permission_id' => 115,
                'role_id' => 1,
            ),
            33 => 
            array (
                'permission_id' => 115,
                'role_id' => 2,
            ),
            34 => 
            array (
                'permission_id' => 115,
                'role_id' => 3,
            ),
            35 => 
            array (
                'permission_id' => 115,
                'role_id' => 6,
            ),
            36 => 
            array (
                'permission_id' => 115,
                'role_id' => 8,
            ),
            37 => 
            array (
                'permission_id' => 116,
                'role_id' => 1,
            ),
            38 => 
            array (
                'permission_id' => 116,
                'role_id' => 2,
            ),
            39 => 
            array (
                'permission_id' => 116,
                'role_id' => 3,
            ),
            40 => 
            array (
                'permission_id' => 116,
                'role_id' => 6,
            ),
            41 => 
            array (
                'permission_id' => 116,
                'role_id' => 8,
            ),
            42 => 
            array (
                'permission_id' => 117,
                'role_id' => 1,
            ),
            43 => 
            array (
                'permission_id' => 117,
                'role_id' => 2,
            ),
            44 => 
            array (
                'permission_id' => 117,
                'role_id' => 3,
            ),
            45 => 
            array (
                'permission_id' => 117,
                'role_id' => 5,
            ),
            46 => 
            array (
                'permission_id' => 117,
                'role_id' => 6,
            ),
            47 => 
            array (
                'permission_id' => 117,
                'role_id' => 8,
            ),
            48 => 
            array (
                'permission_id' => 118,
                'role_id' => 1,
            ),
            49 => 
            array (
                'permission_id' => 118,
                'role_id' => 2,
            ),
            50 => 
            array (
                'permission_id' => 118,
                'role_id' => 3,
            ),
            51 => 
            array (
                'permission_id' => 118,
                'role_id' => 5,
            ),
            52 => 
            array (
                'permission_id' => 118,
                'role_id' => 6,
            ),
            53 => 
            array (
                'permission_id' => 118,
                'role_id' => 8,
            ),
            54 => 
            array (
                'permission_id' => 119,
                'role_id' => 1,
            ),
            55 => 
            array (
                'permission_id' => 119,
                'role_id' => 2,
            ),
            56 => 
            array (
                'permission_id' => 119,
                'role_id' => 3,
            ),
            57 => 
            array (
                'permission_id' => 119,
                'role_id' => 6,
            ),
            58 => 
            array (
                'permission_id' => 119,
                'role_id' => 8,
            ),
            59 => 
            array (
                'permission_id' => 120,
                'role_id' => 1,
            ),
            60 => 
            array (
                'permission_id' => 120,
                'role_id' => 2,
            ),
            61 => 
            array (
                'permission_id' => 120,
                'role_id' => 3,
            ),
            62 => 
            array (
                'permission_id' => 120,
                'role_id' => 6,
            ),
            63 => 
            array (
                'permission_id' => 120,
                'role_id' => 8,
            ),
            64 => 
            array (
                'permission_id' => 121,
                'role_id' => 1,
            ),
            65 => 
            array (
                'permission_id' => 121,
                'role_id' => 2,
            ),
            66 => 
            array (
                'permission_id' => 121,
                'role_id' => 3,
            ),
            67 => 
            array (
                'permission_id' => 121,
                'role_id' => 6,
            ),
            68 => 
            array (
                'permission_id' => 121,
                'role_id' => 8,
            ),
            69 => 
            array (
                'permission_id' => 122,
                'role_id' => 1,
            ),
            70 => 
            array (
                'permission_id' => 122,
                'role_id' => 2,
            ),
            71 => 
            array (
                'permission_id' => 122,
                'role_id' => 3,
            ),
            72 => 
            array (
                'permission_id' => 122,
                'role_id' => 6,
            ),
            73 => 
            array (
                'permission_id' => 122,
                'role_id' => 8,
            ),
            74 => 
            array (
                'permission_id' => 124,
                'role_id' => 1,
            ),
            75 => 
            array (
                'permission_id' => 124,
                'role_id' => 2,
            ),
            76 => 
            array (
                'permission_id' => 124,
                'role_id' => 3,
            ),
            77 => 
            array (
                'permission_id' => 124,
                'role_id' => 5,
            ),
            78 => 
            array (
                'permission_id' => 124,
                'role_id' => 6,
            ),
            79 => 
            array (
                'permission_id' => 124,
                'role_id' => 8,
            ),
            80 => 
            array (
                'permission_id' => 125,
                'role_id' => 1,
            ),
            81 => 
            array (
                'permission_id' => 125,
                'role_id' => 2,
            ),
            82 => 
            array (
                'permission_id' => 125,
                'role_id' => 3,
            ),
            83 => 
            array (
                'permission_id' => 125,
                'role_id' => 6,
            ),
            84 => 
            array (
                'permission_id' => 125,
                'role_id' => 8,
            ),
            85 => 
            array (
                'permission_id' => 126,
                'role_id' => 1,
            ),
            86 => 
            array (
                'permission_id' => 126,
                'role_id' => 2,
            ),
            87 => 
            array (
                'permission_id' => 126,
                'role_id' => 3,
            ),
            88 => 
            array (
                'permission_id' => 126,
                'role_id' => 6,
            ),
            89 => 
            array (
                'permission_id' => 126,
                'role_id' => 8,
            ),
        ));
        
        
    }
}