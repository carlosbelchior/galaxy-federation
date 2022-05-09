<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_reports_transactions()
    {
        $response = $this->get('/api/reports/transactions');
        $response->assertStatus(200);
    }
}
