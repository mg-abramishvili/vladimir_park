<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    public function run()
    {
        DB::table('pages')->insert([
            [
                'id' => 1,
                'name' => 'О городе',
                'order' => 1,
                'icon_id' => 7,
            ],
            [
                'id' => 2,
                'name' => 'Куда пойти',
                'order' => 2,
                'icon_id' => 7,
            ],
            [
                'id' => 3,
                'name' => 'Афиша',
                'order' => 3,
                'icon_id' => 7,
            ],
            [
                'id' => 4,
                'name' => 'Песни о Владимире',
                'order' => 4,
                'icon_id' => 7,
            ],
        ]);
    }
}