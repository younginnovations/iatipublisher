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
    public function test_prevent_login_attempt_with_empty_fields(): void
    {
        $this->post('/login')
            ->assertRedirect('/')
            ->assertSessionHasErrors('emailOrUsername')
            ->assertSessionHasErrors('password');
    }

    /**
     * Password require test.
     *
     * @return void
     */
    public function test_must_enter_password(): void
    {
        $this->post('/login', ['emailOrUsername' => 'manish@gmail.com'])
            ->assertRedirect('/')
            ->assertSessionHasErrors('password');
    }

    /**
     *  Username require test.
     *
     * @return void
     * @throws \Exception
     */
    public function test_must_enter_email_or_username(): void
    {
        $this->post('/login', ['password' => 'password'])
            ->assertRedirect('/')
            ->assertSessionHasErrors('emailOrUsername');
    }

    /**
     * Invalid credentials login test.
     *
     * @return void
     * @throws \Exception
     */
    public function test_invalid_credentials(): void
    {
        $this->post('/login', ['emailOrUsername' => 'admin123', 'password' => 'password'])
            ->assertRedirect('/')
            ->assertSessionHasErrors('emailOrUsername');
    }

    /**
     * Login success test.
     *
     * @return void
     * @throws \Exception
     */
    public function test_successful_login_with_username_and_password(): void
    {
        $role = Role::factory()->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();

        $response = $this->post('/login', [
            'emailOrUsername' => $org->user->username,
            'password' => 'password',
        ]);

        $response->assertRedirect('/activities');
    }

    public function test_successful_login_with_email_and_password(): void
    {
        $role = Role::factory()->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();

        $response = $this->post('/login', [
            'emailOrUsername' => $org->user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/activities');
    }

    public function test_successful_login_with_different_email_case(): void
    {
        $role = Role::factory()->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();

        $uppercasedEmail = strtoupper($org->user->email);

        $response = $this->post('/login', [
            'emailOrUsername' => $uppercasedEmail,
            'password' => 'password',
        ]);

        $response->assertRedirect('/activities');
    }
}
