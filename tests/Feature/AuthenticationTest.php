<?php

namespace Tests\Feature;

use App\IATI\Models\Organization\Organization;
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
        $this->post('/login', ['password' => 'eyJjaXBoZXJ0ZXh0IjoieXZ1bFgyUWFJN0hrbjZTNkFQRkVrUT09IiwiaXYiOiJjZGM3ZGQyYmI1M2UxYjJkMzYzNDllNDgzNmE4MDA3NyIsInNhbHQiOiIyODE3MGE1NTdiMTM1MWVmODRkYWYyYjc2MzhhMzk1N2ZlZDI0NDUwODA5ZWQ1MDMwMzkyZTQxMDI3MWIxODI2MDkxMDc4NWE1NzJjMmNkNDIxMjg5OGNkYTRlZTc1MDBiNjdhYTNjMTI0YzIzMTY0MTY4NWE2MmZmODY2MGMwYzBlYjZmN2RiZGI5MmUzNTlmZjY2MTJlMTRkMWJkOTQyMzkyMTUwNjBiODI3YjRiN2ZhYjVjM2RhMTViYWJmNGI4NjI1ZjBiMGU5N2QxYzIyNmM2NmNiZDBmOWEyZDE3ZjY3ZWQ3MzhlZTQ0MTMxMmM0ODQyM2VjYmVlYmQwZTUwNjVmZjFmZTc4MjA2Y2UwYzk5NTBjY2E0YjNhNDI3N2U3OTEyYTZhMGQyMGEyNmU3ZjM3YTAwYmM0NGVmZmUyNTE0NmQxNDY3ZTM4MWEyZGI1ZmEzY2EwMmQwOWFiZDQ2N2Y4OTNhZTJiMGMwZjdkZWQwYTcwMzQ2YzA3MjIyNWU2NGUxMDA4YTNlZDUwMTM0NjFjYmZiMjY0YjE1M2RiNjUzMjdkMzVlZjBiZTE0MDY0NjQ2M2RiYzhiOGY5NzYyMGJjMWY2MDhiODhiMzllZDljMGRiNjU5MWZjODM3NmVkMTM0NDk0MjNmNmMyYTNiMjc1ZTNmNGY3ZWJjNmY5NCIsIml0ZXJhdGlvbnMiOjk5OX0='])
            ->assertRedirect('/')
            ->assertSessionHasErrors('username');
    }

    /**
     * Invalid credentials login test.
     *
     * @return void
     */
    public function test_invalid_credentials(): void
    {
        $this->post('/login', ['username' => 'admin123', 'password' => 'eyJjaXBoZXJ0ZXh0IjoieXZ1bFgyUWFJN0hrbjZTNkFQRkVrUT09IiwiaXYiOiJjZGM3ZGQyYmI1M2UxYjJkMzYzNDllNDgzNmE4MDA3NyIsInNhbHQiOiIyODE3MGE1NTdiMTM1MWVmODRkYWYyYjc2MzhhMzk1N2ZlZDI0NDUwODA5ZWQ1MDMwMzkyZTQxMDI3MWIxODI2MDkxMDc4NWE1NzJjMmNkNDIxMjg5OGNkYTRlZTc1MDBiNjdhYTNjMTI0YzIzMTY0MTY4NWE2MmZmODY2MGMwYzBlYjZmN2RiZGI5MmUzNTlmZjY2MTJlMTRkMWJkOTQyMzkyMTUwNjBiODI3YjRiN2ZhYjVjM2RhMTViYWJmNGI4NjI1ZjBiMGU5N2QxYzIyNmM2NmNiZDBmOWEyZDE3ZjY3ZWQ3MzhlZTQ0MTMxMmM0ODQyM2VjYmVlYmQwZTUwNjVmZjFmZTc4MjA2Y2UwYzk5NTBjY2E0YjNhNDI3N2U3OTEyYTZhMGQyMGEyNmU3ZjM3YTAwYmM0NGVmZmUyNTE0NmQxNDY3ZTM4MWEyZGI1ZmEzY2EwMmQwOWFiZDQ2N2Y4OTNhZTJiMGMwZjdkZWQwYTcwMzQ2YzA3MjIyNWU2NGUxMDA4YTNlZDUwMTM0NjFjYmZiMjY0YjE1M2RiNjUzMjdkMzVlZjBiZTE0MDY0NjQ2M2RiYzhiOGY5NzYyMGJjMWY2MDhiODhiMzllZDljMGRiNjU5MWZjODM3NmVkMTM0NDk0MjNmNmMyYTNiMjc1ZTNmNGY3ZWJjNmY5NCIsIml0ZXJhdGlvbnMiOjk5OX0='])
            ->assertRedirect('/')
            ->assertSessionHasErrors('username');
    }

    /*
     * Login success test.
     *
     * @return void
     */
    public function test_successful_login(): void
    {
        Organization::factory()->create();
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'eyJjaXBoZXJ0ZXh0IjoieXZ1bFgyUWFJN0hrbjZTNkFQRkVrUT09IiwiaXYiOiJjZGM3ZGQyYmI1M2UxYjJkMzYzNDllNDgzNmE4MDA3NyIsInNhbHQiOiIyODE3MGE1NTdiMTM1MWVmODRkYWYyYjc2MzhhMzk1N2ZlZDI0NDUwODA5ZWQ1MDMwMzkyZTQxMDI3MWIxODI2MDkxMDc4NWE1NzJjMmNkNDIxMjg5OGNkYTRlZTc1MDBiNjdhYTNjMTI0YzIzMTY0MTY4NWE2MmZmODY2MGMwYzBlYjZmN2RiZGI5MmUzNTlmZjY2MTJlMTRkMWJkOTQyMzkyMTUwNjBiODI3YjRiN2ZhYjVjM2RhMTViYWJmNGI4NjI1ZjBiMGU5N2QxYzIyNmM2NmNiZDBmOWEyZDE3ZjY3ZWQ3MzhlZTQ0MTMxMmM0ODQyM2VjYmVlYmQwZTUwNjVmZjFmZTc4MjA2Y2UwYzk5NTBjY2E0YjNhNDI3N2U3OTEyYTZhMGQyMGEyNmU3ZjM3YTAwYmM0NGVmZmUyNTE0NmQxNDY3ZTM4MWEyZGI1ZmEzY2EwMmQwOWFiZDQ2N2Y4OTNhZTJiMGMwZjdkZWQwYTcwMzQ2YzA3MjIyNWU2NGUxMDA4YTNlZDUwMTM0NjFjYmZiMjY0YjE1M2RiNjUzMjdkMzVlZjBiZTE0MDY0NjQ2M2RiYzhiOGY5NzYyMGJjMWY2MDhiODhiMzllZDljMGRiNjU5MWZjODM3NmVkMTM0NDk0MjNmNmMyYTNiMjc1ZTNmNGY3ZWJjNmY5NCIsIml0ZXJhdGlvbnMiOjk5OX0=',
        ]);

        $response->assertRedirect('/activities');
    }
}
