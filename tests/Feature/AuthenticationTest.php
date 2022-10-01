<?php

namespace Tests\Feature;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AuthenticationTest.
 */
class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

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
        $this->post('/login', ['password' => customEncryptString('password')])
            ->assertRedirect('/')
            ->assertSessionHasErrors('username');
    }

    /*
     * Invalid credentials login test.
     *
     * @return void
     */
    // public function test_invalid_credentials(): void
    // {
    //     $this->post('/login', ['username' => 'admin123', 'password' => customEncryptString('password')])
    //         ->assertRedirect('/')
    //         ->assertSessionHasErrors('username');
    // }

    /*
     * Login success test.
     *
     * @return void
     */
    // public function test_successful_login(): void
    // {
    //     $role = Role::factory()->create();
    //     $org = Organization::factory()->has(User::factory(['role_id'=>$role->id]))->create();

    //     $response = $this->post('/login', [
    //         'username' => $org->user->username,
    //         'password' => customEncryptString('password'),
    //     ]);

    //     $response->assertRedirect('/activities');
    // }
}
