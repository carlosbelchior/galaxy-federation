<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contracts')->insert([
            'pilot_id' => 1,
            'ship_id' => 1,
            'description' => 'Seed Contract',
            'payload' => 100,
            'origin_planet' => 'Andvari',
            'destination_planet' => 'Demeter',
            'value' => 100
        ]);
    }
}
