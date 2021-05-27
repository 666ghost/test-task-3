<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class EndpointsTest
 * @package Tests\Feature
 */
class EndpointsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     *
     */
    public function test_api_university_list()
    {
        $response = $this->get('/api/university/find');

        $response->assertStatus(200)
            ->assertJson(['current_page' => 1])
            ->assertJsonCount(10, 'data');
    }

    /**
     *
     */
    public function test_api_university_find()
    {
        $response = $this->get('/api/university/find?search_text=42 FR');

        $response->assertStatus(200)
            ->assertJson(['current_page' => 1])
            ->assertJsonCount(1, 'data');
    }

    /**
     *
     */
    public function test_api_update_university_cache()
    {
        $response = $this->post('/api/university/update-cache/1');
        $response->assertStatus(200);
    }
}
