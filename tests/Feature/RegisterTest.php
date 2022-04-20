<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * Register page load tests.
     *
     * @return void
     */
    public function test_the_register_page_loads_successfully(): void
    {
        $this->get('/register')->assertStatus(200);
    }

    /**
     * Username and password require test.
     *
     * @return void
     */
    public function test_must_enter_all_required_fields(): void
    {
        $this->post('/register')
         ->assertRedirect('/')
         ->assertSessionHasErrors(['username', 'full_name', 'email', 'publisher_id', 'password']);
    }

    /*public function test_successful_registration()
    {
      $test_data = [
        'publisher_id'          => "YIPL_test_publisher_id",
        'publisher_name'        => "YIPL_test_publisher_name",
        'country'               => null,
        'registration_agency'   => "YIPL_test_registration_agency",
        'registration_number'   => "YIPL_test_registration_number",
        'identifier'            => "YIPL_test_registration_agency-YIPL_test_registration_number",
        'status'                => 'pending',
        'username'              => "YIPL_test_username",
        'full_name'             => "YIPL_test_full_name",
        'email'                 => "yipl@email.com",
        'password'              => "demo12345",
        'password_confirmation' => "demo12345",
      ];


      $this->post('/register', $test_data)
           ->assertStatus(200)
           ->assertJsonStructure(['success' => 'User registered successfully']);
    }*/
}
