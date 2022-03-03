<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_home_page_loads_successfully()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
