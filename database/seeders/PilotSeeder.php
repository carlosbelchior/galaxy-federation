<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PilotSeeder extends Seeder
{
    // Planets
    private $planets = array(1 => 'Andvari', 2 => 'Demeter', 3 => 'Aqua', 4 => 'Calas');

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pilots')->insert([
            'pilot_certification' => rand(1000000,9999999),
            'name' => Str::random(10),
            'age' => rand(18,65),
            'credits' => rand(100,500),
            'location_planet' => $this->planets[rand(1,4)]
        ]);
    }
}
