<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SchemeSeeder extends Seeder
{
    public function run()
    {
        DB::table('schemes')->insert([
            [
                'id' => 1,
                'name' => 'Карта',
                'image' => '/img/vladimir/scheme.png',
            ],
        ]);
    }
}