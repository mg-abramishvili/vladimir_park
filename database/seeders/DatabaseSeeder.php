<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ConfigSeeder::class,
            IconSeeder::class,
            BannerSeeder::class,
            BlockSeeder::class,
            PageSeeder::class,
            SchemeSeeder::class,
            RouteSeeder::class,
            KioskSeeder::class,
        ]);
    }
}