<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsTest extends TestCase
{
    // Report resources by planet - ok
    public function test_ok_reports_resource_planet()
    {
        $response = $this->get('/api/reports/resource-planet');
        $response->assertStatus(200);
    }

    // Report resources by planet - error
    public function test_error_reports_resource_planet()
    {
        $response = $this->post('/api/reports/resource-planet');
        $response->assertStatus(405);
    }

    // Report resources by pilot - ok
    public function test_ok_reports_resource_pilot()
    {
        $response = $this->get('/api/reports/resource-pilot');
        $response->assertStatus(200);
    }

    // Report resources by pilot - error
    public function test_error_reports_resource_pilot()
    {
        $response = $this->post('/api/reports/resource-pilot');
        $response->assertStatus(405);
    }

    // Report transactions - ok
    public function test_ok_reports_transactions()
    {
        $response = $this->get('/api/reports/transactions');
        $response->assertStatus(200);
    }

    // Report transactions - ok
    public function test_error_reports_transactions()
    {
        $response = $this->post('/api/reports/transactions');
        $response->assertStatus(405);
    }

    // Report pilots - ok
    public function test_ok_pilots_transactions()
    {
        $response = $this->get('/api/reports/pilots');
        $response->assertStatus(200);
    }

    // Report pilots - ok
    public function test_error_pilots_transactions()
    {
        $response = $this->post('/api/reports/pilots');
        $response->assertStatus(405);
    }

    // Report ships - ok
    public function test_ok_ships_transactions()
    {
        $response = $this->get('/api/reports/ships');
        $response->assertStatus(200);
    }

    // Report ships - ok
    public function test_error_ships_transactions()
    {
        $response = $this->post('/api/reports/ships');
        $response->assertStatus(405);
    }

    // Report travels - ok
    public function test_ok_travels_transactions()
    {
        $response = $this->get('/api/reports/travels');
        $response->assertStatus(200);
    }

    // Report travels - ok
    public function test_error_travels_transactions()
    {
        $response = $this->post('/api/reports/travels');
        $response->assertStatus(405);
    }
}
