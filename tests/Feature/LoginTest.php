<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Loading login page.
     *
     * @return void
     */
    public function test_the_login_page_loads_successfully()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Incorrect login.
     *
     * @return void
     */
    public function test_login_incorrect_credentials()
    {
        // $response = $this->post('/login', [
        //     'username' => 'user',
        //     'password' => 'password',
        // ]);

        // $response->assertRedirect('/');
        // $response->assertSessionHasErrors('username');
    }
}
