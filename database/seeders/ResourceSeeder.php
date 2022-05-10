<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resources')->insert([
            'contract_id' => 1,
            'name' => 'water',
            'weight' => 10
        ]);
        DB::table('resources')->insert([
            'contract_id' => 1,
            'name' => 'food',
            'weight' => 20
        ]);
    }
}
