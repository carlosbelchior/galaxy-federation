<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReportsTest extends TestCase
{
    // Report resources by planet
    public function test_reports_resource_planet()
    {
        $response = $this->get('/api/reports/resource-planet');
        $response->assertStatus(200);
    }

    // Report resources by pilot
    public function test_reports_resource_pilot()
    {
        $response = $this->get('/api/reports/resource-pilot');
        $response->assertStatus(200);
    }

    // Report transactions
    public function test_reports_transactions()
    {
        $response = $this->get('/api/reports/transactions');
        $response->assertStatus(200);
    }
}
