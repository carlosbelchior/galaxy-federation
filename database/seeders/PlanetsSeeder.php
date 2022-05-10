<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('planets')->insert(['name' => 'Andvari']);
        DB::table('planets')->insert(['name' => 'Demeter']);
        DB::table('planets')->insert(['name' => 'Aqua']);
        DB::table('planets')->insert(['name' => 'Calas']);
    }
}
