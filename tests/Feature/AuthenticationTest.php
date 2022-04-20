<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * Login page load tests.
     *
     * @return void
     */
    public function test_the_login_page_loads_successfully(): void
    {
        $this->get('/')->assertStatus(200);
    }

    /**
     * Username and password require test.
     *
     * @return void
     */
    public function test_must_enter_username_and_password(): void
    {
        $this->post('/login')
             ->assertRedirect('/')
             ->assertSessionHasErrors('username')
             ->assertSessionHasErrors('password');
    }

    /**
     * Password require test.
     *
     * @return void
     */
    public function test_must_enter_password(): void
    {
        $this->post('/login', ['username' => 'manish@gmail.com'])
             ->assertRedirect('/')
             ->assertSessionHasErrors('password');
    }

    /**
     * Username require test.
     *
     * @return void
     */
    public function test_must_enter_email(): void
    {
        $this->post('/login', ['password' => 'password'])
             ->assertRedirect('/')
             ->assertSessionHasErrors('username');
    }

    /**
     * Login success test.
     *
     * @return void
     */
    public function test_invalid_credentials(): void
    {
        $this->post('/login', ['username' => 'admin123', 'password' => 'password123'])
             ->assertRedirect('/')
             ->assertSessionHasErrors('username');
    }

    /**
     * Login success test.
     *
     * @return void
     */
    public function test_successful_login(): void
    {
        $response = $this->post('/login', [
             'username' => 'admin',
             'password' => 'password',
         ]);

        $response->assertRedirect('/activities');
    }
}
