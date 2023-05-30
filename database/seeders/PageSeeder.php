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
                'parent_id' => null,
                'name' => 'О городе',
                'order' => 1,
                'icon_id' => 7,
                'is_folder' => false,
            ],
            [
                'id' => 2,
                'parent_id' => null,
                'name' => 'Куда пойти',
                'order' => 2,
                'icon_id' => 7,
                'is_folder' => false,
            ],
            [
                'id' => 3,
                'parent_id' => null,
                'name' => 'Афиша',
                'order' => 3,
                'icon_id' => 7,
                'is_folder' => false,
            ],
            [
                'id' => 4,
                'parent_id' => null,
                'name' => 'Песни о Владимире',
                'order' => 4,
                'icon_id' => 7,
                'is_folder' => true,
            ],
            [
                'id' => 5,
                'parent_id' => 4,
                'name' => 'Алексей Молдалиев - Песня о Владимире',
                'order' => 1,
                'icon_id' => 8,
                'is_folder' => false,
            ],
            [
                'id' => 6,
                'parent_id' => 4,
                'name' => 'Дуэт ИванОльга - Песня о Владимире',
                'order' => 2,
                'icon_id' => 9,
                'is_folder' => false,
            ],
        ]);
    }
}