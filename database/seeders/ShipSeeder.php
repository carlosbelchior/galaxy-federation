<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ships')->insert([
            'fuel_capacity' => rand(400,500),
            'fuel_level' => rand(100,300),
            'weight_capacity' => rand(20,500),
            'location_planet' => 'Andvari'
        ]);
    }
}
