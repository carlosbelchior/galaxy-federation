<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelTest extends TestCase
{
    // Test new travel - ok
    public function test_ok_travel()
    {
        $response = $this->post('/api/travel/new');
        $response->assertStatus(200);
    }

    // Test new travel - error
    public function test_error_travel()
    {
        $response = $this->post('/api/travel/new');
        $response->assertStatus(400);
    }
}
