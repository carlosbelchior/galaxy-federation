<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoutersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default routers
        DB::table('routers')->insert(['origin_planet' => 'Andvari', 'destiny_planet' => 'Aqua', 'coust' => 13]);
        DB::table('routers')->insert(['origin_planet' => 'Andvari', 'destiny_planet' => 'Calas', 'coust' => 23]);
        DB::table('routers')->insert(['origin_planet' => 'Demeter', 'destiny_planet' => 'Aqua', 'coust' => 22]);
        DB::table('routers')->insert(['origin_planet' => 'Demeter', 'destiny_planet' => 'Calas', 'coust' => 25]);
        DB::table('routers')->insert(['origin_planet' => 'Aqua', 'destiny_planet' => 'Demeter', 'coust' => 30]);
        DB::table('routers')->insert(['origin_planet' => 'Aqua', 'destiny_planet' => 'Calas', 'coust' => 12]);
        DB::table('routers')->insert(['origin_planet' => 'Calas', 'destiny_planet' => 'Andvari', 'coust' => 20]);
        DB::table('routers')->insert(['origin_planet' => 'Calas', 'destiny_planet' => 'Demeter', 'coust' => 25]);
        DB::table('routers')->insert(['origin_planet' => 'Calas', 'destiny_planet' => 'Aqua', 'coust' => 15]);
        // Extra routers
        DB::table('routers')->insert(['origin_planet' => 'Andvari', 'destiny_planet' => 'Demeter', 'coust' => 48]);
        DB::table('routers')->insert(['origin_planet' => 'Demeter', 'destiny_planet' => 'Andvari', 'coust' => 45]);
        DB::table('routers')->insert(['origin_planet' => 'Aqua', 'destiny_planet' => 'Andvari', 'coust' => 32]);
    }
}
