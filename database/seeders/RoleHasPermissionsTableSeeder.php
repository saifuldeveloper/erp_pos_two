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
                'permission_id' => 5,
                'role_id' => 1,
            ),
            5 => 
            array (
                'permission_id' => 5,
                'role_id' => 3,
            ),
            6 => 
            array (
                'permission_id' => 5,
                'role_id' => 6,
            ),
            7 => 
            array (
                'permission_id' => 6,
                'role_id' => 1,
            ),
            8 => 
            array (
                'permission_id' => 6,
                'role_id' => 2,
            ),
            9 => 
            array (
                'permission_id' => 6,
                'role_id' => 3,
            ),
            10 => 
            array (
                'permission_id' => 6,
                'role_id' => 6,
            ),
            11 => 
            array (
                'permission_id' => 7,
                'role_id' => 1,
            ),
            12 => 
            array (
                'permission_id' => 7,
                'role_id' => 2,
            ),
            13 => 
            array (
                'permission_id' => 7,
                'role_id' => 3,
            ),
            14 => 
            array (
                'permission_id' => 7,
                'role_id' => 5,
            ),
            15 => 
            array (
                'permission_id' => 7,
                'role_id' => 6,
            ),
            16 => 
            array (
                'permission_id' => 7,
                'role_id' => 8,
            ),
            17 => 
            array (
                'permission_id' => 8,
                'role_id' => 1,
            ),
            18 => 
            array (
                'permission_id' => 8,
                'role_id' => 2,
            ),
            19 => 
            array (
                'permission_id' => 8,
                'role_id' => 3,
            ),
            20 => 
            array (
                'permission_id' => 8,
                'role_id' => 6,
            ),
            21 => 
            array (
                'permission_id' => 8,
                'role_id' => 8,
            ),
            22 => 
            array (
                'permission_id' => 9,
                'role_id' => 1,
            ),
            23 => 
            array (
                'permission_id' => 9,
                'role_id' => 2,
            ),
            24 => 
            array (
                'permission_id' => 9,
                'role_id' => 3,
            ),
            25 => 
            array (
                'permission_id' => 9,
                'role_id' => 6,
            ),
            26 => 
            array (
                'permission_id' => 10,
                'role_id' => 1,
            ),
            27 => 
            array (
                'permission_id' => 10,
                'role_id' => 2,
            ),
            28 => 
            array (
                'permission_id' => 10,
                'role_id' => 3,
            ),
            29 => 
            array (
                'permission_id' => 10,
                'role_id' => 6,
            ),
            30 => 
            array (
                'permission_id' => 11,
                'role_id' => 1,
            ),
            31 => 
            array (
                'permission_id' => 11,
                'role_id' => 3,
            ),
            32 => 
            array (
                'permission_id' => 11,
                'role_id' => 6,
            ),
            33 => 
            array (
                'permission_id' => 12,
                'role_id' => 1,
            ),
            34 => 
            array (
                'permission_id' => 12,
                'role_id' => 2,
            ),
            35 => 
            array (
                'permission_id' => 12,
                'role_id' => 3,
            ),
            36 => 
            array (
                'permission_id' => 12,
                'role_id' => 5,
            ),
            37 => 
            array (
                'permission_id' => 12,
                'role_id' => 6,
            ),
            38 => 
            array (
                'permission_id' => 12,
                'role_id' => 8,
            ),
            39 => 
            array (
                'permission_id' => 13,
                'role_id' => 1,
            ),
            40 => 
            array (
                'permission_id' => 13,
                'role_id' => 2,
            ),
            41 => 
            array (
                'permission_id' => 13,
                'role_id' => 3,
            ),
            42 => 
            array (
                'permission_id' => 13,
                'role_id' => 5,
            ),
            43 => 
            array (
                'permission_id' => 13,
                'role_id' => 6,
            ),
            44 => 
            array (
                'permission_id' => 14,
                'role_id' => 1,
            ),
            45 => 
            array (
                'permission_id' => 14,
                'role_id' => 2,
            ),
            46 => 
            array (
                'permission_id' => 14,
                'role_id' => 3,
            ),
            47 => 
            array (
                'permission_id' => 14,
                'role_id' => 6,
            ),
            48 => 
            array (
                'permission_id' => 15,
                'role_id' => 1,
            ),
            49 => 
            array (
                'permission_id' => 15,
                'role_id' => 3,
            ),
            50 => 
            array (
                'permission_id' => 15,
                'role_id' => 6,
            ),
            51 => 
            array (
                'permission_id' => 16,
                'role_id' => 1,
            ),
            52 => 
            array (
                'permission_id' => 16,
                'role_id' => 2,
            ),
            53 => 
            array (
                'permission_id' => 16,
                'role_id' => 3,
            ),
            54 => 
            array (
                'permission_id' => 16,
                'role_id' => 5,
            ),
            55 => 
            array (
                'permission_id' => 16,
                'role_id' => 6,
            ),
            56 => 
            array (
                'permission_id' => 16,
                'role_id' => 8,
            ),
            57 => 
            array (
                'permission_id' => 17,
                'role_id' => 1,
            ),
            58 => 
            array (
                'permission_id' => 17,
                'role_id' => 2,
            ),
            59 => 
            array (
                'permission_id' => 17,
                'role_id' => 3,
            ),
            60 => 
            array (
                'permission_id' => 17,
                'role_id' => 5,
            ),
            61 => 
            array (
                'permission_id' => 17,
                'role_id' => 6,
            ),
            62 => 
            array (
                'permission_id' => 18,
                'role_id' => 1,
            ),
            63 => 
            array (
                'permission_id' => 18,
                'role_id' => 2,
            ),
            64 => 
            array (
                'permission_id' => 18,
                'role_id' => 3,
            ),
            65 => 
            array (
                'permission_id' => 18,
                'role_id' => 6,
            ),
            66 => 
            array (
                'permission_id' => 19,
                'role_id' => 1,
            ),
            67 => 
            array (
                'permission_id' => 19,
                'role_id' => 3,
            ),
            68 => 
            array (
                'permission_id' => 19,
                'role_id' => 6,
            ),
            69 => 
            array (
                'permission_id' => 20,
                'role_id' => 1,
            ),
            70 => 
            array (
                'permission_id' => 20,
                'role_id' => 2,
            ),
            71 => 
            array (
                'permission_id' => 20,
                'role_id' => 3,
            ),
            72 => 
            array (
                'permission_id' => 20,
                'role_id' => 6,
            ),
            73 => 
            array (
                'permission_id' => 20,
                'role_id' => 8,
            ),
            74 => 
            array (
                'permission_id' => 21,
                'role_id' => 1,
            ),
            75 => 
            array (
                'permission_id' => 21,
                'role_id' => 2,
            ),
            76 => 
            array (
                'permission_id' => 21,
                'role_id' => 3,
            ),
            77 => 
            array (
                'permission_id' => 21,
                'role_id' => 6,
            ),
            78 => 
            array (
                'permission_id' => 22,
                'role_id' => 1,
            ),
            79 => 
            array (
                'permission_id' => 22,
                'role_id' => 2,
            ),
            80 => 
            array (
                'permission_id' => 22,
                'role_id' => 3,
            ),
            81 => 
            array (
                'permission_id' => 22,
                'role_id' => 6,
            ),
            82 => 
            array (
                'permission_id' => 23,
                'role_id' => 1,
            ),
            83 => 
            array (
                'permission_id' => 23,
                'role_id' => 3,
            ),
            84 => 
            array (
                'permission_id' => 23,
                'role_id' => 6,
            ),
            85 => 
            array (
                'permission_id' => 24,
                'role_id' => 1,
            ),
            86 => 
            array (
                'permission_id' => 24,
                'role_id' => 2,
            ),
            87 => 
            array (
                'permission_id' => 24,
                'role_id' => 3,
            ),
            88 => 
            array (
                'permission_id' => 24,
                'role_id' => 5,
            ),
            89 => 
            array (
                'permission_id' => 24,
                'role_id' => 6,
            ),
            90 => 
            array (
                'permission_id' => 24,
                'role_id' => 8,
            ),
            91 => 
            array (
                'permission_id' => 25,
                'role_id' => 1,
            ),
            92 => 
            array (
                'permission_id' => 25,
                'role_id' => 2,
            ),
            93 => 
            array (
                'permission_id' => 25,
                'role_id' => 3,
            ),
            94 => 
            array (
                'permission_id' => 25,
                'role_id' => 6,
            ),
            95 => 
            array (
                'permission_id' => 26,
                'role_id' => 1,
            ),
            96 => 
            array (
                'permission_id' => 26,
                'role_id' => 2,
            ),
            97 => 
            array (
                'permission_id' => 26,
                'role_id' => 3,
            ),
            98 => 
            array (
                'permission_id' => 26,
                'role_id' => 6,
            ),
            99 => 
            array (
                'permission_id' => 27,
                'role_id' => 1,
            ),
            100 => 
            array (
                'permission_id' => 27,
                'role_id' => 3,
            ),
            101 => 
            array (
                'permission_id' => 27,
                'role_id' => 6,
            ),
            102 => 
            array (
                'permission_id' => 28,
                'role_id' => 1,
            ),
            103 => 
            array (
                'permission_id' => 28,
                'role_id' => 2,
            ),
            104 => 
            array (
                'permission_id' => 28,
                'role_id' => 3,
            ),
            105 => 
            array (
                'permission_id' => 28,
                'role_id' => 5,
            ),
            106 => 
            array (
                'permission_id' => 28,
                'role_id' => 6,
            ),
            107 => 
            array (
                'permission_id' => 28,
                'role_id' => 8,
            ),
            108 => 
            array (
                'permission_id' => 29,
                'role_id' => 1,
            ),
            109 => 
            array (
                'permission_id' => 29,
                'role_id' => 2,
            ),
            110 => 
            array (
                'permission_id' => 29,
                'role_id' => 3,
            ),
            111 => 
            array (
                'permission_id' => 29,
                'role_id' => 6,
            ),
            112 => 
            array (
                'permission_id' => 30,
                'role_id' => 1,
            ),
            113 => 
            array (
                'permission_id' => 30,
                'role_id' => 2,
            ),
            114 => 
            array (
                'permission_id' => 30,
                'role_id' => 3,
            ),
            115 => 
            array (
                'permission_id' => 30,
                'role_id' => 6,
            ),
            116 => 
            array (
                'permission_id' => 31,
                'role_id' => 1,
            ),
            117 => 
            array (
                'permission_id' => 31,
                'role_id' => 3,
            ),
            118 => 
            array (
                'permission_id' => 31,
                'role_id' => 6,
            ),
            119 => 
            array (
                'permission_id' => 32,
                'role_id' => 1,
            ),
            120 => 
            array (
                'permission_id' => 32,
                'role_id' => 2,
            ),
            121 => 
            array (
                'permission_id' => 32,
                'role_id' => 3,
            ),
            122 => 
            array (
                'permission_id' => 32,
                'role_id' => 5,
            ),
            123 => 
            array (
                'permission_id' => 32,
                'role_id' => 6,
            ),
            124 => 
            array (
                'permission_id' => 32,
                'role_id' => 8,
            ),
            125 => 
            array (
                'permission_id' => 33,
                'role_id' => 1,
            ),
            126 => 
            array (
                'permission_id' => 33,
                'role_id' => 2,
            ),
            127 => 
            array (
                'permission_id' => 33,
                'role_id' => 3,
            ),
            128 => 
            array (
                'permission_id' => 33,
                'role_id' => 6,
            ),
            129 => 
            array (
                'permission_id' => 34,
                'role_id' => 1,
            ),
            130 => 
            array (
                'permission_id' => 34,
                'role_id' => 2,
            ),
            131 => 
            array (
                'permission_id' => 34,
                'role_id' => 3,
            ),
            132 => 
            array (
                'permission_id' => 34,
                'role_id' => 6,
            ),
            133 => 
            array (
                'permission_id' => 35,
                'role_id' => 1,
            ),
            134 => 
            array (
                'permission_id' => 35,
                'role_id' => 3,
            ),
            135 => 
            array (
                'permission_id' => 35,
                'role_id' => 6,
            ),
            136 => 
            array (
                'permission_id' => 36,
                'role_id' => 1,
            ),
            137 => 
            array (
                'permission_id' => 36,
                'role_id' => 2,
            ),
            138 => 
            array (
                'permission_id' => 36,
                'role_id' => 3,
            ),
            139 => 
            array (
                'permission_id' => 36,
                'role_id' => 6,
            ),
            140 => 
            array (
                'permission_id' => 37,
                'role_id' => 1,
            ),
            141 => 
            array (
                'permission_id' => 37,
                'role_id' => 2,
            ),
            142 => 
            array (
                'permission_id' => 37,
                'role_id' => 3,
            ),
            143 => 
            array (
                'permission_id' => 37,
                'role_id' => 6,
            ),
            144 => 
            array (
                'permission_id' => 38,
                'role_id' => 1,
            ),
            145 => 
            array (
                'permission_id' => 38,
                'role_id' => 2,
            ),
            146 => 
            array (
                'permission_id' => 38,
                'role_id' => 3,
            ),
            147 => 
            array (
                'permission_id' => 38,
                'role_id' => 6,
            ),
            148 => 
            array (
                'permission_id' => 39,
                'role_id' => 1,
            ),
            149 => 
            array (
                'permission_id' => 39,
                'role_id' => 2,
            ),
            150 => 
            array (
                'permission_id' => 39,
                'role_id' => 3,
            ),
            151 => 
            array (
                'permission_id' => 39,
                'role_id' => 6,
            ),
            152 => 
            array (
                'permission_id' => 40,
                'role_id' => 1,
            ),
            153 => 
            array (
                'permission_id' => 40,
                'role_id' => 2,
            ),
            154 => 
            array (
                'permission_id' => 40,
                'role_id' => 3,
            ),
            155 => 
            array (
                'permission_id' => 40,
                'role_id' => 6,
            ),
            156 => 
            array (
                'permission_id' => 41,
                'role_id' => 1,
            ),
            157 => 
            array (
                'permission_id' => 41,
                'role_id' => 2,
            ),
            158 => 
            array (
                'permission_id' => 41,
                'role_id' => 3,
            ),
            159 => 
            array (
                'permission_id' => 41,
                'role_id' => 6,
            ),
            160 => 
            array (
                'permission_id' => 41,
                'role_id' => 8,
            ),
            161 => 
            array (
                'permission_id' => 42,
                'role_id' => 1,
            ),
            162 => 
            array (
                'permission_id' => 42,
                'role_id' => 2,
            ),
            163 => 
            array (
                'permission_id' => 42,
                'role_id' => 3,
            ),
            164 => 
            array (
                'permission_id' => 42,
                'role_id' => 6,
            ),
            165 => 
            array (
                'permission_id' => 43,
                'role_id' => 1,
            ),
            166 => 
            array (
                'permission_id' => 43,
                'role_id' => 2,
            ),
            167 => 
            array (
                'permission_id' => 43,
                'role_id' => 3,
            ),
            168 => 
            array (
                'permission_id' => 43,
                'role_id' => 6,
            ),
            169 => 
            array (
                'permission_id' => 44,
                'role_id' => 1,
            ),
            170 => 
            array (
                'permission_id' => 44,
                'role_id' => 3,
            ),
            171 => 
            array (
                'permission_id' => 44,
                'role_id' => 6,
            ),
            172 => 
            array (
                'permission_id' => 45,
                'role_id' => 1,
            ),
            173 => 
            array (
                'permission_id' => 45,
                'role_id' => 2,
            ),
            174 => 
            array (
                'permission_id' => 45,
                'role_id' => 3,
            ),
            175 => 
            array (
                'permission_id' => 45,
                'role_id' => 6,
            ),
            176 => 
            array (
                'permission_id' => 46,
                'role_id' => 1,
            ),
            177 => 
            array (
                'permission_id' => 46,
                'role_id' => 2,
            ),
            178 => 
            array (
                'permission_id' => 46,
                'role_id' => 3,
            ),
            179 => 
            array (
                'permission_id' => 46,
                'role_id' => 6,
            ),
            180 => 
            array (
                'permission_id' => 47,
                'role_id' => 1,
            ),
            181 => 
            array (
                'permission_id' => 47,
                'role_id' => 2,
            ),
            182 => 
            array (
                'permission_id' => 47,
                'role_id' => 3,
            ),
            183 => 
            array (
                'permission_id' => 47,
                'role_id' => 6,
            ),
            184 => 
            array (
                'permission_id' => 48,
                'role_id' => 1,
            ),
            185 => 
            array (
                'permission_id' => 48,
                'role_id' => 2,
            ),
            186 => 
            array (
                'permission_id' => 48,
                'role_id' => 3,
            ),
            187 => 
            array (
                'permission_id' => 48,
                'role_id' => 6,
            ),
            188 => 
            array (
                'permission_id' => 49,
                'role_id' => 1,
            ),
            189 => 
            array (
                'permission_id' => 49,
                'role_id' => 2,
            ),
            190 => 
            array (
                'permission_id' => 49,
                'role_id' => 3,
            ),
            191 => 
            array (
                'permission_id' => 49,
                'role_id' => 6,
            ),
            192 => 
            array (
                'permission_id' => 50,
                'role_id' => 1,
            ),
            193 => 
            array (
                'permission_id' => 50,
                'role_id' => 2,
            ),
            194 => 
            array (
                'permission_id' => 50,
                'role_id' => 3,
            ),
            195 => 
            array (
                'permission_id' => 50,
                'role_id' => 6,
            ),
            196 => 
            array (
                'permission_id' => 51,
                'role_id' => 1,
            ),
            197 => 
            array (
                'permission_id' => 51,
                'role_id' => 2,
            ),
            198 => 
            array (
                'permission_id' => 51,
                'role_id' => 3,
            ),
            199 => 
            array (
                'permission_id' => 51,
                'role_id' => 6,
            ),
            200 => 
            array (
                'permission_id' => 52,
                'role_id' => 1,
            ),
            201 => 
            array (
                'permission_id' => 52,
                'role_id' => 2,
            ),
            202 => 
            array (
                'permission_id' => 52,
                'role_id' => 3,
            ),
            203 => 
            array (
                'permission_id' => 52,
                'role_id' => 6,
            ),
            204 => 
            array (
                'permission_id' => 53,
                'role_id' => 1,
            ),
            205 => 
            array (
                'permission_id' => 53,
                'role_id' => 2,
            ),
            206 => 
            array (
                'permission_id' => 53,
                'role_id' => 3,
            ),
            207 => 
            array (
                'permission_id' => 53,
                'role_id' => 6,
            ),
            208 => 
            array (
                'permission_id' => 54,
                'role_id' => 1,
            ),
            209 => 
            array (
                'permission_id' => 54,
                'role_id' => 2,
            ),
            210 => 
            array (
                'permission_id' => 54,
                'role_id' => 3,
            ),
            211 => 
            array (
                'permission_id' => 54,
                'role_id' => 6,
            ),
            212 => 
            array (
                'permission_id' => 55,
                'role_id' => 1,
            ),
            213 => 
            array (
                'permission_id' => 55,
                'role_id' => 2,
            ),
            214 => 
            array (
                'permission_id' => 55,
                'role_id' => 3,
            ),
            215 => 
            array (
                'permission_id' => 55,
                'role_id' => 5,
            ),
            216 => 
            array (
                'permission_id' => 55,
                'role_id' => 6,
            ),
            217 => 
            array (
                'permission_id' => 55,
                'role_id' => 8,
            ),
            218 => 
            array (
                'permission_id' => 56,
                'role_id' => 1,
            ),
            219 => 
            array (
                'permission_id' => 56,
                'role_id' => 2,
            ),
            220 => 
            array (
                'permission_id' => 56,
                'role_id' => 3,
            ),
            221 => 
            array (
                'permission_id' => 56,
                'role_id' => 5,
            ),
            222 => 
            array (
                'permission_id' => 56,
                'role_id' => 6,
            ),
            223 => 
            array (
                'permission_id' => 57,
                'role_id' => 1,
            ),
            224 => 
            array (
                'permission_id' => 57,
                'role_id' => 2,
            ),
            225 => 
            array (
                'permission_id' => 57,
                'role_id' => 3,
            ),
            226 => 
            array (
                'permission_id' => 57,
                'role_id' => 6,
            ),
            227 => 
            array (
                'permission_id' => 58,
                'role_id' => 1,
            ),
            228 => 
            array (
                'permission_id' => 58,
                'role_id' => 3,
            ),
            229 => 
            array (
                'permission_id' => 58,
                'role_id' => 6,
            ),
            230 => 
            array (
                'permission_id' => 59,
                'role_id' => 1,
            ),
            231 => 
            array (
                'permission_id' => 59,
                'role_id' => 2,
            ),
            232 => 
            array (
                'permission_id' => 59,
                'role_id' => 3,
            ),
            233 => 
            array (
                'permission_id' => 61,
                'role_id' => 1,
            ),
            234 => 
            array (
                'permission_id' => 61,
                'role_id' => 2,
            ),
            235 => 
            array (
                'permission_id' => 61,
                'role_id' => 3,
            ),
            236 => 
            array (
                'permission_id' => 61,
                'role_id' => 5,
            ),
            237 => 
            array (
                'permission_id' => 61,
                'role_id' => 6,
            ),
            238 => 
            array (
                'permission_id' => 62,
                'role_id' => 1,
            ),
            239 => 
            array (
                'permission_id' => 62,
                'role_id' => 2,
            ),
            240 => 
            array (
                'permission_id' => 62,
                'role_id' => 3,
            ),
            241 => 
            array (
                'permission_id' => 62,
                'role_id' => 6,
            ),
            242 => 
            array (
                'permission_id' => 63,
                'role_id' => 1,
            ),
            243 => 
            array (
                'permission_id' => 63,
                'role_id' => 2,
            ),
            244 => 
            array (
                'permission_id' => 63,
                'role_id' => 3,
            ),
            245 => 
            array (
                'permission_id' => 63,
                'role_id' => 5,
            ),
            246 => 
            array (
                'permission_id' => 63,
                'role_id' => 6,
            ),
            247 => 
            array (
                'permission_id' => 63,
                'role_id' => 8,
            ),
            248 => 
            array (
                'permission_id' => 64,
                'role_id' => 1,
            ),
            249 => 
            array (
                'permission_id' => 64,
                'role_id' => 2,
            ),
            250 => 
            array (
                'permission_id' => 64,
                'role_id' => 3,
            ),
            251 => 
            array (
                'permission_id' => 64,
                'role_id' => 6,
            ),
            252 => 
            array (
                'permission_id' => 65,
                'role_id' => 1,
            ),
            253 => 
            array (
                'permission_id' => 65,
                'role_id' => 2,
            ),
            254 => 
            array (
                'permission_id' => 65,
                'role_id' => 3,
            ),
            255 => 
            array (
                'permission_id' => 65,
                'role_id' => 6,
            ),
            256 => 
            array (
                'permission_id' => 66,
                'role_id' => 1,
            ),
            257 => 
            array (
                'permission_id' => 66,
                'role_id' => 3,
            ),
            258 => 
            array (
                'permission_id' => 66,
                'role_id' => 6,
            ),
            259 => 
            array (
                'permission_id' => 67,
                'role_id' => 1,
            ),
            260 => 
            array (
                'permission_id' => 67,
                'role_id' => 2,
            ),
            261 => 
            array (
                'permission_id' => 67,
                'role_id' => 3,
            ),
            262 => 
            array (
                'permission_id' => 67,
                'role_id' => 6,
            ),
            263 => 
            array (
                'permission_id' => 68,
                'role_id' => 1,
            ),
            264 => 
            array (
                'permission_id' => 68,
                'role_id' => 2,
            ),
            265 => 
            array (
                'permission_id' => 68,
                'role_id' => 3,
            ),
            266 => 
            array (
                'permission_id' => 68,
                'role_id' => 6,
            ),
            267 => 
            array (
                'permission_id' => 69,
                'role_id' => 1,
            ),
            268 => 
            array (
                'permission_id' => 69,
                'role_id' => 2,
            ),
            269 => 
            array (
                'permission_id' => 69,
                'role_id' => 3,
            ),
            270 => 
            array (
                'permission_id' => 69,
                'role_id' => 6,
            ),
            271 => 
            array (
                'permission_id' => 70,
                'role_id' => 1,
            ),
            272 => 
            array (
                'permission_id' => 70,
                'role_id' => 2,
            ),
            273 => 
            array (
                'permission_id' => 70,
                'role_id' => 3,
            ),
            274 => 
            array (
                'permission_id' => 70,
                'role_id' => 6,
            ),
            275 => 
            array (
                'permission_id' => 71,
                'role_id' => 1,
            ),
            276 => 
            array (
                'permission_id' => 71,
                'role_id' => 2,
            ),
            277 => 
            array (
                'permission_id' => 71,
                'role_id' => 3,
            ),
            278 => 
            array (
                'permission_id' => 71,
                'role_id' => 6,
            ),
            279 => 
            array (
                'permission_id' => 72,
                'role_id' => 1,
            ),
            280 => 
            array (
                'permission_id' => 72,
                'role_id' => 2,
            ),
            281 => 
            array (
                'permission_id' => 72,
                'role_id' => 3,
            ),
            282 => 
            array (
                'permission_id' => 72,
                'role_id' => 6,
            ),
            283 => 
            array (
                'permission_id' => 73,
                'role_id' => 1,
            ),
            284 => 
            array (
                'permission_id' => 73,
                'role_id' => 2,
            ),
            285 => 
            array (
                'permission_id' => 73,
                'role_id' => 3,
            ),
            286 => 
            array (
                'permission_id' => 73,
                'role_id' => 6,
            ),
            287 => 
            array (
                'permission_id' => 73,
                'role_id' => 8,
            ),
            288 => 
            array (
                'permission_id' => 74,
                'role_id' => 1,
            ),
            289 => 
            array (
                'permission_id' => 74,
                'role_id' => 2,
            ),
            290 => 
            array (
                'permission_id' => 74,
                'role_id' => 3,
            ),
            291 => 
            array (
                'permission_id' => 74,
                'role_id' => 6,
            ),
            292 => 
            array (
                'permission_id' => 75,
                'role_id' => 1,
            ),
            293 => 
            array (
                'permission_id' => 75,
                'role_id' => 2,
            ),
            294 => 
            array (
                'permission_id' => 75,
                'role_id' => 3,
            ),
            295 => 
            array (
                'permission_id' => 75,
                'role_id' => 6,
            ),
            296 => 
            array (
                'permission_id' => 76,
                'role_id' => 1,
            ),
            297 => 
            array (
                'permission_id' => 76,
                'role_id' => 3,
            ),
            298 => 
            array (
                'permission_id' => 76,
                'role_id' => 6,
            ),
            299 => 
            array (
                'permission_id' => 77,
                'role_id' => 1,
            ),
            300 => 
            array (
                'permission_id' => 77,
                'role_id' => 2,
            ),
            301 => 
            array (
                'permission_id' => 77,
                'role_id' => 3,
            ),
            302 => 
            array (
                'permission_id' => 77,
                'role_id' => 6,
            ),
            303 => 
            array (
                'permission_id' => 78,
                'role_id' => 1,
            ),
            304 => 
            array (
                'permission_id' => 78,
                'role_id' => 2,
            ),
            305 => 
            array (
                'permission_id' => 78,
                'role_id' => 3,
            ),
            306 => 
            array (
                'permission_id' => 78,
                'role_id' => 6,
            ),
            307 => 
            array (
                'permission_id' => 79,
                'role_id' => 1,
            ),
            308 => 
            array (
                'permission_id' => 79,
                'role_id' => 2,
            ),
            309 => 
            array (
                'permission_id' => 79,
                'role_id' => 3,
            ),
            310 => 
            array (
                'permission_id' => 79,
                'role_id' => 6,
            ),
            311 => 
            array (
                'permission_id' => 82,
                'role_id' => 1,
            ),
            312 => 
            array (
                'permission_id' => 82,
                'role_id' => 2,
            ),
            313 => 
            array (
                'permission_id' => 82,
                'role_id' => 3,
            ),
            314 => 
            array (
                'permission_id' => 82,
                'role_id' => 5,
            ),
            315 => 
            array (
                'permission_id' => 82,
                'role_id' => 6,
            ),
            316 => 
            array (
                'permission_id' => 84,
                'role_id' => 1,
            ),
            317 => 
            array (
                'permission_id' => 84,
                'role_id' => 2,
            ),
            318 => 
            array (
                'permission_id' => 84,
                'role_id' => 3,
            ),
            319 => 
            array (
                'permission_id' => 84,
                'role_id' => 6,
            ),
            320 => 
            array (
                'permission_id' => 85,
                'role_id' => 1,
            ),
            321 => 
            array (
                'permission_id' => 85,
                'role_id' => 2,
            ),
            322 => 
            array (
                'permission_id' => 85,
                'role_id' => 3,
            ),
            323 => 
            array (
                'permission_id' => 85,
                'role_id' => 6,
            ),
            324 => 
            array (
                'permission_id' => 86,
                'role_id' => 1,
            ),
            325 => 
            array (
                'permission_id' => 86,
                'role_id' => 2,
            ),
            326 => 
            array (
                'permission_id' => 86,
                'role_id' => 3,
            ),
            327 => 
            array (
                'permission_id' => 86,
                'role_id' => 6,
            ),
            328 => 
            array (
                'permission_id' => 87,
                'role_id' => 1,
            ),
            329 => 
            array (
                'permission_id' => 87,
                'role_id' => 2,
            ),
            330 => 
            array (
                'permission_id' => 87,
                'role_id' => 3,
            ),
            331 => 
            array (
                'permission_id' => 88,
                'role_id' => 1,
            ),
            332 => 
            array (
                'permission_id' => 88,
                'role_id' => 2,
            ),
            333 => 
            array (
                'permission_id' => 88,
                'role_id' => 3,
            ),
            334 => 
            array (
                'permission_id' => 88,
                'role_id' => 6,
            ),
            335 => 
            array (
                'permission_id' => 89,
                'role_id' => 1,
            ),
            336 => 
            array (
                'permission_id' => 89,
                'role_id' => 2,
            ),
            337 => 
            array (
                'permission_id' => 89,
                'role_id' => 3,
            ),
            338 => 
            array (
                'permission_id' => 89,
                'role_id' => 6,
            ),
            339 => 
            array (
                'permission_id' => 90,
                'role_id' => 1,
            ),
            340 => 
            array (
                'permission_id' => 90,
                'role_id' => 2,
            ),
            341 => 
            array (
                'permission_id' => 90,
                'role_id' => 3,
            ),
            342 => 
            array (
                'permission_id' => 90,
                'role_id' => 6,
            ),
            343 => 
            array (
                'permission_id' => 91,
                'role_id' => 1,
            ),
            344 => 
            array (
                'permission_id' => 91,
                'role_id' => 2,
            ),
            345 => 
            array (
                'permission_id' => 91,
                'role_id' => 3,
            ),
            346 => 
            array (
                'permission_id' => 91,
                'role_id' => 6,
            ),
            347 => 
            array (
                'permission_id' => 92,
                'role_id' => 1,
            ),
            348 => 
            array (
                'permission_id' => 92,
                'role_id' => 2,
            ),
            349 => 
            array (
                'permission_id' => 92,
                'role_id' => 3,
            ),
            350 => 
            array (
                'permission_id' => 92,
                'role_id' => 6,
            ),
            351 => 
            array (
                'permission_id' => 93,
                'role_id' => 1,
            ),
            352 => 
            array (
                'permission_id' => 93,
                'role_id' => 2,
            ),
            353 => 
            array (
                'permission_id' => 93,
                'role_id' => 3,
            ),
            354 => 
            array (
                'permission_id' => 93,
                'role_id' => 5,
            ),
            355 => 
            array (
                'permission_id' => 93,
                'role_id' => 6,
            ),
            356 => 
            array (
                'permission_id' => 93,
                'role_id' => 8,
            ),
            357 => 
            array (
                'permission_id' => 94,
                'role_id' => 1,
            ),
            358 => 
            array (
                'permission_id' => 94,
                'role_id' => 2,
            ),
            359 => 
            array (
                'permission_id' => 94,
                'role_id' => 3,
            ),
            360 => 
            array (
                'permission_id' => 94,
                'role_id' => 6,
            ),
            361 => 
            array (
                'permission_id' => 95,
                'role_id' => 1,
            ),
            362 => 
            array (
                'permission_id' => 95,
                'role_id' => 2,
            ),
            363 => 
            array (
                'permission_id' => 95,
                'role_id' => 3,
            ),
            364 => 
            array (
                'permission_id' => 95,
                'role_id' => 6,
            ),
            365 => 
            array (
                'permission_id' => 96,
                'role_id' => 1,
            ),
            366 => 
            array (
                'permission_id' => 96,
                'role_id' => 3,
            ),
            367 => 
            array (
                'permission_id' => 96,
                'role_id' => 6,
            ),
            368 => 
            array (
                'permission_id' => 97,
                'role_id' => 1,
            ),
            369 => 
            array (
                'permission_id' => 97,
                'role_id' => 2,
            ),
            370 => 
            array (
                'permission_id' => 97,
                'role_id' => 3,
            ),
            371 => 
            array (
                'permission_id' => 97,
                'role_id' => 6,
            ),
            372 => 
            array (
                'permission_id' => 98,
                'role_id' => 1,
            ),
            373 => 
            array (
                'permission_id' => 98,
                'role_id' => 2,
            ),
            374 => 
            array (
                'permission_id' => 98,
                'role_id' => 3,
            ),
            375 => 
            array (
                'permission_id' => 98,
                'role_id' => 6,
            ),
            376 => 
            array (
                'permission_id' => 99,
                'role_id' => 1,
            ),
            377 => 
            array (
                'permission_id' => 99,
                'role_id' => 2,
            ),
            378 => 
            array (
                'permission_id' => 99,
                'role_id' => 3,
            ),
            379 => 
            array (
                'permission_id' => 99,
                'role_id' => 6,
            ),
            380 => 
            array (
                'permission_id' => 100,
                'role_id' => 1,
            ),
            381 => 
            array (
                'permission_id' => 100,
                'role_id' => 2,
            ),
            382 => 
            array (
                'permission_id' => 100,
                'role_id' => 3,
            ),
            383 => 
            array (
                'permission_id' => 101,
                'role_id' => 1,
            ),
            384 => 
            array (
                'permission_id' => 101,
                'role_id' => 2,
            ),
            385 => 
            array (
                'permission_id' => 101,
                'role_id' => 3,
            ),
            386 => 
            array (
                'permission_id' => 101,
                'role_id' => 6,
            ),
            387 => 
            array (
                'permission_id' => 102,
                'role_id' => 1,
            ),
            388 => 
            array (
                'permission_id' => 102,
                'role_id' => 2,
            ),
            389 => 
            array (
                'permission_id' => 102,
                'role_id' => 3,
            ),
            390 => 
            array (
                'permission_id' => 102,
                'role_id' => 6,
            ),
            391 => 
            array (
                'permission_id' => 106,
                'role_id' => 1,
            ),
            392 => 
            array (
                'permission_id' => 106,
                'role_id' => 2,
            ),
            393 => 
            array (
                'permission_id' => 106,
                'role_id' => 3,
            ),
            394 => 
            array (
                'permission_id' => 106,
                'role_id' => 5,
            ),
            395 => 
            array (
                'permission_id' => 106,
                'role_id' => 6,
            ),
            396 => 
            array (
                'permission_id' => 107,
                'role_id' => 1,
            ),
            397 => 
            array (
                'permission_id' => 107,
                'role_id' => 2,
            ),
            398 => 
            array (
                'permission_id' => 107,
                'role_id' => 3,
            ),
            399 => 
            array (
                'permission_id' => 107,
                'role_id' => 6,
            ),
            400 => 
            array (
                'permission_id' => 108,
                'role_id' => 1,
            ),
            401 => 
            array (
                'permission_id' => 108,
                'role_id' => 2,
            ),
            402 => 
            array (
                'permission_id' => 108,
                'role_id' => 3,
            ),
            403 => 
            array (
                'permission_id' => 108,
                'role_id' => 6,
            ),
            404 => 
            array (
                'permission_id' => 109,
                'role_id' => 1,
            ),
            405 => 
            array (
                'permission_id' => 109,
                'role_id' => 2,
            ),
            406 => 
            array (
                'permission_id' => 109,
                'role_id' => 3,
            ),
            407 => 
            array (
                'permission_id' => 109,
                'role_id' => 6,
            ),
            408 => 
            array (
                'permission_id' => 110,
                'role_id' => 1,
            ),
            409 => 
            array (
                'permission_id' => 110,
                'role_id' => 2,
            ),
            410 => 
            array (
                'permission_id' => 110,
                'role_id' => 3,
            ),
            411 => 
            array (
                'permission_id' => 110,
                'role_id' => 6,
            ),
            412 => 
            array (
                'permission_id' => 111,
                'role_id' => 1,
            ),
            413 => 
            array (
                'permission_id' => 111,
                'role_id' => 2,
            ),
            414 => 
            array (
                'permission_id' => 111,
                'role_id' => 3,
            ),
            415 => 
            array (
                'permission_id' => 111,
                'role_id' => 6,
            ),
            416 => 
            array (
                'permission_id' => 112,
                'role_id' => 1,
            ),
            417 => 
            array (
                'permission_id' => 112,
                'role_id' => 2,
            ),
            418 => 
            array (
                'permission_id' => 112,
                'role_id' => 3,
            ),
            419 => 
            array (
                'permission_id' => 112,
                'role_id' => 6,
            ),
            420 => 
            array (
                'permission_id' => 113,
                'role_id' => 1,
            ),
            421 => 
            array (
                'permission_id' => 113,
                'role_id' => 2,
            ),
            422 => 
            array (
                'permission_id' => 113,
                'role_id' => 3,
            ),
            423 => 
            array (
                'permission_id' => 113,
                'role_id' => 6,
            ),
            424 => 
            array (
                'permission_id' => 113,
                'role_id' => 8,
            ),
            425 => 
            array (
                'permission_id' => 114,
                'role_id' => 1,
            ),
            426 => 
            array (
                'permission_id' => 114,
                'role_id' => 2,
            ),
            427 => 
            array (
                'permission_id' => 114,
                'role_id' => 3,
            ),
            428 => 
            array (
                'permission_id' => 114,
                'role_id' => 6,
            ),
            429 => 
            array (
                'permission_id' => 115,
                'role_id' => 1,
            ),
            430 => 
            array (
                'permission_id' => 115,
                'role_id' => 2,
            ),
            431 => 
            array (
                'permission_id' => 115,
                'role_id' => 3,
            ),
            432 => 
            array (
                'permission_id' => 115,
                'role_id' => 6,
            ),
            433 => 
            array (
                'permission_id' => 116,
                'role_id' => 1,
            ),
            434 => 
            array (
                'permission_id' => 116,
                'role_id' => 3,
            ),
            435 => 
            array (
                'permission_id' => 116,
                'role_id' => 6,
            ),
            436 => 
            array (
                'permission_id' => 117,
                'role_id' => 1,
            ),
            437 => 
            array (
                'permission_id' => 117,
                'role_id' => 2,
            ),
            438 => 
            array (
                'permission_id' => 117,
                'role_id' => 3,
            ),
            439 => 
            array (
                'permission_id' => 117,
                'role_id' => 5,
            ),
            440 => 
            array (
                'permission_id' => 117,
                'role_id' => 6,
            ),
            441 => 
            array (
                'permission_id' => 117,
                'role_id' => 8,
            ),
            442 => 
            array (
                'permission_id' => 118,
                'role_id' => 1,
            ),
            443 => 
            array (
                'permission_id' => 118,
                'role_id' => 2,
            ),
            444 => 
            array (
                'permission_id' => 118,
                'role_id' => 3,
            ),
            445 => 
            array (
                'permission_id' => 118,
                'role_id' => 5,
            ),
            446 => 
            array (
                'permission_id' => 118,
                'role_id' => 6,
            ),
            447 => 
            array (
                'permission_id' => 119,
                'role_id' => 1,
            ),
            448 => 
            array (
                'permission_id' => 119,
                'role_id' => 2,
            ),
            449 => 
            array (
                'permission_id' => 119,
                'role_id' => 3,
            ),
            450 => 
            array (
                'permission_id' => 119,
                'role_id' => 6,
            ),
            451 => 
            array (
                'permission_id' => 120,
                'role_id' => 1,
            ),
            452 => 
            array (
                'permission_id' => 120,
                'role_id' => 3,
            ),
            453 => 
            array (
                'permission_id' => 120,
                'role_id' => 6,
            ),
            454 => 
            array (
                'permission_id' => 121,
                'role_id' => 1,
            ),
            455 => 
            array (
                'permission_id' => 121,
                'role_id' => 2,
            ),
            456 => 
            array (
                'permission_id' => 121,
                'role_id' => 3,
            ),
            457 => 
            array (
                'permission_id' => 121,
                'role_id' => 6,
            ),
            458 => 
            array (
                'permission_id' => 122,
                'role_id' => 1,
            ),
            459 => 
            array (
                'permission_id' => 122,
                'role_id' => 2,
            ),
            460 => 
            array (
                'permission_id' => 122,
                'role_id' => 3,
            ),
            461 => 
            array (
                'permission_id' => 122,
                'role_id' => 6,
            ),
            462 => 
            array (
                'permission_id' => 124,
                'role_id' => 1,
            ),
            463 => 
            array (
                'permission_id' => 124,
                'role_id' => 2,
            ),
            464 => 
            array (
                'permission_id' => 124,
                'role_id' => 3,
            ),
            465 => 
            array (
                'permission_id' => 124,
                'role_id' => 5,
            ),
            466 => 
            array (
                'permission_id' => 124,
                'role_id' => 6,
            ),
            467 => 
            array (
                'permission_id' => 125,
                'role_id' => 1,
            ),
            468 => 
            array (
                'permission_id' => 125,
                'role_id' => 2,
            ),
            469 => 
            array (
                'permission_id' => 125,
                'role_id' => 3,
            ),
            470 => 
            array (
                'permission_id' => 125,
                'role_id' => 6,
            ),
            471 => 
            array (
                'permission_id' => 126,
                'role_id' => 1,
            ),
            472 => 
            array (
                'permission_id' => 126,
                'role_id' => 2,
            ),
            473 => 
            array (
                'permission_id' => 126,
                'role_id' => 3,
            ),
            474 => 
            array (
                'permission_id' => 126,
                'role_id' => 6,
            ),
        ));
        
        
    }
}