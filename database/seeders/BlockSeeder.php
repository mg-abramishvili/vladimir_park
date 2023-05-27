<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BlockSeeder extends Seeder
{
    public function run()
    {
        DB::table('blocks')->insert([
            [
                'id' => 1,
                'page_id' => 1,
                'type' => 'image',
                'content' => '/img/vladimir/banner1.jpg',
                'order' => 1,
            ],
            [
                'id' => 2,
                'page_id' => 1,
                'type' => 'audio',
                'content' => '/img/vladimir/o_gorode.m4a',
                'order' => 2,
            ],
            [
                'id' => 3,
                'page_id' => 1,
                'type' => 'text',
                'content' => '<p>Добро пожаловать во Владимир &mdash; город с тысячелетней историей, древнюю столицу Руси. По одной из версий, город был основан в 990 году князем Владимиром Красное Солнышко.</p><p>До наших дней дошли уникальные памятники белокаменного зодчества 12 века &mdash; Золотые ворота, Успенский собор, Дмитриевский собор. Центр города сохранил свой исторический вид, особый шарм и очарование прошлых столетий.</p><p>Владимир - это интересные музеи, уютные кафе, вкусное мороженое, запах свежего хлеба по утрам. А самое главное &mdash; это люди. Люди, которые вам очень рады.</p>',
                'order' => 3,
            ],
            [
                'id' => 4,
                'page_id' => 2,
                'type' => 'routes',
                'content' => 'routes',
                'order' => 1,
            ],
        ]);
    }
}