<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class IconSeeder extends Seeder
{
    public function run()
    {
        DB::table('icons')->insert([
            [
                'id' => 1,
                'image' => '/img/icons/01.png',
            ],
            [
                'id' => 2,
                'image' => '/img/icons/02.png',
            ],
            [
                'id' => 3,
                'image' => '/img/icons/03.png',
            ],
            [
                'id' => 4,
                'image' => '/img/icons/04.png',
            ],
            [
                'id' => 5,
                'image' => '/img/icons/05.png',
            ],
            [
                'id' => 6,
                'image' => '/img/icons/06.png',
            ],
            [
                'id' => 7,
                'image' => '/img/vladimir/banner1.jpg',
            ],
            [
                'id' => 8,
                'image' => '/img/vladimir/moldal.png',
            ],
            [
                'id' => 9,
                'image' => '/img/vladimir/ivanolga.png',
            ],
        ]);
    }
}