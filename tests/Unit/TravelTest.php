<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelTest extends TestCase
{
    // Test new travel - ok
    public function test_ok_travel()
    {
        $response = $this->post('/api/travels/new', [
            'pilot_certification' => 1234567,
            'ship' => 1,
            'origin_planet' => 'Aqua',
            'destination_planet' => 'Calas'
        ]);
        $response->assertStatus(200);
    }

    // Test new travel - error
    public function test_error_travel()
    {
        $response = $this->post('/api/travels/new');
        $response->assertStatus(400);
    }

    // Test new travel - error
    public function test_error_method_travel()
    {
        $response = $this->get('/api/travels/new');
        $response->assertStatus(405);
    }
}
