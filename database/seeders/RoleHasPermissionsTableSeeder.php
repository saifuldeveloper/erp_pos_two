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
                'role_id' => 2,
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
                'role_id' => 4,
            ),
            15 => 
            array (
                'permission_id' => 7,
                'role_id' => 6,
            ),
            16 => 
            array (
                'permission_id' => 8,
                'role_id' => 1,
            ),
            17 => 
            array (
                'permission_id' => 8,
                'role_id' => 2,
            ),
            18 => 
            array (
                'permission_id' => 8,
                'role_id' => 3,
            ),
            19 => 
            array (
                'permission_id' => 8,
                'role_id' => 6,
            ),
            20 => 
            array (
                'permission_id' => 9,
                'role_id' => 1,
            ),
            21 => 
            array (
                'permission_id' => 9,
                'role_id' => 2,
            ),
            22 => 
            array (
                'permission_id' => 9,
                'role_id' => 3,
            ),
            23 => 
            array (
                'permission_id' => 9,
                'role_id' => 6,
            ),
            24 => 
            array (
                'permission_id' => 10,
                'role_id' => 1,
            ),
            25 => 
            array (
                'permission_id' => 10,
                'role_id' => 2,
            ),
            26 => 
            array (
                'permission_id' => 10,
                'role_id' => 3,
            ),
            27 => 
            array (
                'permission_id' => 10,
                'role_id' => 6,
            ),
            28 => 
            array (
                'permission_id' => 11,
                'role_id' => 1,
            ),
            29 => 
            array (
                'permission_id' => 11,
                'role_id' => 2,
            ),
            30 => 
            array (
                'permission_id' => 11,
                'role_id' => 6,
            ),
            31 => 
            array (
                'permission_id' => 12,
                'role_id' => 1,
            ),
            32 => 
            array (
                'permission_id' => 12,
                'role_id' => 2,
            ),
            33 => 
            array (
                'permission_id' => 12,
                'role_id' => 3,
            ),
            34 => 
            array (
                'permission_id' => 12,
                'role_id' => 4,
            ),
            35 => 
            array (
                'permission_id' => 12,
                'role_id' => 6,
            ),
            36 => 
            array (
                'permission_id' => 13,
                'role_id' => 1,
            ),
            37 => 
            array (
                'permission_id' => 13,
                'role_id' => 2,
            ),
            38 => 
            array (
                'permission_id' => 13,
                'role_id' => 3,
            ),
            39 => 
            array (
                'permission_id' => 13,
                'role_id' => 4,
            ),
            40 => 
            array (
                'permission_id' => 13,
                'role_id' => 6,
            ),
            41 => 
            array (
                'permission_id' => 14,
                'role_id' => 1,
            ),
            42 => 
            array (
                'permission_id' => 14,
                'role_id' => 2,
            ),
            43 => 
            array (
                'permission_id' => 14,
                'role_id' => 3,
            ),
            44 => 
            array (
                'permission_id' => 14,
                'role_id' => 6,
            ),
            45 => 
            array (
                'permission_id' => 15,
                'role_id' => 1,
            ),
            46 => 
            array (
                'permission_id' => 15,
                'role_id' => 2,
            ),
            47 => 
            array (
                'permission_id' => 15,
                'role_id' => 6,
            ),
            48 => 
            array (
                'permission_id' => 16,
                'role_id' => 1,
            ),
            49 => 
            array (
                'permission_id' => 16,
                'role_id' => 2,
            ),
            50 => 
            array (
                'permission_id' => 16,
                'role_id' => 3,
            ),
            51 => 
            array (
                'permission_id' => 16,
                'role_id' => 4,
            ),
            52 => 
            array (
                'permission_id' => 16,
                'role_id' => 6,
            ),
            53 => 
            array (
                'permission_id' => 17,
                'role_id' => 1,
            ),
            54 => 
            array (
                'permission_id' => 17,
                'role_id' => 2,
            ),
            55 => 
            array (
                'permission_id' => 17,
                'role_id' => 3,
            ),
            56 => 
            array (
                'permission_id' => 17,
                'role_id' => 4,
            ),
            57 => 
            array (
                'permission_id' => 17,
                'role_id' => 6,
            ),
            58 => 
            array (
                'permission_id' => 18,
                'role_id' => 1,
            ),
            59 => 
            array (
                'permission_id' => 18,
                'role_id' => 2,
            ),
            60 => 
            array (
                'permission_id' => 18,
                'role_id' => 3,
            ),
            61 => 
            array (
                'permission_id' => 18,
                'role_id' => 6,
            ),
            62 => 
            array (
                'permission_id' => 19,
                'role_id' => 1,
            ),
            63 => 
            array (
                'permission_id' => 19,
                'role_id' => 2,
            ),
            64 => 
            array (
                'permission_id' => 19,
                'role_id' => 6,
            ),
            65 => 
            array (
                'permission_id' => 20,
                'role_id' => 1,
            ),
            66 => 
            array (
                'permission_id' => 20,
                'role_id' => 2,
            ),
            67 => 
            array (
                'permission_id' => 20,
                'role_id' => 3,
            ),
            68 => 
            array (
                'permission_id' => 20,
                'role_id' => 6,
            ),
            69 => 
            array (
                'permission_id' => 21,
                'role_id' => 1,
            ),
            70 => 
            array (
                'permission_id' => 21,
                'role_id' => 2,
            ),
            71 => 
            array (
                'permission_id' => 21,
                'role_id' => 3,
            ),
            72 => 
            array (
                'permission_id' => 21,
                'role_id' => 6,
            ),
            73 => 
            array (
                'permission_id' => 22,
                'role_id' => 1,
            ),
            74 => 
            array (
                'permission_id' => 22,
                'role_id' => 2,
            ),
            75 => 
            array (
                'permission_id' => 22,
                'role_id' => 3,
            ),
            76 => 
            array (
                'permission_id' => 22,
                'role_id' => 6,
            ),
            77 => 
            array (
                'permission_id' => 23,
                'role_id' => 1,
            ),
            78 => 
            array (
                'permission_id' => 23,
                'role_id' => 2,
            ),
            79 => 
            array (
                'permission_id' => 23,
                'role_id' => 6,
            ),
            80 => 
            array (
                'permission_id' => 24,
                'role_id' => 1,
            ),
            81 => 
            array (
                'permission_id' => 24,
                'role_id' => 2,
            ),
            82 => 
            array (
                'permission_id' => 24,
                'role_id' => 3,
            ),
            83 => 
            array (
                'permission_id' => 24,
                'role_id' => 4,
            ),
            84 => 
            array (
                'permission_id' => 24,
                'role_id' => 6,
            ),
            85 => 
            array (
                'permission_id' => 25,
                'role_id' => 1,
            ),
            86 => 
            array (
                'permission_id' => 25,
                'role_id' => 2,
            ),
            87 => 
            array (
                'permission_id' => 25,
                'role_id' => 3,
            ),
            88 => 
            array (
                'permission_id' => 25,
                'role_id' => 6,
            ),
            89 => 
            array (
                'permission_id' => 26,
                'role_id' => 1,
            ),
            90 => 
            array (
                'permission_id' => 26,
                'role_id' => 2,
            ),
            91 => 
            array (
                'permission_id' => 26,
                'role_id' => 3,
            ),
            92 => 
            array (
                'permission_id' => 26,
                'role_id' => 6,
            ),
            93 => 
            array (
                'permission_id' => 27,
                'role_id' => 1,
            ),
            94 => 
            array (
                'permission_id' => 27,
                'role_id' => 2,
            ),
            95 => 
            array (
                'permission_id' => 27,
                'role_id' => 6,
            ),
            96 => 
            array (
                'permission_id' => 28,
                'role_id' => 1,
            ),
            97 => 
            array (
                'permission_id' => 28,
                'role_id' => 2,
            ),
            98 => 
            array (
                'permission_id' => 28,
                'role_id' => 3,
            ),
            99 => 
            array (
                'permission_id' => 28,
                'role_id' => 4,
            ),
            100 => 
            array (
                'permission_id' => 28,
                'role_id' => 6,
            ),
            101 => 
            array (
                'permission_id' => 29,
                'role_id' => 1,
            ),
            102 => 
            array (
                'permission_id' => 29,
                'role_id' => 2,
            ),
            103 => 
            array (
                'permission_id' => 29,
                'role_id' => 3,
            ),
            104 => 
            array (
                'permission_id' => 29,
                'role_id' => 6,
            ),
            105 => 
            array (
                'permission_id' => 30,
                'role_id' => 1,
            ),
            106 => 
            array (
                'permission_id' => 30,
                'role_id' => 2,
            ),
            107 => 
            array (
                'permission_id' => 30,
                'role_id' => 3,
            ),
            108 => 
            array (
                'permission_id' => 30,
                'role_id' => 6,
            ),
            109 => 
            array (
                'permission_id' => 31,
                'role_id' => 1,
            ),
            110 => 
            array (
                'permission_id' => 31,
                'role_id' => 2,
            ),
            111 => 
            array (
                'permission_id' => 31,
                'role_id' => 6,
            ),
            112 => 
            array (
                'permission_id' => 32,
                'role_id' => 1,
            ),
            113 => 
            array (
                'permission_id' => 32,
                'role_id' => 2,
            ),
            114 => 
            array (
                'permission_id' => 32,
                'role_id' => 3,
            ),
            115 => 
            array (
                'permission_id' => 32,
                'role_id' => 4,
            ),
            116 => 
            array (
                'permission_id' => 32,
                'role_id' => 6,
            ),
            117 => 
            array (
                'permission_id' => 33,
                'role_id' => 1,
            ),
            118 => 
            array (
                'permission_id' => 33,
                'role_id' => 2,
            ),
            119 => 
            array (
                'permission_id' => 33,
                'role_id' => 3,
            ),
            120 => 
            array (
                'permission_id' => 33,
                'role_id' => 6,
            ),
            121 => 
            array (
                'permission_id' => 34,
                'role_id' => 1,
            ),
            122 => 
            array (
                'permission_id' => 34,
                'role_id' => 2,
            ),
            123 => 
            array (
                'permission_id' => 34,
                'role_id' => 3,
            ),
            124 => 
            array (
                'permission_id' => 34,
                'role_id' => 6,
            ),
            125 => 
            array (
                'permission_id' => 35,
                'role_id' => 1,
            ),
            126 => 
            array (
                'permission_id' => 35,
                'role_id' => 2,
            ),
            127 => 
            array (
                'permission_id' => 35,
                'role_id' => 6,
            ),
            128 => 
            array (
                'permission_id' => 36,
                'role_id' => 1,
            ),
            129 => 
            array (
                'permission_id' => 36,
                'role_id' => 2,
            ),
            130 => 
            array (
                'permission_id' => 36,
                'role_id' => 3,
            ),
            131 => 
            array (
                'permission_id' => 36,
                'role_id' => 4,
            ),
            132 => 
            array (
                'permission_id' => 36,
                'role_id' => 6,
            ),
            133 => 
            array (
                'permission_id' => 37,
                'role_id' => 1,
            ),
            134 => 
            array (
                'permission_id' => 37,
                'role_id' => 2,
            ),
            135 => 
            array (
                'permission_id' => 37,
                'role_id' => 3,
            ),
            136 => 
            array (
                'permission_id' => 37,
                'role_id' => 4,
            ),
            137 => 
            array (
                'permission_id' => 37,
                'role_id' => 6,
            ),
            138 => 
            array (
                'permission_id' => 38,
                'role_id' => 1,
            ),
            139 => 
            array (
                'permission_id' => 38,
                'role_id' => 2,
            ),
            140 => 
            array (
                'permission_id' => 38,
                'role_id' => 3,
            ),
            141 => 
            array (
                'permission_id' => 38,
                'role_id' => 4,
            ),
            142 => 
            array (
                'permission_id' => 38,
                'role_id' => 6,
            ),
            143 => 
            array (
                'permission_id' => 39,
                'role_id' => 1,
            ),
            144 => 
            array (
                'permission_id' => 39,
                'role_id' => 2,
            ),
            145 => 
            array (
                'permission_id' => 39,
                'role_id' => 3,
            ),
            146 => 
            array (
                'permission_id' => 39,
                'role_id' => 4,
            ),
            147 => 
            array (
                'permission_id' => 39,
                'role_id' => 6,
            ),
            148 => 
            array (
                'permission_id' => 40,
                'role_id' => 1,
            ),
            149 => 
            array (
                'permission_id' => 40,
                'role_id' => 2,
            ),
            150 => 
            array (
                'permission_id' => 40,
                'role_id' => 3,
            ),
            151 => 
            array (
                'permission_id' => 40,
                'role_id' => 6,
            ),
            152 => 
            array (
                'permission_id' => 41,
                'role_id' => 1,
            ),
            153 => 
            array (
                'permission_id' => 41,
                'role_id' => 2,
            ),
            154 => 
            array (
                'permission_id' => 41,
                'role_id' => 3,
            ),
            155 => 
            array (
                'permission_id' => 41,
                'role_id' => 6,
            ),
            156 => 
            array (
                'permission_id' => 42,
                'role_id' => 1,
            ),
            157 => 
            array (
                'permission_id' => 42,
                'role_id' => 2,
            ),
            158 => 
            array (
                'permission_id' => 42,
                'role_id' => 3,
            ),
            159 => 
            array (
                'permission_id' => 42,
                'role_id' => 6,
            ),
            160 => 
            array (
                'permission_id' => 43,
                'role_id' => 1,
            ),
            161 => 
            array (
                'permission_id' => 43,
                'role_id' => 2,
            ),
            162 => 
            array (
                'permission_id' => 43,
                'role_id' => 3,
            ),
            163 => 
            array (
                'permission_id' => 43,
                'role_id' => 6,
            ),
            164 => 
            array (
                'permission_id' => 44,
                'role_id' => 1,
            ),
            165 => 
            array (
                'permission_id' => 44,
                'role_id' => 2,
            ),
            166 => 
            array (
                'permission_id' => 44,
                'role_id' => 6,
            ),
            167 => 
            array (
                'permission_id' => 45,
                'role_id' => 1,
            ),
            168 => 
            array (
                'permission_id' => 45,
                'role_id' => 2,
            ),
            169 => 
            array (
                'permission_id' => 45,
                'role_id' => 3,
            ),
            170 => 
            array (
                'permission_id' => 45,
                'role_id' => 6,
            ),
            171 => 
            array (
                'permission_id' => 46,
                'role_id' => 1,
            ),
            172 => 
            array (
                'permission_id' => 46,
                'role_id' => 2,
            ),
            173 => 
            array (
                'permission_id' => 46,
                'role_id' => 3,
            ),
            174 => 
            array (
                'permission_id' => 46,
                'role_id' => 6,
            ),
            175 => 
            array (
                'permission_id' => 47,
                'role_id' => 1,
            ),
            176 => 
            array (
                'permission_id' => 47,
                'role_id' => 2,
            ),
            177 => 
            array (
                'permission_id' => 47,
                'role_id' => 3,
            ),
            178 => 
            array (
                'permission_id' => 47,
                'role_id' => 4,
            ),
            179 => 
            array (
                'permission_id' => 47,
                'role_id' => 6,
            ),
            180 => 
            array (
                'permission_id' => 48,
                'role_id' => 1,
            ),
            181 => 
            array (
                'permission_id' => 48,
                'role_id' => 2,
            ),
            182 => 
            array (
                'permission_id' => 48,
                'role_id' => 3,
            ),
            183 => 
            array (
                'permission_id' => 48,
                'role_id' => 4,
            ),
            184 => 
            array (
                'permission_id' => 48,
                'role_id' => 6,
            ),
            185 => 
            array (
                'permission_id' => 49,
                'role_id' => 1,
            ),
            186 => 
            array (
                'permission_id' => 49,
                'role_id' => 2,
            ),
            187 => 
            array (
                'permission_id' => 49,
                'role_id' => 3,
            ),
            188 => 
            array (
                'permission_id' => 49,
                'role_id' => 4,
            ),
            189 => 
            array (
                'permission_id' => 49,
                'role_id' => 6,
            ),
            190 => 
            array (
                'permission_id' => 50,
                'role_id' => 1,
            ),
            191 => 
            array (
                'permission_id' => 50,
                'role_id' => 2,
            ),
            192 => 
            array (
                'permission_id' => 50,
                'role_id' => 3,
            ),
            193 => 
            array (
                'permission_id' => 50,
                'role_id' => 4,
            ),
            194 => 
            array (
                'permission_id' => 50,
                'role_id' => 6,
            ),
            195 => 
            array (
                'permission_id' => 51,
                'role_id' => 1,
            ),
            196 => 
            array (
                'permission_id' => 51,
                'role_id' => 2,
            ),
            197 => 
            array (
                'permission_id' => 51,
                'role_id' => 3,
            ),
            198 => 
            array (
                'permission_id' => 51,
                'role_id' => 4,
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
                'role_id' => 4,
            ),
            204 => 
            array (
                'permission_id' => 52,
                'role_id' => 6,
            ),
            205 => 
            array (
                'permission_id' => 53,
                'role_id' => 1,
            ),
            206 => 
            array (
                'permission_id' => 53,
                'role_id' => 2,
            ),
            207 => 
            array (
                'permission_id' => 53,
                'role_id' => 3,
            ),
            208 => 
            array (
                'permission_id' => 53,
                'role_id' => 6,
            ),
            209 => 
            array (
                'permission_id' => 54,
                'role_id' => 1,
            ),
            210 => 
            array (
                'permission_id' => 54,
                'role_id' => 2,
            ),
            211 => 
            array (
                'permission_id' => 54,
                'role_id' => 3,
            ),
            212 => 
            array (
                'permission_id' => 54,
                'role_id' => 4,
            ),
            213 => 
            array (
                'permission_id' => 54,
                'role_id' => 6,
            ),
            214 => 
            array (
                'permission_id' => 55,
                'role_id' => 1,
            ),
            215 => 
            array (
                'permission_id' => 55,
                'role_id' => 2,
            ),
            216 => 
            array (
                'permission_id' => 55,
                'role_id' => 3,
            ),
            217 => 
            array (
                'permission_id' => 55,
                'role_id' => 4,
            ),
            218 => 
            array (
                'permission_id' => 55,
                'role_id' => 6,
            ),
            219 => 
            array (
                'permission_id' => 56,
                'role_id' => 1,
            ),
            220 => 
            array (
                'permission_id' => 56,
                'role_id' => 2,
            ),
            221 => 
            array (
                'permission_id' => 56,
                'role_id' => 3,
            ),
            222 => 
            array (
                'permission_id' => 56,
                'role_id' => 4,
            ),
            223 => 
            array (
                'permission_id' => 56,
                'role_id' => 6,
            ),
            224 => 
            array (
                'permission_id' => 57,
                'role_id' => 1,
            ),
            225 => 
            array (
                'permission_id' => 57,
                'role_id' => 2,
            ),
            226 => 
            array (
                'permission_id' => 57,
                'role_id' => 3,
            ),
            227 => 
            array (
                'permission_id' => 57,
                'role_id' => 6,
            ),
            228 => 
            array (
                'permission_id' => 58,
                'role_id' => 1,
            ),
            229 => 
            array (
                'permission_id' => 58,
                'role_id' => 2,
            ),
            230 => 
            array (
                'permission_id' => 58,
                'role_id' => 6,
            ),
            231 => 
            array (
                'permission_id' => 59,
                'role_id' => 1,
            ),
            232 => 
            array (
                'permission_id' => 59,
                'role_id' => 2,
            ),
            233 => 
            array (
                'permission_id' => 59,
                'role_id' => 3,
            ),
            234 => 
            array (
                'permission_id' => 61,
                'role_id' => 1,
            ),
            235 => 
            array (
                'permission_id' => 61,
                'role_id' => 2,
            ),
            236 => 
            array (
                'permission_id' => 61,
                'role_id' => 3,
            ),
            237 => 
            array (
                'permission_id' => 61,
                'role_id' => 4,
            ),
            238 => 
            array (
                'permission_id' => 61,
                'role_id' => 6,
            ),
            239 => 
            array (
                'permission_id' => 62,
                'role_id' => 1,
            ),
            240 => 
            array (
                'permission_id' => 62,
                'role_id' => 2,
            ),
            241 => 
            array (
                'permission_id' => 62,
                'role_id' => 3,
            ),
            242 => 
            array (
                'permission_id' => 62,
                'role_id' => 6,
            ),
            243 => 
            array (
                'permission_id' => 63,
                'role_id' => 1,
            ),
            244 => 
            array (
                'permission_id' => 63,
                'role_id' => 2,
            ),
            245 => 
            array (
                'permission_id' => 63,
                'role_id' => 3,
            ),
            246 => 
            array (
                'permission_id' => 63,
                'role_id' => 4,
            ),
            247 => 
            array (
                'permission_id' => 63,
                'role_id' => 6,
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
                'role_id' => 2,
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
                'role_id' => 4,
            ),
            263 => 
            array (
                'permission_id' => 67,
                'role_id' => 6,
            ),
            264 => 
            array (
                'permission_id' => 68,
                'role_id' => 1,
            ),
            265 => 
            array (
                'permission_id' => 68,
                'role_id' => 2,
            ),
            266 => 
            array (
                'permission_id' => 68,
                'role_id' => 3,
            ),
            267 => 
            array (
                'permission_id' => 68,
                'role_id' => 6,
            ),
            268 => 
            array (
                'permission_id' => 69,
                'role_id' => 1,
            ),
            269 => 
            array (
                'permission_id' => 69,
                'role_id' => 2,
            ),
            270 => 
            array (
                'permission_id' => 69,
                'role_id' => 3,
            ),
            271 => 
            array (
                'permission_id' => 69,
                'role_id' => 4,
            ),
            272 => 
            array (
                'permission_id' => 69,
                'role_id' => 6,
            ),
            273 => 
            array (
                'permission_id' => 70,
                'role_id' => 1,
            ),
            274 => 
            array (
                'permission_id' => 70,
                'role_id' => 2,
            ),
            275 => 
            array (
                'permission_id' => 70,
                'role_id' => 3,
            ),
            276 => 
            array (
                'permission_id' => 70,
                'role_id' => 6,
            ),
            277 => 
            array (
                'permission_id' => 71,
                'role_id' => 1,
            ),
            278 => 
            array (
                'permission_id' => 71,
                'role_id' => 2,
            ),
            279 => 
            array (
                'permission_id' => 71,
                'role_id' => 3,
            ),
            280 => 
            array (
                'permission_id' => 71,
                'role_id' => 6,
            ),
            281 => 
            array (
                'permission_id' => 72,
                'role_id' => 1,
            ),
            282 => 
            array (
                'permission_id' => 72,
                'role_id' => 2,
            ),
            283 => 
            array (
                'permission_id' => 72,
                'role_id' => 3,
            ),
            284 => 
            array (
                'permission_id' => 72,
                'role_id' => 6,
            ),
            285 => 
            array (
                'permission_id' => 73,
                'role_id' => 1,
            ),
            286 => 
            array (
                'permission_id' => 73,
                'role_id' => 2,
            ),
            287 => 
            array (
                'permission_id' => 73,
                'role_id' => 3,
            ),
            288 => 
            array (
                'permission_id' => 73,
                'role_id' => 6,
            ),
            289 => 
            array (
                'permission_id' => 74,
                'role_id' => 1,
            ),
            290 => 
            array (
                'permission_id' => 74,
                'role_id' => 2,
            ),
            291 => 
            array (
                'permission_id' => 74,
                'role_id' => 3,
            ),
            292 => 
            array (
                'permission_id' => 74,
                'role_id' => 6,
            ),
            293 => 
            array (
                'permission_id' => 75,
                'role_id' => 1,
            ),
            294 => 
            array (
                'permission_id' => 75,
                'role_id' => 2,
            ),
            295 => 
            array (
                'permission_id' => 75,
                'role_id' => 3,
            ),
            296 => 
            array (
                'permission_id' => 75,
                'role_id' => 6,
            ),
            297 => 
            array (
                'permission_id' => 76,
                'role_id' => 1,
            ),
            298 => 
            array (
                'permission_id' => 76,
                'role_id' => 2,
            ),
            299 => 
            array (
                'permission_id' => 76,
                'role_id' => 6,
            ),
            300 => 
            array (
                'permission_id' => 77,
                'role_id' => 1,
            ),
            301 => 
            array (
                'permission_id' => 77,
                'role_id' => 2,
            ),
            302 => 
            array (
                'permission_id' => 77,
                'role_id' => 3,
            ),
            303 => 
            array (
                'permission_id' => 77,
                'role_id' => 6,
            ),
            304 => 
            array (
                'permission_id' => 78,
                'role_id' => 1,
            ),
            305 => 
            array (
                'permission_id' => 78,
                'role_id' => 2,
            ),
            306 => 
            array (
                'permission_id' => 78,
                'role_id' => 3,
            ),
            307 => 
            array (
                'permission_id' => 78,
                'role_id' => 4,
            ),
            308 => 
            array (
                'permission_id' => 78,
                'role_id' => 6,
            ),
            309 => 
            array (
                'permission_id' => 79,
                'role_id' => 1,
            ),
            310 => 
            array (
                'permission_id' => 79,
                'role_id' => 2,
            ),
            311 => 
            array (
                'permission_id' => 79,
                'role_id' => 3,
            ),
            312 => 
            array (
                'permission_id' => 79,
                'role_id' => 6,
            ),
            313 => 
            array (
                'permission_id' => 82,
                'role_id' => 1,
            ),
            314 => 
            array (
                'permission_id' => 82,
                'role_id' => 2,
            ),
            315 => 
            array (
                'permission_id' => 82,
                'role_id' => 3,
            ),
            316 => 
            array (
                'permission_id' => 82,
                'role_id' => 4,
            ),
            317 => 
            array (
                'permission_id' => 82,
                'role_id' => 6,
            ),
            318 => 
            array (
                'permission_id' => 84,
                'role_id' => 1,
            ),
            319 => 
            array (
                'permission_id' => 84,
                'role_id' => 2,
            ),
            320 => 
            array (
                'permission_id' => 84,
                'role_id' => 3,
            ),
            321 => 
            array (
                'permission_id' => 84,
                'role_id' => 6,
            ),
            322 => 
            array (
                'permission_id' => 85,
                'role_id' => 1,
            ),
            323 => 
            array (
                'permission_id' => 85,
                'role_id' => 2,
            ),
            324 => 
            array (
                'permission_id' => 85,
                'role_id' => 3,
            ),
            325 => 
            array (
                'permission_id' => 85,
                'role_id' => 6,
            ),
            326 => 
            array (
                'permission_id' => 86,
                'role_id' => 1,
            ),
            327 => 
            array (
                'permission_id' => 86,
                'role_id' => 2,
            ),
            328 => 
            array (
                'permission_id' => 86,
                'role_id' => 3,
            ),
            329 => 
            array (
                'permission_id' => 86,
                'role_id' => 6,
            ),
            330 => 
            array (
                'permission_id' => 87,
                'role_id' => 1,
            ),
            331 => 
            array (
                'permission_id' => 87,
                'role_id' => 2,
            ),
            332 => 
            array (
                'permission_id' => 87,
                'role_id' => 3,
            ),
            333 => 
            array (
                'permission_id' => 88,
                'role_id' => 1,
            ),
            334 => 
            array (
                'permission_id' => 88,
                'role_id' => 2,
            ),
            335 => 
            array (
                'permission_id' => 88,
                'role_id' => 3,
            ),
            336 => 
            array (
                'permission_id' => 88,
                'role_id' => 6,
            ),
            337 => 
            array (
                'permission_id' => 89,
                'role_id' => 1,
            ),
            338 => 
            array (
                'permission_id' => 89,
                'role_id' => 2,
            ),
            339 => 
            array (
                'permission_id' => 89,
                'role_id' => 3,
            ),
            340 => 
            array (
                'permission_id' => 89,
                'role_id' => 6,
            ),
            341 => 
            array (
                'permission_id' => 90,
                'role_id' => 1,
            ),
            342 => 
            array (
                'permission_id' => 90,
                'role_id' => 2,
            ),
            343 => 
            array (
                'permission_id' => 90,
                'role_id' => 3,
            ),
            344 => 
            array (
                'permission_id' => 90,
                'role_id' => 4,
            ),
            345 => 
            array (
                'permission_id' => 90,
                'role_id' => 6,
            ),
            346 => 
            array (
                'permission_id' => 91,
                'role_id' => 1,
            ),
            347 => 
            array (
                'permission_id' => 91,
                'role_id' => 2,
            ),
            348 => 
            array (
                'permission_id' => 91,
                'role_id' => 3,
            ),
            349 => 
            array (
                'permission_id' => 91,
                'role_id' => 4,
            ),
            350 => 
            array (
                'permission_id' => 91,
                'role_id' => 6,
            ),
            351 => 
            array (
                'permission_id' => 92,
                'role_id' => 1,
            ),
            352 => 
            array (
                'permission_id' => 92,
                'role_id' => 2,
            ),
            353 => 
            array (
                'permission_id' => 92,
                'role_id' => 3,
            ),
            354 => 
            array (
                'permission_id' => 92,
                'role_id' => 6,
            ),
            355 => 
            array (
                'permission_id' => 93,
                'role_id' => 1,
            ),
            356 => 
            array (
                'permission_id' => 93,
                'role_id' => 2,
            ),
            357 => 
            array (
                'permission_id' => 93,
                'role_id' => 3,
            ),
            358 => 
            array (
                'permission_id' => 93,
                'role_id' => 4,
            ),
            359 => 
            array (
                'permission_id' => 93,
                'role_id' => 6,
            ),
            360 => 
            array (
                'permission_id' => 94,
                'role_id' => 1,
            ),
            361 => 
            array (
                'permission_id' => 94,
                'role_id' => 2,
            ),
            362 => 
            array (
                'permission_id' => 94,
                'role_id' => 3,
            ),
            363 => 
            array (
                'permission_id' => 94,
                'role_id' => 6,
            ),
            364 => 
            array (
                'permission_id' => 95,
                'role_id' => 1,
            ),
            365 => 
            array (
                'permission_id' => 95,
                'role_id' => 2,
            ),
            366 => 
            array (
                'permission_id' => 95,
                'role_id' => 3,
            ),
            367 => 
            array (
                'permission_id' => 95,
                'role_id' => 6,
            ),
            368 => 
            array (
                'permission_id' => 96,
                'role_id' => 1,
            ),
            369 => 
            array (
                'permission_id' => 96,
                'role_id' => 2,
            ),
            370 => 
            array (
                'permission_id' => 96,
                'role_id' => 6,
            ),
            371 => 
            array (
                'permission_id' => 97,
                'role_id' => 1,
            ),
            372 => 
            array (
                'permission_id' => 97,
                'role_id' => 2,
            ),
            373 => 
            array (
                'permission_id' => 97,
                'role_id' => 3,
            ),
            374 => 
            array (
                'permission_id' => 97,
                'role_id' => 4,
            ),
            375 => 
            array (
                'permission_id' => 97,
                'role_id' => 6,
            ),
            376 => 
            array (
                'permission_id' => 98,
                'role_id' => 1,
            ),
            377 => 
            array (
                'permission_id' => 98,
                'role_id' => 2,
            ),
            378 => 
            array (
                'permission_id' => 98,
                'role_id' => 3,
            ),
            379 => 
            array (
                'permission_id' => 98,
                'role_id' => 6,
            ),
            380 => 
            array (
                'permission_id' => 99,
                'role_id' => 1,
            ),
            381 => 
            array (
                'permission_id' => 99,
                'role_id' => 2,
            ),
            382 => 
            array (
                'permission_id' => 99,
                'role_id' => 3,
            ),
            383 => 
            array (
                'permission_id' => 99,
                'role_id' => 6,
            ),
            384 => 
            array (
                'permission_id' => 100,
                'role_id' => 1,
            ),
            385 => 
            array (
                'permission_id' => 100,
                'role_id' => 2,
            ),
            386 => 
            array (
                'permission_id' => 100,
                'role_id' => 3,
            ),
            387 => 
            array (
                'permission_id' => 101,
                'role_id' => 1,
            ),
            388 => 
            array (
                'permission_id' => 101,
                'role_id' => 2,
            ),
            389 => 
            array (
                'permission_id' => 101,
                'role_id' => 3,
            ),
            390 => 
            array (
                'permission_id' => 101,
                'role_id' => 4,
            ),
            391 => 
            array (
                'permission_id' => 101,
                'role_id' => 6,
            ),
            392 => 
            array (
                'permission_id' => 102,
                'role_id' => 1,
            ),
            393 => 
            array (
                'permission_id' => 102,
                'role_id' => 2,
            ),
            394 => 
            array (
                'permission_id' => 102,
                'role_id' => 3,
            ),
            395 => 
            array (
                'permission_id' => 102,
                'role_id' => 6,
            ),
            396 => 
            array (
                'permission_id' => 106,
                'role_id' => 1,
            ),
            397 => 
            array (
                'permission_id' => 106,
                'role_id' => 2,
            ),
            398 => 
            array (
                'permission_id' => 106,
                'role_id' => 3,
            ),
            399 => 
            array (
                'permission_id' => 106,
                'role_id' => 4,
            ),
            400 => 
            array (
                'permission_id' => 106,
                'role_id' => 6,
            ),
            401 => 
            array (
                'permission_id' => 107,
                'role_id' => 1,
            ),
            402 => 
            array (
                'permission_id' => 107,
                'role_id' => 2,
            ),
            403 => 
            array (
                'permission_id' => 107,
                'role_id' => 3,
            ),
            404 => 
            array (
                'permission_id' => 107,
                'role_id' => 4,
            ),
            405 => 
            array (
                'permission_id' => 107,
                'role_id' => 6,
            ),
            406 => 
            array (
                'permission_id' => 108,
                'role_id' => 1,
            ),
            407 => 
            array (
                'permission_id' => 108,
                'role_id' => 2,
            ),
            408 => 
            array (
                'permission_id' => 108,
                'role_id' => 3,
            ),
            409 => 
            array (
                'permission_id' => 108,
                'role_id' => 6,
            ),
            410 => 
            array (
                'permission_id' => 109,
                'role_id' => 1,
            ),
            411 => 
            array (
                'permission_id' => 109,
                'role_id' => 2,
            ),
            412 => 
            array (
                'permission_id' => 109,
                'role_id' => 3,
            ),
            413 => 
            array (
                'permission_id' => 109,
                'role_id' => 6,
            ),
            414 => 
            array (
                'permission_id' => 110,
                'role_id' => 1,
            ),
            415 => 
            array (
                'permission_id' => 110,
                'role_id' => 2,
            ),
            416 => 
            array (
                'permission_id' => 110,
                'role_id' => 3,
            ),
            417 => 
            array (
                'permission_id' => 110,
                'role_id' => 4,
            ),
            418 => 
            array (
                'permission_id' => 110,
                'role_id' => 6,
            ),
            419 => 
            array (
                'permission_id' => 111,
                'role_id' => 1,
            ),
            420 => 
            array (
                'permission_id' => 111,
                'role_id' => 2,
            ),
            421 => 
            array (
                'permission_id' => 111,
                'role_id' => 3,
            ),
            422 => 
            array (
                'permission_id' => 111,
                'role_id' => 4,
            ),
            423 => 
            array (
                'permission_id' => 111,
                'role_id' => 6,
            ),
            424 => 
            array (
                'permission_id' => 112,
                'role_id' => 1,
            ),
            425 => 
            array (
                'permission_id' => 112,
                'role_id' => 2,
            ),
            426 => 
            array (
                'permission_id' => 112,
                'role_id' => 3,
            ),
            427 => 
            array (
                'permission_id' => 112,
                'role_id' => 6,
            ),
            428 => 
            array (
                'permission_id' => 113,
                'role_id' => 1,
            ),
            429 => 
            array (
                'permission_id' => 113,
                'role_id' => 2,
            ),
            430 => 
            array (
                'permission_id' => 113,
                'role_id' => 3,
            ),
            431 => 
            array (
                'permission_id' => 113,
                'role_id' => 6,
            ),
            432 => 
            array (
                'permission_id' => 114,
                'role_id' => 1,
            ),
            433 => 
            array (
                'permission_id' => 114,
                'role_id' => 2,
            ),
            434 => 
            array (
                'permission_id' => 114,
                'role_id' => 3,
            ),
            435 => 
            array (
                'permission_id' => 114,
                'role_id' => 6,
            ),
            436 => 
            array (
                'permission_id' => 115,
                'role_id' => 1,
            ),
            437 => 
            array (
                'permission_id' => 115,
                'role_id' => 2,
            ),
            438 => 
            array (
                'permission_id' => 115,
                'role_id' => 3,
            ),
            439 => 
            array (
                'permission_id' => 115,
                'role_id' => 6,
            ),
            440 => 
            array (
                'permission_id' => 116,
                'role_id' => 1,
            ),
            441 => 
            array (
                'permission_id' => 116,
                'role_id' => 2,
            ),
            442 => 
            array (
                'permission_id' => 116,
                'role_id' => 6,
            ),
            443 => 
            array (
                'permission_id' => 117,
                'role_id' => 1,
            ),
            444 => 
            array (
                'permission_id' => 117,
                'role_id' => 2,
            ),
            445 => 
            array (
                'permission_id' => 117,
                'role_id' => 3,
            ),
            446 => 
            array (
                'permission_id' => 117,
                'role_id' => 4,
            ),
            447 => 
            array (
                'permission_id' => 117,
                'role_id' => 6,
            ),
            448 => 
            array (
                'permission_id' => 118,
                'role_id' => 1,
            ),
            449 => 
            array (
                'permission_id' => 118,
                'role_id' => 2,
            ),
            450 => 
            array (
                'permission_id' => 118,
                'role_id' => 3,
            ),
            451 => 
            array (
                'permission_id' => 118,
                'role_id' => 4,
            ),
            452 => 
            array (
                'permission_id' => 118,
                'role_id' => 6,
            ),
            453 => 
            array (
                'permission_id' => 119,
                'role_id' => 1,
            ),
            454 => 
            array (
                'permission_id' => 119,
                'role_id' => 2,
            ),
            455 => 
            array (
                'permission_id' => 119,
                'role_id' => 3,
            ),
            456 => 
            array (
                'permission_id' => 119,
                'role_id' => 6,
            ),
            457 => 
            array (
                'permission_id' => 120,
                'role_id' => 1,
            ),
            458 => 
            array (
                'permission_id' => 120,
                'role_id' => 2,
            ),
            459 => 
            array (
                'permission_id' => 120,
                'role_id' => 6,
            ),
            460 => 
            array (
                'permission_id' => 121,
                'role_id' => 1,
            ),
            461 => 
            array (
                'permission_id' => 121,
                'role_id' => 2,
            ),
            462 => 
            array (
                'permission_id' => 121,
                'role_id' => 3,
            ),
            463 => 
            array (
                'permission_id' => 121,
                'role_id' => 6,
            ),
            464 => 
            array (
                'permission_id' => 122,
                'role_id' => 1,
            ),
            465 => 
            array (
                'permission_id' => 122,
                'role_id' => 2,
            ),
            466 => 
            array (
                'permission_id' => 122,
                'role_id' => 3,
            ),
            467 => 
            array (
                'permission_id' => 122,
                'role_id' => 4,
            ),
            468 => 
            array (
                'permission_id' => 122,
                'role_id' => 6,
            ),
            469 => 
            array (
                'permission_id' => 124,
                'role_id' => 1,
            ),
            470 => 
            array (
                'permission_id' => 124,
                'role_id' => 2,
            ),
            471 => 
            array (
                'permission_id' => 124,
                'role_id' => 3,
            ),
            472 => 
            array (
                'permission_id' => 124,
                'role_id' => 4,
            ),
            473 => 
            array (
                'permission_id' => 124,
                'role_id' => 6,
            ),
            474 => 
            array (
                'permission_id' => 125,
                'role_id' => 1,
            ),
            475 => 
            array (
                'permission_id' => 125,
                'role_id' => 2,
            ),
            476 => 
            array (
                'permission_id' => 125,
                'role_id' => 3,
            ),
            477 => 
            array (
                'permission_id' => 125,
                'role_id' => 6,
            ),
            478 => 
            array (
                'permission_id' => 126,
                'role_id' => 1,
            ),
            479 => 
            array (
                'permission_id' => 126,
                'role_id' => 2,
            ),
            480 => 
            array (
                'permission_id' => 126,
                'role_id' => 3,
            ),
            481 => 
            array (
                'permission_id' => 126,
                'role_id' => 6,
            ),
        ));
        
        
    }
}
