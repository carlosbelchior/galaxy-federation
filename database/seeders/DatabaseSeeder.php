<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PlanetsSeeder::class,
            RoutersSeeder::class,
            // PilotSeeder::class,
            // ShipSeeder::class,
            // ContractSeeder::class,
            // ResourceSeeder::class,
        ]);
    }
}
