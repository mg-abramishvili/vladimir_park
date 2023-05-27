<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ConfigSeeder extends Seeder
{
    public function run()
    {
        DB::table('configs')->insert([
            'id' => 1,
            'theme' => 'muzei',
            'orientation' => 'vertical',
            'activated' => 'y',
            'title' => 'город Владимир',
            'logo' => '/img/vladimir/logo.png',
        ]);
    }
}