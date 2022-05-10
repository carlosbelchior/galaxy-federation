<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;


class AddTest extends TestCase
{
    // Test add new pilot - ok
    public function test_ok_add_pilot()
    {
        $response = $this->post('/api/add/pilot', [
            'pilot_certification' => 1234567,
            'name' => Str::random(10),
            'age' => rand(18,65),
            'credits' => rand(100,500),
            'location_planet' => 'Calas'
        ]);
        $response->assertStatus(200);
    }

    // Test add new ship - ok
    public function test_ok_add_ship()
    {
        $response = $this->post('/api/add/ship', [
            'fuel_capacity' => rand(400,500),
            'fuel_level' => rand(100,300),
            'weight_capacity' => rand(20,500),
            'location_planet' => 'Calas'
        ]);
        $response->assertStatus(200);
    }

    // Test add new contract - ok
    public function test_ok_add_contract()
    {
        $response = $this->post('/api/add/contracts', [
            'description' => Str::random(30),
            'pilot' => 1234567,
            'ship' => 1,
            'payload' => [
                'water' => 20,
                'food' => 50
            ],
            'origin_planet' => 'Calas',
            'destination_planet' => 'Andvari',
            'value' => rand(100,500),
        ]);
        $response->assertStatus(200);
    }

    // Test add new pilot - error
    public function test_error_add_pilot()
    {
        $response = $this->post('/api/add/pilot');
        $response->assertStatus(400);
    }

    // Test add new ship - error
    public function test_error_add_ship()
    {
        $response = $this->post('/api/add/ship');
        $response->assertStatus(400);
    }

    // Test add new contract - error
    public function test_error_add_contract()
    {
        $response = $this->post('/api/add/contracts');
        $response->assertStatus(400);
    }
}
