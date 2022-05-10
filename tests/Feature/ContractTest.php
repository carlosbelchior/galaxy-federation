<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContractTest extends TestCase
{
    // Test accept contract - ok
    public function test_ok_accept_contract()
    {
        $response = $this->get('/contract/accept/1');
        $response->assertStatus(200);
    }

    // Test finish contract - ok
    public function test_ok_finish_contract()
    {
        $response = $this->get('/contract/finish/1');
        $response->assertStatus(200);
    }

    // Test accept contract - error
    public function test_error_accept_contract()
    {
        $response = $this->get('/contract/accept');
        $response->assertStatus(400);
    }

    // Test finish contract - error
    public function test_error_finish_contract()
    {
        $response = $this->get('/contract/finish');
        $response->assertStatus(400);
    }
}
