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
                'role_id' => 6,
            ),
            8 => 
            array (
                'permission_id' => 5,
                'role_id' => 8,
            ),
            9 => 
            array (
                'permission_id' => 6,
                'role_id' => 1,
            ),
            10 => 
            array (
                'permission_id' => 6,
                'role_id' => 2,
            ),
            11 => 
            array (
                'permission_id' => 6,
                'role_id' => 3,
            ),
            12 => 
            array (
                'permission_id' => 6,
                'role_id' => 6,
            ),
            13 => 
            array (
                'permission_id' => 6,
                'role_id' => 8,
            ),
            14 => 
            array (
                'permission_id' => 7,
                'role_id' => 1,
            ),
            15 => 
            array (
                'permission_id' => 7,
                'role_id' => 2,
            ),
            16 => 
            array (
                'permission_id' => 7,
                'role_id' => 3,
            ),
            17 => 
            array (
                'permission_id' => 7,
                'role_id' => 5,
            ),
            18 => 
            array (
                'permission_id' => 7,
                'role_id' => 6,
            ),
            19 => 
            array (
                'permission_id' => 7,
                'role_id' => 8,
            ),
            20 => 
            array (
                'permission_id' => 8,
                'role_id' => 1,
            ),
            21 => 
            array (
                'permission_id' => 8,
                'role_id' => 2,
            ),
            22 => 
            array (
                'permission_id' => 8,
                'role_id' => 3,
            ),
            23 => 
            array (
                'permission_id' => 8,
                'role_id' => 6,
            ),
            24 => 
            array (
                'permission_id' => 8,
                'role_id' => 8,
            ),
            25 => 
            array (
                'permission_id' => 9,
                'role_id' => 1,
            ),
            26 => 
            array (
                'permission_id' => 9,
                'role_id' => 2,
            ),
            27 => 
            array (
                'permission_id' => 9,
                'role_id' => 3,
            ),
            28 => 
            array (
                'permission_id' => 9,
                'role_id' => 6,
            ),
            29 => 
            array (
                'permission_id' => 9,
                'role_id' => 8,
            ),
            30 => 
            array (
                'permission_id' => 10,
                'role_id' => 1,
            ),
            31 => 
            array (
                'permission_id' => 10,
                'role_id' => 2,
            ),
            32 => 
            array (
                'permission_id' => 10,
                'role_id' => 3,
            ),
            33 => 
            array (
                'permission_id' => 10,
                'role_id' => 6,
            ),
            34 => 
            array (
                'permission_id' => 10,
                'role_id' => 8,
            ),
            35 => 
            array (
                'permission_id' => 11,
                'role_id' => 1,
            ),
            36 => 
            array (
                'permission_id' => 11,
                'role_id' => 2,
            ),
            37 => 
            array (
                'permission_id' => 11,
                'role_id' => 6,
            ),
            38 => 
            array (
                'permission_id' => 11,
                'role_id' => 8,
            ),
            39 => 
            array (
                'permission_id' => 12,
                'role_id' => 1,
            ),
            40 => 
            array (
                'permission_id' => 12,
                'role_id' => 2,
            ),
            41 => 
            array (
                'permission_id' => 12,
                'role_id' => 3,
            ),
            42 => 
            array (
                'permission_id' => 12,
                'role_id' => 5,
            ),
            43 => 
            array (
                'permission_id' => 12,
                'role_id' => 6,
            ),
            44 => 
            array (
                'permission_id' => 12,
                'role_id' => 8,
            ),
            45 => 
            array (
                'permission_id' => 13,
                'role_id' => 1,
            ),
            46 => 
            array (
                'permission_id' => 13,
                'role_id' => 2,
            ),
            47 => 
            array (
                'permission_id' => 13,
                'role_id' => 3,
            ),
            48 => 
            array (
                'permission_id' => 13,
                'role_id' => 5,
            ),
            49 => 
            array (
                'permission_id' => 13,
                'role_id' => 6,
            ),
            50 => 
            array (
                'permission_id' => 13,
                'role_id' => 8,
            ),
            51 => 
            array (
                'permission_id' => 14,
                'role_id' => 1,
            ),
            52 => 
            array (
                'permission_id' => 14,
                'role_id' => 2,
            ),
            53 => 
            array (
                'permission_id' => 14,
                'role_id' => 3,
            ),
            54 => 
            array (
                'permission_id' => 14,
                'role_id' => 6,
            ),
            55 => 
            array (
                'permission_id' => 14,
                'role_id' => 8,
            ),
            56 => 
            array (
                'permission_id' => 15,
                'role_id' => 1,
            ),
            57 => 
            array (
                'permission_id' => 15,
                'role_id' => 2,
            ),
            58 => 
            array (
                'permission_id' => 15,
                'role_id' => 6,
            ),
            59 => 
            array (
                'permission_id' => 15,
                'role_id' => 8,
            ),
            60 => 
            array (
                'permission_id' => 16,
                'role_id' => 1,
            ),
            61 => 
            array (
                'permission_id' => 16,
                'role_id' => 2,
            ),
            62 => 
            array (
                'permission_id' => 16,
                'role_id' => 3,
            ),
            63 => 
            array (
                'permission_id' => 16,
                'role_id' => 5,
            ),
            64 => 
            array (
                'permission_id' => 16,
                'role_id' => 6,
            ),
            65 => 
            array (
                'permission_id' => 16,
                'role_id' => 8,
            ),
            66 => 
            array (
                'permission_id' => 17,
                'role_id' => 1,
            ),
            67 => 
            array (
                'permission_id' => 17,
                'role_id' => 2,
            ),
            68 => 
            array (
                'permission_id' => 17,
                'role_id' => 3,
            ),
            69 => 
            array (
                'permission_id' => 17,
                'role_id' => 5,
            ),
            70 => 
            array (
                'permission_id' => 17,
                'role_id' => 6,
            ),
            71 => 
            array (
                'permission_id' => 17,
                'role_id' => 8,
            ),
            72 => 
            array (
                'permission_id' => 18,
                'role_id' => 1,
            ),
            73 => 
            array (
                'permission_id' => 18,
                'role_id' => 2,
            ),
            74 => 
            array (
                'permission_id' => 18,
                'role_id' => 3,
            ),
            75 => 
            array (
                'permission_id' => 18,
                'role_id' => 6,
            ),
            76 => 
            array (
                'permission_id' => 18,
                'role_id' => 8,
            ),
            77 => 
            array (
                'permission_id' => 19,
                'role_id' => 1,
            ),
            78 => 
            array (
                'permission_id' => 19,
                'role_id' => 2,
            ),
            79 => 
            array (
                'permission_id' => 19,
                'role_id' => 6,
            ),
            80 => 
            array (
                'permission_id' => 19,
                'role_id' => 8,
            ),
            81 => 
            array (
                'permission_id' => 20,
                'role_id' => 1,
            ),
            82 => 
            array (
                'permission_id' => 20,
                'role_id' => 2,
            ),
            83 => 
            array (
                'permission_id' => 20,
                'role_id' => 3,
            ),
            84 => 
            array (
                'permission_id' => 20,
                'role_id' => 6,
            ),
            85 => 
            array (
                'permission_id' => 20,
                'role_id' => 8,
            ),
            86 => 
            array (
                'permission_id' => 21,
                'role_id' => 1,
            ),
            87 => 
            array (
                'permission_id' => 21,
                'role_id' => 2,
            ),
            88 => 
            array (
                'permission_id' => 21,
                'role_id' => 3,
            ),
            89 => 
            array (
                'permission_id' => 21,
                'role_id' => 6,
            ),
            90 => 
            array (
                'permission_id' => 21,
                'role_id' => 8,
            ),
            91 => 
            array (
                'permission_id' => 22,
                'role_id' => 1,
            ),
            92 => 
            array (
                'permission_id' => 22,
                'role_id' => 2,
            ),
            93 => 
            array (
                'permission_id' => 22,
                'role_id' => 3,
            ),
            94 => 
            array (
                'permission_id' => 22,
                'role_id' => 6,
            ),
            95 => 
            array (
                'permission_id' => 22,
                'role_id' => 8,
            ),
            96 => 
            array (
                'permission_id' => 23,
                'role_id' => 1,
            ),
            97 => 
            array (
                'permission_id' => 23,
                'role_id' => 2,
            ),
            98 => 
            array (
                'permission_id' => 23,
                'role_id' => 6,
            ),
            99 => 
            array (
                'permission_id' => 23,
                'role_id' => 8,
            ),
            100 => 
            array (
                'permission_id' => 24,
                'role_id' => 1,
            ),
            101 => 
            array (
                'permission_id' => 24,
                'role_id' => 2,
            ),
            102 => 
            array (
                'permission_id' => 24,
                'role_id' => 3,
            ),
            103 => 
            array (
                'permission_id' => 24,
                'role_id' => 5,
            ),
            104 => 
            array (
                'permission_id' => 24,
                'role_id' => 6,
            ),
            105 => 
            array (
                'permission_id' => 24,
                'role_id' => 8,
            ),
            106 => 
            array (
                'permission_id' => 25,
                'role_id' => 1,
            ),
            107 => 
            array (
                'permission_id' => 25,
                'role_id' => 2,
            ),
            108 => 
            array (
                'permission_id' => 25,
                'role_id' => 3,
            ),
            109 => 
            array (
                'permission_id' => 25,
                'role_id' => 6,
            ),
            110 => 
            array (
                'permission_id' => 25,
                'role_id' => 8,
            ),
            111 => 
            array (
                'permission_id' => 26,
                'role_id' => 1,
            ),
            112 => 
            array (
                'permission_id' => 26,
                'role_id' => 2,
            ),
            113 => 
            array (
                'permission_id' => 26,
                'role_id' => 3,
            ),
            114 => 
            array (
                'permission_id' => 26,
                'role_id' => 6,
            ),
            115 => 
            array (
                'permission_id' => 26,
                'role_id' => 8,
            ),
            116 => 
            array (
                'permission_id' => 27,
                'role_id' => 1,
            ),
            117 => 
            array (
                'permission_id' => 27,
                'role_id' => 2,
            ),
            118 => 
            array (
                'permission_id' => 27,
                'role_id' => 6,
            ),
            119 => 
            array (
                'permission_id' => 27,
                'role_id' => 8,
            ),
            120 => 
            array (
                'permission_id' => 28,
                'role_id' => 1,
            ),
            121 => 
            array (
                'permission_id' => 28,
                'role_id' => 2,
            ),
            122 => 
            array (
                'permission_id' => 28,
                'role_id' => 3,
            ),
            123 => 
            array (
                'permission_id' => 28,
                'role_id' => 5,
            ),
            124 => 
            array (
                'permission_id' => 28,
                'role_id' => 6,
            ),
            125 => 
            array (
                'permission_id' => 28,
                'role_id' => 8,
            ),
            126 => 
            array (
                'permission_id' => 29,
                'role_id' => 1,
            ),
            127 => 
            array (
                'permission_id' => 29,
                'role_id' => 2,
            ),
            128 => 
            array (
                'permission_id' => 29,
                'role_id' => 3,
            ),
            129 => 
            array (
                'permission_id' => 29,
                'role_id' => 6,
            ),
            130 => 
            array (
                'permission_id' => 29,
                'role_id' => 8,
            ),
            131 => 
            array (
                'permission_id' => 30,
                'role_id' => 1,
            ),
            132 => 
            array (
                'permission_id' => 30,
                'role_id' => 2,
            ),
            133 => 
            array (
                'permission_id' => 30,
                'role_id' => 3,
            ),
            134 => 
            array (
                'permission_id' => 30,
                'role_id' => 6,
            ),
            135 => 
            array (
                'permission_id' => 30,
                'role_id' => 8,
            ),
            136 => 
            array (
                'permission_id' => 31,
                'role_id' => 1,
            ),
            137 => 
            array (
                'permission_id' => 31,
                'role_id' => 2,
            ),
            138 => 
            array (
                'permission_id' => 31,
                'role_id' => 6,
            ),
            139 => 
            array (
                'permission_id' => 31,
                'role_id' => 8,
            ),
            140 => 
            array (
                'permission_id' => 32,
                'role_id' => 1,
            ),
            141 => 
            array (
                'permission_id' => 32,
                'role_id' => 2,
            ),
            142 => 
            array (
                'permission_id' => 32,
                'role_id' => 3,
            ),
            143 => 
            array (
                'permission_id' => 32,
                'role_id' => 5,
            ),
            144 => 
            array (
                'permission_id' => 32,
                'role_id' => 6,
            ),
            145 => 
            array (
                'permission_id' => 32,
                'role_id' => 8,
            ),
            146 => 
            array (
                'permission_id' => 33,
                'role_id' => 1,
            ),
            147 => 
            array (
                'permission_id' => 33,
                'role_id' => 2,
            ),
            148 => 
            array (
                'permission_id' => 33,
                'role_id' => 3,
            ),
            149 => 
            array (
                'permission_id' => 33,
                'role_id' => 6,
            ),
            150 => 
            array (
                'permission_id' => 33,
                'role_id' => 8,
            ),
            151 => 
            array (
                'permission_id' => 34,
                'role_id' => 1,
            ),
            152 => 
            array (
                'permission_id' => 34,
                'role_id' => 2,
            ),
            153 => 
            array (
                'permission_id' => 34,
                'role_id' => 3,
            ),
            154 => 
            array (
                'permission_id' => 34,
                'role_id' => 6,
            ),
            155 => 
            array (
                'permission_id' => 34,
                'role_id' => 8,
            ),
            156 => 
            array (
                'permission_id' => 35,
                'role_id' => 1,
            ),
            157 => 
            array (
                'permission_id' => 35,
                'role_id' => 2,
            ),
            158 => 
            array (
                'permission_id' => 35,
                'role_id' => 6,
            ),
            159 => 
            array (
                'permission_id' => 35,
                'role_id' => 8,
            ),
            160 => 
            array (
                'permission_id' => 36,
                'role_id' => 1,
            ),
            161 => 
            array (
                'permission_id' => 36,
                'role_id' => 2,
            ),
            162 => 
            array (
                'permission_id' => 36,
                'role_id' => 3,
            ),
            163 => 
            array (
                'permission_id' => 36,
                'role_id' => 5,
            ),
            164 => 
            array (
                'permission_id' => 36,
                'role_id' => 6,
            ),
            165 => 
            array (
                'permission_id' => 36,
                'role_id' => 8,
            ),
            166 => 
            array (
                'permission_id' => 37,
                'role_id' => 1,
            ),
            167 => 
            array (
                'permission_id' => 37,
                'role_id' => 2,
            ),
            168 => 
            array (
                'permission_id' => 37,
                'role_id' => 3,
            ),
            169 => 
            array (
                'permission_id' => 37,
                'role_id' => 5,
            ),
            170 => 
            array (
                'permission_id' => 37,
                'role_id' => 6,
            ),
            171 => 
            array (
                'permission_id' => 37,
                'role_id' => 8,
            ),
            172 => 
            array (
                'permission_id' => 38,
                'role_id' => 1,
            ),
            173 => 
            array (
                'permission_id' => 38,
                'role_id' => 2,
            ),
            174 => 
            array (
                'permission_id' => 38,
                'role_id' => 3,
            ),
            175 => 
            array (
                'permission_id' => 38,
                'role_id' => 5,
            ),
            176 => 
            array (
                'permission_id' => 38,
                'role_id' => 6,
            ),
            177 => 
            array (
                'permission_id' => 38,
                'role_id' => 8,
            ),
            178 => 
            array (
                'permission_id' => 39,
                'role_id' => 1,
            ),
            179 => 
            array (
                'permission_id' => 39,
                'role_id' => 2,
            ),
            180 => 
            array (
                'permission_id' => 39,
                'role_id' => 3,
            ),
            181 => 
            array (
                'permission_id' => 39,
                'role_id' => 5,
            ),
            182 => 
            array (
                'permission_id' => 39,
                'role_id' => 6,
            ),
            183 => 
            array (
                'permission_id' => 39,
                'role_id' => 8,
            ),
            184 => 
            array (
                'permission_id' => 40,
                'role_id' => 1,
            ),
            185 => 
            array (
                'permission_id' => 40,
                'role_id' => 2,
            ),
            186 => 
            array (
                'permission_id' => 40,
                'role_id' => 3,
            ),
            187 => 
            array (
                'permission_id' => 40,
                'role_id' => 6,
            ),
            188 => 
            array (
                'permission_id' => 40,
                'role_id' => 8,
            ),
            189 => 
            array (
                'permission_id' => 41,
                'role_id' => 1,
            ),
            190 => 
            array (
                'permission_id' => 41,
                'role_id' => 2,
            ),
            191 => 
            array (
                'permission_id' => 41,
                'role_id' => 3,
            ),
            192 => 
            array (
                'permission_id' => 41,
                'role_id' => 6,
            ),
            193 => 
            array (
                'permission_id' => 41,
                'role_id' => 8,
            ),
            194 => 
            array (
                'permission_id' => 42,
                'role_id' => 1,
            ),
            195 => 
            array (
                'permission_id' => 42,
                'role_id' => 2,
            ),
            196 => 
            array (
                'permission_id' => 42,
                'role_id' => 3,
            ),
            197 => 
            array (
                'permission_id' => 42,
                'role_id' => 6,
            ),
            198 => 
            array (
                'permission_id' => 42,
                'role_id' => 8,
            ),
            199 => 
            array (
                'permission_id' => 43,
                'role_id' => 1,
            ),
            200 => 
            array (
                'permission_id' => 43,
                'role_id' => 2,
            ),
            201 => 
            array (
                'permission_id' => 43,
                'role_id' => 3,
            ),
            202 => 
            array (
                'permission_id' => 43,
                'role_id' => 6,
            ),
            203 => 
            array (
                'permission_id' => 43,
                'role_id' => 8,
            ),
            204 => 
            array (
                'permission_id' => 44,
                'role_id' => 1,
            ),
            205 => 
            array (
                'permission_id' => 44,
                'role_id' => 2,
            ),
            206 => 
            array (
                'permission_id' => 44,
                'role_id' => 6,
            ),
            207 => 
            array (
                'permission_id' => 44,
                'role_id' => 8,
            ),
            208 => 
            array (
                'permission_id' => 45,
                'role_id' => 1,
            ),
            209 => 
            array (
                'permission_id' => 45,
                'role_id' => 2,
            ),
            210 => 
            array (
                'permission_id' => 45,
                'role_id' => 3,
            ),
            211 => 
            array (
                'permission_id' => 45,
                'role_id' => 6,
            ),
            212 => 
            array (
                'permission_id' => 45,
                'role_id' => 8,
            ),
            213 => 
            array (
                'permission_id' => 46,
                'role_id' => 1,
            ),
            214 => 
            array (
                'permission_id' => 46,
                'role_id' => 2,
            ),
            215 => 
            array (
                'permission_id' => 46,
                'role_id' => 3,
            ),
            216 => 
            array (
                'permission_id' => 46,
                'role_id' => 6,
            ),
            217 => 
            array (
                'permission_id' => 46,
                'role_id' => 8,
            ),
            218 => 
            array (
                'permission_id' => 47,
                'role_id' => 1,
            ),
            219 => 
            array (
                'permission_id' => 47,
                'role_id' => 2,
            ),
            220 => 
            array (
                'permission_id' => 47,
                'role_id' => 3,
            ),
            221 => 
            array (
                'permission_id' => 47,
                'role_id' => 5,
            ),
            222 => 
            array (
                'permission_id' => 47,
                'role_id' => 6,
            ),
            223 => 
            array (
                'permission_id' => 47,
                'role_id' => 8,
            ),
            224 => 
            array (
                'permission_id' => 48,
                'role_id' => 1,
            ),
            225 => 
            array (
                'permission_id' => 48,
                'role_id' => 2,
            ),
            226 => 
            array (
                'permission_id' => 48,
                'role_id' => 3,
            ),
            227 => 
            array (
                'permission_id' => 48,
                'role_id' => 5,
            ),
            228 => 
            array (
                'permission_id' => 48,
                'role_id' => 6,
            ),
            229 => 
            array (
                'permission_id' => 48,
                'role_id' => 8,
            ),
            230 => 
            array (
                'permission_id' => 49,
                'role_id' => 1,
            ),
            231 => 
            array (
                'permission_id' => 49,
                'role_id' => 2,
            ),
            232 => 
            array (
                'permission_id' => 49,
                'role_id' => 3,
            ),
            233 => 
            array (
                'permission_id' => 49,
                'role_id' => 5,
            ),
            234 => 
            array (
                'permission_id' => 49,
                'role_id' => 6,
            ),
            235 => 
            array (
                'permission_id' => 49,
                'role_id' => 8,
            ),
            236 => 
            array (
                'permission_id' => 50,
                'role_id' => 1,
            ),
            237 => 
            array (
                'permission_id' => 50,
                'role_id' => 2,
            ),
            238 => 
            array (
                'permission_id' => 50,
                'role_id' => 3,
            ),
            239 => 
            array (
                'permission_id' => 50,
                'role_id' => 5,
            ),
            240 => 
            array (
                'permission_id' => 50,
                'role_id' => 6,
            ),
            241 => 
            array (
                'permission_id' => 50,
                'role_id' => 8,
            ),
            242 => 
            array (
                'permission_id' => 51,
                'role_id' => 1,
            ),
            243 => 
            array (
                'permission_id' => 51,
                'role_id' => 2,
            ),
            244 => 
            array (
                'permission_id' => 51,
                'role_id' => 3,
            ),
            245 => 
            array (
                'permission_id' => 51,
                'role_id' => 5,
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
                'role_id' => 5,
            ),
            252 => 
            array (
                'permission_id' => 52,
                'role_id' => 6,
            ),
            253 => 
            array (
                'permission_id' => 52,
                'role_id' => 8,
            ),
            254 => 
            array (
                'permission_id' => 53,
                'role_id' => 1,
            ),
            255 => 
            array (
                'permission_id' => 53,
                'role_id' => 2,
            ),
            256 => 
            array (
                'permission_id' => 53,
                'role_id' => 3,
            ),
            257 => 
            array (
                'permission_id' => 53,
                'role_id' => 6,
            ),
            258 => 
            array (
                'permission_id' => 53,
                'role_id' => 8,
            ),
            259 => 
            array (
                'permission_id' => 54,
                'role_id' => 1,
            ),
            260 => 
            array (
                'permission_id' => 54,
                'role_id' => 2,
            ),
            261 => 
            array (
                'permission_id' => 54,
                'role_id' => 3,
            ),
            262 => 
            array (
                'permission_id' => 54,
                'role_id' => 5,
            ),
            263 => 
            array (
                'permission_id' => 54,
                'role_id' => 6,
            ),
            264 => 
            array (
                'permission_id' => 54,
                'role_id' => 8,
            ),
            265 => 
            array (
                'permission_id' => 55,
                'role_id' => 1,
            ),
            266 => 
            array (
                'permission_id' => 55,
                'role_id' => 2,
            ),
            267 => 
            array (
                'permission_id' => 55,
                'role_id' => 3,
            ),
            268 => 
            array (
                'permission_id' => 55,
                'role_id' => 5,
            ),
            269 => 
            array (
                'permission_id' => 55,
                'role_id' => 6,
            ),
            270 => 
            array (
                'permission_id' => 55,
                'role_id' => 8,
            ),
            271 => 
            array (
                'permission_id' => 56,
                'role_id' => 1,
            ),
            272 => 
            array (
                'permission_id' => 56,
                'role_id' => 2,
            ),
            273 => 
            array (
                'permission_id' => 56,
                'role_id' => 3,
            ),
            274 => 
            array (
                'permission_id' => 56,
                'role_id' => 5,
            ),
            275 => 
            array (
                'permission_id' => 56,
                'role_id' => 6,
            ),
            276 => 
            array (
                'permission_id' => 56,
                'role_id' => 8,
            ),
            277 => 
            array (
                'permission_id' => 57,
                'role_id' => 1,
            ),
            278 => 
            array (
                'permission_id' => 57,
                'role_id' => 2,
            ),
            279 => 
            array (
                'permission_id' => 57,
                'role_id' => 3,
            ),
            280 => 
            array (
                'permission_id' => 57,
                'role_id' => 6,
            ),
            281 => 
            array (
                'permission_id' => 57,
                'role_id' => 8,
            ),
            282 => 
            array (
                'permission_id' => 58,
                'role_id' => 1,
            ),
            283 => 
            array (
                'permission_id' => 58,
                'role_id' => 2,
            ),
            284 => 
            array (
                'permission_id' => 58,
                'role_id' => 6,
            ),
            285 => 
            array (
                'permission_id' => 58,
                'role_id' => 8,
            ),
            286 => 
            array (
                'permission_id' => 59,
                'role_id' => 1,
            ),
            287 => 
            array (
                'permission_id' => 59,
                'role_id' => 2,
            ),
            288 => 
            array (
                'permission_id' => 59,
                'role_id' => 3,
            ),
            289 => 
            array (
                'permission_id' => 59,
                'role_id' => 8,
            ),
            290 => 
            array (
                'permission_id' => 61,
                'role_id' => 1,
            ),
            291 => 
            array (
                'permission_id' => 61,
                'role_id' => 2,
            ),
            292 => 
            array (
                'permission_id' => 61,
                'role_id' => 3,
            ),
            293 => 
            array (
                'permission_id' => 61,
                'role_id' => 5,
            ),
            294 => 
            array (
                'permission_id' => 61,
                'role_id' => 6,
            ),
            295 => 
            array (
                'permission_id' => 61,
                'role_id' => 8,
            ),
            296 => 
            array (
                'permission_id' => 62,
                'role_id' => 1,
            ),
            297 => 
            array (
                'permission_id' => 62,
                'role_id' => 2,
            ),
            298 => 
            array (
                'permission_id' => 62,
                'role_id' => 3,
            ),
            299 => 
            array (
                'permission_id' => 62,
                'role_id' => 6,
            ),
            300 => 
            array (
                'permission_id' => 62,
                'role_id' => 8,
            ),
            301 => 
            array (
                'permission_id' => 63,
                'role_id' => 1,
            ),
            302 => 
            array (
                'permission_id' => 63,
                'role_id' => 2,
            ),
            303 => 
            array (
                'permission_id' => 63,
                'role_id' => 3,
            ),
            304 => 
            array (
                'permission_id' => 63,
                'role_id' => 5,
            ),
            305 => 
            array (
                'permission_id' => 63,
                'role_id' => 6,
            ),
            306 => 
            array (
                'permission_id' => 63,
                'role_id' => 8,
            ),
            307 => 
            array (
                'permission_id' => 64,
                'role_id' => 1,
            ),
            308 => 
            array (
                'permission_id' => 64,
                'role_id' => 2,
            ),
            309 => 
            array (
                'permission_id' => 64,
                'role_id' => 3,
            ),
            310 => 
            array (
                'permission_id' => 64,
                'role_id' => 6,
            ),
            311 => 
            array (
                'permission_id' => 64,
                'role_id' => 8,
            ),
            312 => 
            array (
                'permission_id' => 65,
                'role_id' => 1,
            ),
            313 => 
            array (
                'permission_id' => 65,
                'role_id' => 2,
            ),
            314 => 
            array (
                'permission_id' => 65,
                'role_id' => 3,
            ),
            315 => 
            array (
                'permission_id' => 65,
                'role_id' => 6,
            ),
            316 => 
            array (
                'permission_id' => 65,
                'role_id' => 8,
            ),
            317 => 
            array (
                'permission_id' => 66,
                'role_id' => 1,
            ),
            318 => 
            array (
                'permission_id' => 66,
                'role_id' => 2,
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
                'role_id' => 5,
            ),
            325 => 
            array (
                'permission_id' => 67,
                'role_id' => 6,
            ),
            326 => 
            array (
                'permission_id' => 67,
                'role_id' => 8,
            ),
            327 => 
            array (
                'permission_id' => 68,
                'role_id' => 1,
            ),
            328 => 
            array (
                'permission_id' => 68,
                'role_id' => 2,
            ),
            329 => 
            array (
                'permission_id' => 68,
                'role_id' => 3,
            ),
            330 => 
            array (
                'permission_id' => 68,
                'role_id' => 6,
            ),
            331 => 
            array (
                'permission_id' => 68,
                'role_id' => 8,
            ),
            332 => 
            array (
                'permission_id' => 69,
                'role_id' => 1,
            ),
            333 => 
            array (
                'permission_id' => 69,
                'role_id' => 2,
            ),
            334 => 
            array (
                'permission_id' => 69,
                'role_id' => 3,
            ),
            335 => 
            array (
                'permission_id' => 69,
                'role_id' => 5,
            ),
            336 => 
            array (
                'permission_id' => 69,
                'role_id' => 6,
            ),
            337 => 
            array (
                'permission_id' => 69,
                'role_id' => 8,
            ),
            338 => 
            array (
                'permission_id' => 70,
                'role_id' => 1,
            ),
            339 => 
            array (
                'permission_id' => 70,
                'role_id' => 2,
            ),
            340 => 
            array (
                'permission_id' => 70,
                'role_id' => 3,
            ),
            341 => 
            array (
                'permission_id' => 70,
                'role_id' => 6,
            ),
            342 => 
            array (
                'permission_id' => 70,
                'role_id' => 8,
            ),
            343 => 
            array (
                'permission_id' => 71,
                'role_id' => 1,
            ),
            344 => 
            array (
                'permission_id' => 71,
                'role_id' => 2,
            ),
            345 => 
            array (
                'permission_id' => 71,
                'role_id' => 3,
            ),
            346 => 
            array (
                'permission_id' => 71,
                'role_id' => 6,
            ),
            347 => 
            array (
                'permission_id' => 71,
                'role_id' => 8,
            ),
            348 => 
            array (
                'permission_id' => 72,
                'role_id' => 1,
            ),
            349 => 
            array (
                'permission_id' => 72,
                'role_id' => 2,
            ),
            350 => 
            array (
                'permission_id' => 72,
                'role_id' => 3,
            ),
            351 => 
            array (
                'permission_id' => 72,
                'role_id' => 6,
            ),
            352 => 
            array (
                'permission_id' => 72,
                'role_id' => 8,
            ),
            353 => 
            array (
                'permission_id' => 73,
                'role_id' => 1,
            ),
            354 => 
            array (
                'permission_id' => 73,
                'role_id' => 2,
            ),
            355 => 
            array (
                'permission_id' => 73,
                'role_id' => 3,
            ),
            356 => 
            array (
                'permission_id' => 73,
                'role_id' => 6,
            ),
            357 => 
            array (
                'permission_id' => 73,
                'role_id' => 8,
            ),
            358 => 
            array (
                'permission_id' => 74,
                'role_id' => 1,
            ),
            359 => 
            array (
                'permission_id' => 74,
                'role_id' => 2,
            ),
            360 => 
            array (
                'permission_id' => 74,
                'role_id' => 3,
            ),
            361 => 
            array (
                'permission_id' => 74,
                'role_id' => 6,
            ),
            362 => 
            array (
                'permission_id' => 74,
                'role_id' => 8,
            ),
            363 => 
            array (
                'permission_id' => 75,
                'role_id' => 1,
            ),
            364 => 
            array (
                'permission_id' => 75,
                'role_id' => 2,
            ),
            365 => 
            array (
                'permission_id' => 75,
                'role_id' => 3,
            ),
            366 => 
            array (
                'permission_id' => 75,
                'role_id' => 6,
            ),
            367 => 
            array (
                'permission_id' => 75,
                'role_id' => 8,
            ),
            368 => 
            array (
                'permission_id' => 76,
                'role_id' => 1,
            ),
            369 => 
            array (
                'permission_id' => 76,
                'role_id' => 2,
            ),
            370 => 
            array (
                'permission_id' => 76,
                'role_id' => 6,
            ),
            371 => 
            array (
                'permission_id' => 76,
                'role_id' => 8,
            ),
            372 => 
            array (
                'permission_id' => 77,
                'role_id' => 1,
            ),
            373 => 
            array (
                'permission_id' => 77,
                'role_id' => 2,
            ),
            374 => 
            array (
                'permission_id' => 77,
                'role_id' => 3,
            ),
            375 => 
            array (
                'permission_id' => 77,
                'role_id' => 6,
            ),
            376 => 
            array (
                'permission_id' => 77,
                'role_id' => 8,
            ),
            377 => 
            array (
                'permission_id' => 78,
                'role_id' => 1,
            ),
            378 => 
            array (
                'permission_id' => 78,
                'role_id' => 2,
            ),
            379 => 
            array (
                'permission_id' => 78,
                'role_id' => 3,
            ),
            380 => 
            array (
                'permission_id' => 78,
                'role_id' => 5,
            ),
            381 => 
            array (
                'permission_id' => 78,
                'role_id' => 6,
            ),
            382 => 
            array (
                'permission_id' => 78,
                'role_id' => 8,
            ),
            383 => 
            array (
                'permission_id' => 79,
                'role_id' => 1,
            ),
            384 => 
            array (
                'permission_id' => 79,
                'role_id' => 2,
            ),
            385 => 
            array (
                'permission_id' => 79,
                'role_id' => 3,
            ),
            386 => 
            array (
                'permission_id' => 79,
                'role_id' => 6,
            ),
            387 => 
            array (
                'permission_id' => 79,
                'role_id' => 8,
            ),
            388 => 
            array (
                'permission_id' => 82,
                'role_id' => 1,
            ),
            389 => 
            array (
                'permission_id' => 82,
                'role_id' => 2,
            ),
            390 => 
            array (
                'permission_id' => 82,
                'role_id' => 3,
            ),
            391 => 
            array (
                'permission_id' => 82,
                'role_id' => 5,
            ),
            392 => 
            array (
                'permission_id' => 82,
                'role_id' => 6,
            ),
            393 => 
            array (
                'permission_id' => 82,
                'role_id' => 8,
            ),
            394 => 
            array (
                'permission_id' => 84,
                'role_id' => 1,
            ),
            395 => 
            array (
                'permission_id' => 84,
                'role_id' => 2,
            ),
            396 => 
            array (
                'permission_id' => 84,
                'role_id' => 3,
            ),
            397 => 
            array (
                'permission_id' => 84,
                'role_id' => 6,
            ),
            398 => 
            array (
                'permission_id' => 84,
                'role_id' => 8,
            ),
            399 => 
            array (
                'permission_id' => 85,
                'role_id' => 1,
            ),
            400 => 
            array (
                'permission_id' => 85,
                'role_id' => 2,
            ),
            401 => 
            array (
                'permission_id' => 85,
                'role_id' => 3,
            ),
            402 => 
            array (
                'permission_id' => 85,
                'role_id' => 6,
            ),
            403 => 
            array (
                'permission_id' => 85,
                'role_id' => 8,
            ),
            404 => 
            array (
                'permission_id' => 86,
                'role_id' => 1,
            ),
            405 => 
            array (
                'permission_id' => 86,
                'role_id' => 2,
            ),
            406 => 
            array (
                'permission_id' => 86,
                'role_id' => 3,
            ),
            407 => 
            array (
                'permission_id' => 86,
                'role_id' => 6,
            ),
            408 => 
            array (
                'permission_id' => 86,
                'role_id' => 8,
            ),
            409 => 
            array (
                'permission_id' => 87,
                'role_id' => 1,
            ),
            410 => 
            array (
                'permission_id' => 87,
                'role_id' => 2,
            ),
            411 => 
            array (
                'permission_id' => 87,
                'role_id' => 3,
            ),
            412 => 
            array (
                'permission_id' => 87,
                'role_id' => 8,
            ),
            413 => 
            array (
                'permission_id' => 88,
                'role_id' => 1,
            ),
            414 => 
            array (
                'permission_id' => 88,
                'role_id' => 2,
            ),
            415 => 
            array (
                'permission_id' => 88,
                'role_id' => 3,
            ),
            416 => 
            array (
                'permission_id' => 88,
                'role_id' => 6,
            ),
            417 => 
            array (
                'permission_id' => 88,
                'role_id' => 8,
            ),
            418 => 
            array (
                'permission_id' => 89,
                'role_id' => 1,
            ),
            419 => 
            array (
                'permission_id' => 89,
                'role_id' => 2,
            ),
            420 => 
            array (
                'permission_id' => 89,
                'role_id' => 3,
            ),
            421 => 
            array (
                'permission_id' => 89,
                'role_id' => 6,
            ),
            422 => 
            array (
                'permission_id' => 89,
                'role_id' => 8,
            ),
            423 => 
            array (
                'permission_id' => 90,
                'role_id' => 1,
            ),
            424 => 
            array (
                'permission_id' => 90,
                'role_id' => 2,
            ),
            425 => 
            array (
                'permission_id' => 90,
                'role_id' => 3,
            ),
            426 => 
            array (
                'permission_id' => 90,
                'role_id' => 5,
            ),
            427 => 
            array (
                'permission_id' => 90,
                'role_id' => 6,
            ),
            428 => 
            array (
                'permission_id' => 90,
                'role_id' => 8,
            ),
            429 => 
            array (
                'permission_id' => 91,
                'role_id' => 1,
            ),
            430 => 
            array (
                'permission_id' => 91,
                'role_id' => 2,
            ),
            431 => 
            array (
                'permission_id' => 91,
                'role_id' => 3,
            ),
            432 => 
            array (
                'permission_id' => 91,
                'role_id' => 5,
            ),
            433 => 
            array (
                'permission_id' => 91,
                'role_id' => 6,
            ),
            434 => 
            array (
                'permission_id' => 91,
                'role_id' => 8,
            ),
            435 => 
            array (
                'permission_id' => 92,
                'role_id' => 1,
            ),
            436 => 
            array (
                'permission_id' => 92,
                'role_id' => 2,
            ),
            437 => 
            array (
                'permission_id' => 92,
                'role_id' => 3,
            ),
            438 => 
            array (
                'permission_id' => 92,
                'role_id' => 6,
            ),
            439 => 
            array (
                'permission_id' => 92,
                'role_id' => 8,
            ),
            440 => 
            array (
                'permission_id' => 93,
                'role_id' => 1,
            ),
            441 => 
            array (
                'permission_id' => 93,
                'role_id' => 2,
            ),
            442 => 
            array (
                'permission_id' => 93,
                'role_id' => 3,
            ),
            443 => 
            array (
                'permission_id' => 93,
                'role_id' => 5,
            ),
            444 => 
            array (
                'permission_id' => 93,
                'role_id' => 6,
            ),
            445 => 
            array (
                'permission_id' => 93,
                'role_id' => 8,
            ),
            446 => 
            array (
                'permission_id' => 94,
                'role_id' => 1,
            ),
            447 => 
            array (
                'permission_id' => 94,
                'role_id' => 2,
            ),
            448 => 
            array (
                'permission_id' => 94,
                'role_id' => 3,
            ),
            449 => 
            array (
                'permission_id' => 94,
                'role_id' => 6,
            ),
            450 => 
            array (
                'permission_id' => 94,
                'role_id' => 8,
            ),
            451 => 
            array (
                'permission_id' => 95,
                'role_id' => 1,
            ),
            452 => 
            array (
                'permission_id' => 95,
                'role_id' => 2,
            ),
            453 => 
            array (
                'permission_id' => 95,
                'role_id' => 3,
            ),
            454 => 
            array (
                'permission_id' => 95,
                'role_id' => 6,
            ),
            455 => 
            array (
                'permission_id' => 95,
                'role_id' => 8,
            ),
            456 => 
            array (
                'permission_id' => 96,
                'role_id' => 1,
            ),
            457 => 
            array (
                'permission_id' => 96,
                'role_id' => 2,
            ),
            458 => 
            array (
                'permission_id' => 96,
                'role_id' => 6,
            ),
            459 => 
            array (
                'permission_id' => 96,
                'role_id' => 8,
            ),
            460 => 
            array (
                'permission_id' => 97,
                'role_id' => 1,
            ),
            461 => 
            array (
                'permission_id' => 97,
                'role_id' => 2,
            ),
            462 => 
            array (
                'permission_id' => 97,
                'role_id' => 3,
            ),
            463 => 
            array (
                'permission_id' => 97,
                'role_id' => 5,
            ),
            464 => 
            array (
                'permission_id' => 97,
                'role_id' => 6,
            ),
            465 => 
            array (
                'permission_id' => 97,
                'role_id' => 8,
            ),
            466 => 
            array (
                'permission_id' => 98,
                'role_id' => 1,
            ),
            467 => 
            array (
                'permission_id' => 98,
                'role_id' => 2,
            ),
            468 => 
            array (
                'permission_id' => 98,
                'role_id' => 3,
            ),
            469 => 
            array (
                'permission_id' => 98,
                'role_id' => 6,
            ),
            470 => 
            array (
                'permission_id' => 98,
                'role_id' => 8,
            ),
            471 => 
            array (
                'permission_id' => 99,
                'role_id' => 1,
            ),
            472 => 
            array (
                'permission_id' => 99,
                'role_id' => 2,
            ),
            473 => 
            array (
                'permission_id' => 99,
                'role_id' => 3,
            ),
            474 => 
            array (
                'permission_id' => 99,
                'role_id' => 6,
            ),
            475 => 
            array (
                'permission_id' => 99,
                'role_id' => 8,
            ),
            476 => 
            array (
                'permission_id' => 100,
                'role_id' => 1,
            ),
            477 => 
            array (
                'permission_id' => 100,
                'role_id' => 2,
            ),
            478 => 
            array (
                'permission_id' => 100,
                'role_id' => 3,
            ),
            479 => 
            array (
                'permission_id' => 100,
                'role_id' => 8,
            ),
            480 => 
            array (
                'permission_id' => 101,
                'role_id' => 1,
            ),
            481 => 
            array (
                'permission_id' => 101,
                'role_id' => 2,
            ),
            482 => 
            array (
                'permission_id' => 101,
                'role_id' => 3,
            ),
            483 => 
            array (
                'permission_id' => 101,
                'role_id' => 5,
            ),
            484 => 
            array (
                'permission_id' => 101,
                'role_id' => 6,
            ),
            485 => 
            array (
                'permission_id' => 101,
                'role_id' => 8,
            ),
            486 => 
            array (
                'permission_id' => 102,
                'role_id' => 1,
            ),
            487 => 
            array (
                'permission_id' => 102,
                'role_id' => 2,
            ),
            488 => 
            array (
                'permission_id' => 102,
                'role_id' => 3,
            ),
            489 => 
            array (
                'permission_id' => 102,
                'role_id' => 6,
            ),
            490 => 
            array (
                'permission_id' => 102,
                'role_id' => 8,
            ),
            491 => 
            array (
                'permission_id' => 106,
                'role_id' => 1,
            ),
            492 => 
            array (
                'permission_id' => 106,
                'role_id' => 2,
            ),
            493 => 
            array (
                'permission_id' => 106,
                'role_id' => 3,
            ),
            494 => 
            array (
                'permission_id' => 106,
                'role_id' => 5,
            ),
            495 => 
            array (
                'permission_id' => 106,
                'role_id' => 6,
            ),
            496 => 
            array (
                'permission_id' => 106,
                'role_id' => 8,
            ),
            497 => 
            array (
                'permission_id' => 107,
                'role_id' => 1,
            ),
            498 => 
            array (
                'permission_id' => 107,
                'role_id' => 2,
            ),
            499 => 
            array (
                'permission_id' => 107,
                'role_id' => 3,
            ),
        ));
        \DB::table('role_has_permissions')->insert(array (
            0 => 
            array (
                'permission_id' => 107,
                'role_id' => 5,
            ),
            1 => 
            array (
                'permission_id' => 107,
                'role_id' => 6,
            ),
            2 => 
            array (
                'permission_id' => 107,
                'role_id' => 8,
            ),
            3 => 
            array (
                'permission_id' => 108,
                'role_id' => 1,
            ),
            4 => 
            array (
                'permission_id' => 108,
                'role_id' => 2,
            ),
            5 => 
            array (
                'permission_id' => 108,
                'role_id' => 3,
            ),
            6 => 
            array (
                'permission_id' => 108,
                'role_id' => 6,
            ),
            7 => 
            array (
                'permission_id' => 108,
                'role_id' => 8,
            ),
            8 => 
            array (
                'permission_id' => 109,
                'role_id' => 1,
            ),
            9 => 
            array (
                'permission_id' => 109,
                'role_id' => 2,
            ),
            10 => 
            array (
                'permission_id' => 109,
                'role_id' => 3,
            ),
            11 => 
            array (
                'permission_id' => 109,
                'role_id' => 6,
            ),
            12 => 
            array (
                'permission_id' => 109,
                'role_id' => 8,
            ),
            13 => 
            array (
                'permission_id' => 110,
                'role_id' => 1,
            ),
            14 => 
            array (
                'permission_id' => 110,
                'role_id' => 2,
            ),
            15 => 
            array (
                'permission_id' => 110,
                'role_id' => 3,
            ),
            16 => 
            array (
                'permission_id' => 110,
                'role_id' => 5,
            ),
            17 => 
            array (
                'permission_id' => 110,
                'role_id' => 6,
            ),
            18 => 
            array (
                'permission_id' => 110,
                'role_id' => 8,
            ),
            19 => 
            array (
                'permission_id' => 111,
                'role_id' => 1,
            ),
            20 => 
            array (
                'permission_id' => 111,
                'role_id' => 2,
            ),
            21 => 
            array (
                'permission_id' => 111,
                'role_id' => 3,
            ),
            22 => 
            array (
                'permission_id' => 111,
                'role_id' => 5,
            ),
            23 => 
            array (
                'permission_id' => 111,
                'role_id' => 6,
            ),
            24 => 
            array (
                'permission_id' => 111,
                'role_id' => 8,
            ),
            25 => 
            array (
                'permission_id' => 112,
                'role_id' => 1,
            ),
            26 => 
            array (
                'permission_id' => 112,
                'role_id' => 2,
            ),
            27 => 
            array (
                'permission_id' => 112,
                'role_id' => 3,
            ),
            28 => 
            array (
                'permission_id' => 112,
                'role_id' => 6,
            ),
            29 => 
            array (
                'permission_id' => 112,
                'role_id' => 8,
            ),
            30 => 
            array (
                'permission_id' => 113,
                'role_id' => 1,
            ),
            31 => 
            array (
                'permission_id' => 113,
                'role_id' => 2,
            ),
            32 => 
            array (
                'permission_id' => 113,
                'role_id' => 3,
            ),
            33 => 
            array (
                'permission_id' => 113,
                'role_id' => 6,
            ),
            34 => 
            array (
                'permission_id' => 113,
                'role_id' => 8,
            ),
            35 => 
            array (
                'permission_id' => 114,
                'role_id' => 1,
            ),
            36 => 
            array (
                'permission_id' => 114,
                'role_id' => 2,
            ),
            37 => 
            array (
                'permission_id' => 114,
                'role_id' => 3,
            ),
            38 => 
            array (
                'permission_id' => 114,
                'role_id' => 6,
            ),
            39 => 
            array (
                'permission_id' => 114,
                'role_id' => 8,
            ),
            40 => 
            array (
                'permission_id' => 115,
                'role_id' => 1,
            ),
            41 => 
            array (
                'permission_id' => 115,
                'role_id' => 2,
            ),
            42 => 
            array (
                'permission_id' => 115,
                'role_id' => 3,
            ),
            43 => 
            array (
                'permission_id' => 115,
                'role_id' => 6,
            ),
            44 => 
            array (
                'permission_id' => 115,
                'role_id' => 8,
            ),
            45 => 
            array (
                'permission_id' => 116,
                'role_id' => 1,
            ),
            46 => 
            array (
                'permission_id' => 116,
                'role_id' => 2,
            ),
            47 => 
            array (
                'permission_id' => 116,
                'role_id' => 6,
            ),
            48 => 
            array (
                'permission_id' => 116,
                'role_id' => 8,
            ),
            49 => 
            array (
                'permission_id' => 117,
                'role_id' => 1,
            ),
            50 => 
            array (
                'permission_id' => 117,
                'role_id' => 2,
            ),
            51 => 
            array (
                'permission_id' => 117,
                'role_id' => 3,
            ),
            52 => 
            array (
                'permission_id' => 117,
                'role_id' => 5,
            ),
            53 => 
            array (
                'permission_id' => 117,
                'role_id' => 6,
            ),
            54 => 
            array (
                'permission_id' => 117,
                'role_id' => 8,
            ),
            55 => 
            array (
                'permission_id' => 118,
                'role_id' => 1,
            ),
            56 => 
            array (
                'permission_id' => 118,
                'role_id' => 2,
            ),
            57 => 
            array (
                'permission_id' => 118,
                'role_id' => 3,
            ),
            58 => 
            array (
                'permission_id' => 118,
                'role_id' => 5,
            ),
            59 => 
            array (
                'permission_id' => 118,
                'role_id' => 6,
            ),
            60 => 
            array (
                'permission_id' => 118,
                'role_id' => 8,
            ),
            61 => 
            array (
                'permission_id' => 119,
                'role_id' => 1,
            ),
            62 => 
            array (
                'permission_id' => 119,
                'role_id' => 2,
            ),
            63 => 
            array (
                'permission_id' => 119,
                'role_id' => 3,
            ),
            64 => 
            array (
                'permission_id' => 119,
                'role_id' => 6,
            ),
            65 => 
            array (
                'permission_id' => 119,
                'role_id' => 8,
            ),
            66 => 
            array (
                'permission_id' => 120,
                'role_id' => 1,
            ),
            67 => 
            array (
                'permission_id' => 120,
                'role_id' => 2,
            ),
            68 => 
            array (
                'permission_id' => 120,
                'role_id' => 6,
            ),
            69 => 
            array (
                'permission_id' => 120,
                'role_id' => 8,
            ),
            70 => 
            array (
                'permission_id' => 121,
                'role_id' => 1,
            ),
            71 => 
            array (
                'permission_id' => 121,
                'role_id' => 2,
            ),
            72 => 
            array (
                'permission_id' => 121,
                'role_id' => 3,
            ),
            73 => 
            array (
                'permission_id' => 121,
                'role_id' => 6,
            ),
            74 => 
            array (
                'permission_id' => 121,
                'role_id' => 8,
            ),
            75 => 
            array (
                'permission_id' => 122,
                'role_id' => 1,
            ),
            76 => 
            array (
                'permission_id' => 122,
                'role_id' => 2,
            ),
            77 => 
            array (
                'permission_id' => 122,
                'role_id' => 3,
            ),
            78 => 
            array (
                'permission_id' => 122,
                'role_id' => 5,
            ),
            79 => 
            array (
                'permission_id' => 122,
                'role_id' => 6,
            ),
            80 => 
            array (
                'permission_id' => 122,
                'role_id' => 8,
            ),
            81 => 
            array (
                'permission_id' => 124,
                'role_id' => 1,
            ),
            82 => 
            array (
                'permission_id' => 124,
                'role_id' => 2,
            ),
            83 => 
            array (
                'permission_id' => 124,
                'role_id' => 3,
            ),
            84 => 
            array (
                'permission_id' => 124,
                'role_id' => 5,
            ),
            85 => 
            array (
                'permission_id' => 124,
                'role_id' => 6,
            ),
            86 => 
            array (
                'permission_id' => 124,
                'role_id' => 8,
            ),
            87 => 
            array (
                'permission_id' => 125,
                'role_id' => 1,
            ),
            88 => 
            array (
                'permission_id' => 125,
                'role_id' => 2,
            ),
            89 => 
            array (
                'permission_id' => 125,
                'role_id' => 3,
            ),
            90 => 
            array (
                'permission_id' => 125,
                'role_id' => 6,
            ),
            91 => 
            array (
                'permission_id' => 125,
                'role_id' => 8,
            ),
            92 => 
            array (
                'permission_id' => 126,
                'role_id' => 1,
            ),
            93 => 
            array (
                'permission_id' => 126,
                'role_id' => 2,
            ),
            94 => 
            array (
                'permission_id' => 126,
                'role_id' => 3,
            ),
            95 => 
            array (
                'permission_id' => 126,
                'role_id' => 6,
            ),
            96 => 
            array (
                'permission_id' => 126,
                'role_id' => 8,
            ),
        ));
        
        
    }
}