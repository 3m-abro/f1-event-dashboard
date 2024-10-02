<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class F1ControllerTest extends TestCase
{
    /**
     * This test function is designed to verify if the race schedule can be retrieved successfully.
     *
     * @return void
     *
     * @throws \Illuminate\Testing\AssertionFailedError
     * @throws \Exception
     */
    public function test_get_schedules()
    {
        $response = $this->get('/api/schedule');
        $response->assertStatus(200);
        $response->assertJsonStructure(['MRData']);
    }

    /**
     * This test function is designed to verify if the race standings can be retrieved successfully.
     *
     * @return void
     *
     * @throws \Illuminate\Testing\AssertionFailedError
     * @throws \Exception
     */
    public function test_get_standings()
    {
        $response = $this->get('/api/standings');
        $response->assertStatus(200);
        $response->assertJsonStructure(['MRData']);
    }

}
