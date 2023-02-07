<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IntegrationTest extends TestCase
{


    public function test_shouldListCompetitions()
    {
        $response = $this->get('/api/competitions');

        $response->assertStatus(200);
    }

    public function test_shouldGetCompetition()
    {
        $response = $this->get('/api/competitions/PL');

        $response->assertStatus(200);
    }

    public function test_shouldListMatches()
    {
        $response = $this->get('/api/competitions/PL/matches/' . Carbon::now()->format('Y-m-d'));

        $response->assertStatus(200);
    }
}
