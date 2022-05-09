<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;


class AddTest extends TestCase
{
    // Planets
    private $planets = array(1 => 'Andvari', 2 => 'Demeter', 3 => 'Aqua', 4 => 'Calas');

    // Teste add new pilot
    public function test_add_pilot()
    {
        $response = $this->post('/api/add/pilot', [
            'pilot_certification' => rand(1000000,9999999),
            'name' => Str::random(10),
            'age' => rand(18,65),
            'credits' => rand(100,500),
            'location_planet' => $this->planets[rand(1,4)]
        ]);
        $response->assertStatus(200);
    }

    // Teste add new ship
    public function test_add_ship()
    {
        $response = $this->post('/api/add/ship', [
            'fuel_capacity' => rand(400,500),
            'fuel_level' => rand(100,300),
            'weight_capacity' => rand(20,500),
            'location_planet' => $this->planets[rand(1,4)]
        ]);
        $response->assertStatus(200);
    }

    // Teste add new contract
    /*
    * This test always return error because need the valid pilot_certification
    */
    public function test_add_contract()
    {
        $response = $this->post('/api/add/contracts', [
            'pilot_id' => 1,
            'ship_id' => 1,
            'description' => Str::random(20),
            'payload' => rand(100,500),
            'origin_planet' => $this->planets[rand(1,4)],
            'destination_planet' => $this->planets[rand(1,4)],
            'value' => rand(100,500),
        ]);
        $response->assertStatus(200);
    }
}
