<?php

namespace Tests\Feature;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Class RegisterTest.
 */
class RegisterTest extends TestCase
{
    use RefreshDatabase;

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
     * All required fields for publisher test.
     *
     * @return void
     */
    public function test_publisher_must_enter_all_required_fields(): void
    {
        $this->post('/verifyPublisher')
            ->assertStatus(200)
            ->assertJsonValidationErrors(['publisher_name', 'publisher_id', 'registration_agency', 'registration_number']);
    }

    /**
     * Publisher does not exist test.
     *
     * @return void
     */
    public function test_publisher_name_does_not_exist(): void
    {
        $this->post('/verifyPublisher', [
            'publisher_name'      => 'test',
            'publisher_id'        => env('IATI_YIPL_PUBLISHER_ID'),
            'registration_agency' => env('IATI_YIPL_REGISTRATION_AGENCY'),
            'registration_number' => env('IATI_YIPL_REGISTRATION_NUMBER'),
            'identifier'          => env('IATI_YIPL_REGISTRATION_AGENCY') . '-' . env('IATI_YIPL_REGISTRATION_NUMBER'),
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'errors' => [
                    'publisher_name',
                ],
            ])
            ->assertJsonValidationErrors(['publisher_name']);
    }

    /**
     * Publisher name and id mismatch test.
     *
     * @return void
     */
    public function test_publisher_name_mismatch(): void
    {
        $this->post('/verifyPublisher', [
            'publisher_name'      => 'test101',
            'publisher_id'        => env('IATI_YIPL_PUBLISHER_ID'),
            'registration_agency' => env('IATI_YIPL_REGISTRATION_AGENCY'),
            'registration_number' => env('IATI_YIPL_REGISTRATION_NUMBER'),
            'identifier'          => env('IATI_YIPL_REGISTRATION_AGENCY') . '-' . env('IATI_YIPL_REGISTRATION_NUMBER'),
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'publisher_error',
                'errors' => [
                    'publisher_name',
                ],
            ])
            ->assertJsonValidationErrors(['publisher_name']);
    }

    /**
     * Publisher iati id mismatch test.
     *
     * @return void
     */
    public function test_publisher_iati_id_mismatch(): void
    {
        $this->post('/verifyPublisher', [
            'publisher_name'      => env('IATI_YIPL_PUBLISHER_NAME'),
            'publisher_id'        => env('IATI_YIPL_PUBLISHER_ID'),
            'identifier'          => env('IATI_YIPL_REGISTRATION_AGENCY') . '-' . env('IATI_YIPL_REGISTRATION_NUMBER'),
            'registration_agency' => 'test',
            'registration_number' => 100,
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'publisher_error',
                'errors' => [
                    'identifier',
                ],
            ])
            ->assertJsonValidationErrors(['identifier']);
    }

    /**
     * Publisher verify test.
     *
     * @return void
     */
    public function test_publisher_verified(): void
    {
        $this->post('/verifyPublisher', [
            'publisher_name'      => env('IATI_YIPL_PUBLISHER_NAME'),
            'publisher_id'        => env('IATI_YIPL_PUBLISHER_ID'),
            'registration_agency' => env('IATI_YIPL_REGISTRATION_AGENCY'),
            'registration_number' => env('IATI_YIPL_REGISTRATION_NUMBER'),
            'identifier'          => env('IATI_YIPL_REGISTRATION_AGENCY') . '-' . env('IATI_YIPL_REGISTRATION_NUMBER'),
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    /**
     * All required fields for admin test.
     *
     * @return void
     */
    public function test_admin_must_enter_all_required_fields(): void
    {
        $this->post('/register')
            ->assertStatus(200)
            ->assertJsonValidationErrors(['username', 'full_name', 'email', 'password', 'publisher_id']);
    }

    /**
     * Username `unique` test.
     *
     * @return void
     */
    public function test_username_must_be_unique(): void
    {
        Organization::factory()->create();
        $user = User::factory()->create();

        $this->post('/register', [
            'username'              => $user->username,
            'full_name'             => Str::random(5),
            'email'                 => 'test+1@gmail.com',
            'password'              => 'eyJjaXBoZXJ0ZXh0IjoieXZ1bFgyUWFJN0hrbjZTNkFQRkVrUT09IiwiaXYiOiJjZGM3ZGQyYmI1M2UxYjJkMzYzNDllNDgzNmE4MDA3NyIsInNhbHQiOiIyODE3MGE1NTdiMTM1MWVmODRkYWYyYjc2MzhhMzk1N2ZlZDI0NDUwODA5ZWQ1MDMwMzkyZTQxMDI3MWIxODI2MDkxMDc4NWE1NzJjMmNkNDIxMjg5OGNkYTRlZTc1MDBiNjdhYTNjMTI0YzIzMTY0MTY4NWE2MmZmODY2MGMwYzBlYjZmN2RiZGI5MmUzNTlmZjY2MTJlMTRkMWJkOTQyMzkyMTUwNjBiODI3YjRiN2ZhYjVjM2RhMTViYWJmNGI4NjI1ZjBiMGU5N2QxYzIyNmM2NmNiZDBmOWEyZDE3ZjY3ZWQ3MzhlZTQ0MTMxMmM0ODQyM2VjYmVlYmQwZTUwNjVmZjFmZTc4MjA2Y2UwYzk5NTBjY2E0YjNhNDI3N2U3OTEyYTZhMGQyMGEyNmU3ZjM3YTAwYmM0NGVmZmUyNTE0NmQxNDY3ZTM4MWEyZGI1ZmEzY2EwMmQwOWFiZDQ2N2Y4OTNhZTJiMGMwZjdkZWQwYTcwMzQ2YzA3MjIyNWU2NGUxMDA4YTNlZDUwMTM0NjFjYmZiMjY0YjE1M2RiNjUzMjdkMzVlZjBiZTE0MDY0NjQ2M2RiYzhiOGY5NzYyMGJjMWY2MDhiODhiMzllZDljMGRiNjU5MWZjODM3NmVkMTM0NDk0MjNmNmMyYTNiMjc1ZTNmNGY3ZWJjNmY5NCIsIml0ZXJhdGlvbnMiOjk5OX0=',
            'password_confirmation' => 'eyJjaXBoZXJ0ZXh0IjoieXZ1bFgyUWFJN0hrbjZTNkFQRkVrUT09IiwiaXYiOiJjZGM3ZGQyYmI1M2UxYjJkMzYzNDllNDgzNmE4MDA3NyIsInNhbHQiOiIyODE3MGE1NTdiMTM1MWVmODRkYWYyYjc2MzhhMzk1N2ZlZDI0NDUwODA5ZWQ1MDMwMzkyZTQxMDI3MWIxODI2MDkxMDc4NWE1NzJjMmNkNDIxMjg5OGNkYTRlZTc1MDBiNjdhYTNjMTI0YzIzMTY0MTY4NWE2MmZmODY2MGMwYzBlYjZmN2RiZGI5MmUzNTlmZjY2MTJlMTRkMWJkOTQyMzkyMTUwNjBiODI3YjRiN2ZhYjVjM2RhMTViYWJmNGI4NjI1ZjBiMGU5N2QxYzIyNmM2NmNiZDBmOWEyZDE3ZjY3ZWQ3MzhlZTQ0MTMxMmM0ODQyM2VjYmVlYmQwZTUwNjVmZjFmZTc4MjA2Y2UwYzk5NTBjY2E0YjNhNDI3N2U3OTEyYTZhMGQyMGEyNmU3ZjM3YTAwYmM0NGVmZmUyNTE0NmQxNDY3ZTM4MWEyZGI1ZmEzY2EwMmQwOWFiZDQ2N2Y4OTNhZTJiMGMwZjdkZWQwYTcwMzQ2YzA3MjIyNWU2NGUxMDA4YTNlZDUwMTM0NjFjYmZiMjY0YjE1M2RiNjUzMjdkMzVlZjBiZTE0MDY0NjQ2M2RiYzhiOGY5NzYyMGJjMWY2MDhiODhiMzllZDljMGRiNjU5MWZjODM3NmVkMTM0NDk0MjNmNmMyYTNiMjc1ZTNmNGY3ZWJjNmY5NCIsIml0ZXJhdGlvbnMiOjk5OX0=',
            'publisher_id'          => Str::random(5),
        ])
            ->assertStatus(200)
            ->assertJsonValidationErrors(['username']);
    }

    /**
     * Email unique test.
     *
     * @return void
     */
    public function test_email_must_be_unique(): void
    {
        Organization::factory()->create();
        $user = User::factory()->create();

        $this->post('/register', [
            'username'              => Str::random(5),
            'full_name'             => Str::random(5),
            'email'                 => $user->email,
            'password'              => 'eyJjaXBoZXJ0ZXh0IjoieXZ1bFgyUWFJN0hrbjZTNkFQRkVrUT09IiwiaXYiOiJjZGM3ZGQyYmI1M2UxYjJkMzYzNDllNDgzNmE4MDA3NyIsInNhbHQiOiIyODE3MGE1NTdiMTM1MWVmODRkYWYyYjc2MzhhMzk1N2ZlZDI0NDUwODA5ZWQ1MDMwMzkyZTQxMDI3MWIxODI2MDkxMDc4NWE1NzJjMmNkNDIxMjg5OGNkYTRlZTc1MDBiNjdhYTNjMTI0YzIzMTY0MTY4NWE2MmZmODY2MGMwYzBlYjZmN2RiZGI5MmUzNTlmZjY2MTJlMTRkMWJkOTQyMzkyMTUwNjBiODI3YjRiN2ZhYjVjM2RhMTViYWJmNGI4NjI1ZjBiMGU5N2QxYzIyNmM2NmNiZDBmOWEyZDE3ZjY3ZWQ3MzhlZTQ0MTMxMmM0ODQyM2VjYmVlYmQwZTUwNjVmZjFmZTc4MjA2Y2UwYzk5NTBjY2E0YjNhNDI3N2U3OTEyYTZhMGQyMGEyNmU3ZjM3YTAwYmM0NGVmZmUyNTE0NmQxNDY3ZTM4MWEyZGI1ZmEzY2EwMmQwOWFiZDQ2N2Y4OTNhZTJiMGMwZjdkZWQwYTcwMzQ2YzA3MjIyNWU2NGUxMDA4YTNlZDUwMTM0NjFjYmZiMjY0YjE1M2RiNjUzMjdkMzVlZjBiZTE0MDY0NjQ2M2RiYzhiOGY5NzYyMGJjMWY2MDhiODhiMzllZDljMGRiNjU5MWZjODM3NmVkMTM0NDk0MjNmNmMyYTNiMjc1ZTNmNGY3ZWJjNmY5NCIsIml0ZXJhdGlvbnMiOjk5OX0=',
            'password_confirmation' => 'eyJjaXBoZXJ0ZXh0IjoieXZ1bFgyUWFJN0hrbjZTNkFQRkVrUT09IiwiaXYiOiJjZGM3ZGQyYmI1M2UxYjJkMzYzNDllNDgzNmE4MDA3NyIsInNhbHQiOiIyODE3MGE1NTdiMTM1MWVmODRkYWYyYjc2MzhhMzk1N2ZlZDI0NDUwODA5ZWQ1MDMwMzkyZTQxMDI3MWIxODI2MDkxMDc4NWE1NzJjMmNkNDIxMjg5OGNkYTRlZTc1MDBiNjdhYTNjMTI0YzIzMTY0MTY4NWE2MmZmODY2MGMwYzBlYjZmN2RiZGI5MmUzNTlmZjY2MTJlMTRkMWJkOTQyMzkyMTUwNjBiODI3YjRiN2ZhYjVjM2RhMTViYWJmNGI4NjI1ZjBiMGU5N2QxYzIyNmM2NmNiZDBmOWEyZDE3ZjY3ZWQ3MzhlZTQ0MTMxMmM0ODQyM2VjYmVlYmQwZTUwNjVmZjFmZTc4MjA2Y2UwYzk5NTBjY2E0YjNhNDI3N2U3OTEyYTZhMGQyMGEyNmU3ZjM3YTAwYmM0NGVmZmUyNTE0NmQxNDY3ZTM4MWEyZGI1ZmEzY2EwMmQwOWFiZDQ2N2Y4OTNhZTJiMGMwZjdkZWQwYTcwMzQ2YzA3MjIyNWU2NGUxMDA4YTNlZDUwMTM0NjFjYmZiMjY0YjE1M2RiNjUzMjdkMzVlZjBiZTE0MDY0NjQ2M2RiYzhiOGY5NzYyMGJjMWY2MDhiODhiMzllZDljMGRiNjU5MWZjODM3NmVkMTM0NDk0MjNmNmMyYTNiMjc1ZTNmNGY3ZWJjNmY5NCIsIml0ZXJhdGlvbnMiOjk5OX0=',
            'publisher_id'          => Str::random(5),
        ])
            ->assertStatus(200)
            ->assertJsonValidationErrors(['email']);
    }

    /**
     * Password confirm test.
     *
     * @return void
     */
    public function test_password_confirm_must_be_same(): void
    {
        Organization::factory()->create();
        User::factory()->create();

        $this->post('/register', [
            'username'              => Str::random(5),
            'full_name'             => Str::random(5),
            'email'                 => 'test+1@gmail.com',
            'password'              => 'eyJjaXBoZXJ0ZXh0IjoieXZ1bFgyUWFJN0hrbjZTNkFQRkVrUT09IiwiaXYiOiJjZGM3ZGQyYmI1M2UxYjJkMzYzNDllNDgzNmE4MDA3NyIsInNhbHQiOiIyODE3MGE1NTdiMTM1MWVmODRkYWYyYjc2MzhhMzk1N2ZlZDI0NDUwODA5ZWQ1MDMwMzkyZTQxMDI3MWIxODI2MDkxMDc4NWE1NzJjMmNkNDIxMjg5OGNkYTRlZTc1MDBiNjdhYTNjMTI0YzIzMTY0MTY4NWE2MmZmODY2MGMwYzBlYjZmN2RiZGI5MmUzNTlmZjY2MTJlMTRkMWJkOTQyMzkyMTUwNjBiODI3YjRiN2ZhYjVjM2RhMTViYWJmNGI4NjI1ZjBiMGU5N2QxYzIyNmM2NmNiZDBmOWEyZDE3ZjY3ZWQ3MzhlZTQ0MTMxMmM0ODQyM2VjYmVlYmQwZTUwNjVmZjFmZTc4MjA2Y2UwYzk5NTBjY2E0YjNhNDI3N2U3OTEyYTZhMGQyMGEyNmU3ZjM3YTAwYmM0NGVmZmUyNTE0NmQxNDY3ZTM4MWEyZGI1ZmEzY2EwMmQwOWFiZDQ2N2Y4OTNhZTJiMGMwZjdkZWQwYTcwMzQ2YzA3MjIyNWU2NGUxMDA4YTNlZDUwMTM0NjFjYmZiMjY0YjE1M2RiNjUzMjdkMzVlZjBiZTE0MDY0NjQ2M2RiYzhiOGY5NzYyMGJjMWY2MDhiODhiMzllZDljMGRiNjU5MWZjODM3NmVkMTM0NDk0MjNmNmMyYTNiMjc1ZTNmNGY3ZWJjNmY5NCIsIml0ZXJhdGlvbnMiOjk5OX0=',
            'password_confirmation' => 'eyJjaXBoZXJ0ZXh0Ijoid3o4Y0czRU0ydFhocjVtL29nNnNzQT09IiwiaXYiOiI3NGNkNWI5NDFmZWQ3M2Y0ZGUwOGNmYTNmOGNmOWY3ZSIsInNhbHQiOiJiZjU2YjZlMzBiNGExMmZiNjc3NGQwOTI3ZjExNjVkYzk4MjhmNTY2YmE3OTEzZGFjNjE0NDEyODMyOWE3MTVhNTU3Y2NhMGE4NWJlNWRhNTgxY2Y2OTRmNjUxMGE3MzQ3ZmU5NjE1Njc1ZThkMDc5NDc3MWZjYjU3MDgyMGU1YjhkOGViMzY2ZGJlOWM3NDUzNTU5YjZmMDA2MDgwOGY5ZGZjZGJjOGU5OTE2NzdlOWFiN2VhYmIyNmFjZjBkMmZkYTRiZGMwOGIzNGE2YzBhMjU3ZmRjOWE5ZTljNjYyYzc5MjZlZmNiZDg3M2Q0MWU5YTg0YmI5YWI4ZmNjYWUxMmYwNDgyMzYxODVmMzNkYzMyN2JhZDNhNWY2MmIzN2FmZjlmOTUxMzkyMDIzMmZhMzg3YzExODE1NDczOTlhODFkMGNjYjE2NWJlZDc0OGI1MmU0ZDQ3OTEyYWVjMGJkNTFjODMzM2Q5MzFhOGU3NGQ4NmRlZDdhZDAwYTMzMDg0MmVhMjhjOTA5M2RiYTJmNzBiZmRkMzNlMTU5MDUzOGE1MGE1YTcyNjA1ZTIyYTg4YzBhYmJkMTY2ZmNiYjI4ZjdlNTkzMWJhM2E5OTdhODIwMDQwMjc4NmJkNDhlMTBiMzFmMGU3ZDAwNjc3ZjNlZmUzNzQ4NmQ2YTQyYWI4NiIsIml0ZXJhdGlvbnMiOjk5OX0=',
            'publisher_id'          => Str::random(5),
        ])
            ->assertStatus(200)
            ->assertJsonValidationErrors(['password']);
    }

    /**
     * Register success test.
     *
     * @return void
     */
    public function test_successful_registration(): void
    {
        Role::factory()->create();

        $this->post('/register', [
            'publisher_id'          => Str::random(5),
            'publisher_name'        => Str::random(5),
            'country'               => null,
            'registration_agency'   => 'NP-SWC',
            'registration_number'   => 10101,
            'identifier'            => Str::random(5),
            'status'                => 'pending',
            'username'              => Str::random(5),
            'full_name'             => Str::random(5),
            'email'                 => 'test+1@gmail.com',
            'password'              => 'eyJjaXBoZXJ0ZXh0IjoieXZ1bFgyUWFJN0hrbjZTNkFQRkVrUT09IiwiaXYiOiJjZGM3ZGQyYmI1M2UxYjJkMzYzNDllNDgzNmE4MDA3NyIsInNhbHQiOiIyODE3MGE1NTdiMTM1MWVmODRkYWYyYjc2MzhhMzk1N2ZlZDI0NDUwODA5ZWQ1MDMwMzkyZTQxMDI3MWIxODI2MDkxMDc4NWE1NzJjMmNkNDIxMjg5OGNkYTRlZTc1MDBiNjdhYTNjMTI0YzIzMTY0MTY4NWE2MmZmODY2MGMwYzBlYjZmN2RiZGI5MmUzNTlmZjY2MTJlMTRkMWJkOTQyMzkyMTUwNjBiODI3YjRiN2ZhYjVjM2RhMTViYWJmNGI4NjI1ZjBiMGU5N2QxYzIyNmM2NmNiZDBmOWEyZDE3ZjY3ZWQ3MzhlZTQ0MTMxMmM0ODQyM2VjYmVlYmQwZTUwNjVmZjFmZTc4MjA2Y2UwYzk5NTBjY2E0YjNhNDI3N2U3OTEyYTZhMGQyMGEyNmU3ZjM3YTAwYmM0NGVmZmUyNTE0NmQxNDY3ZTM4MWEyZGI1ZmEzY2EwMmQwOWFiZDQ2N2Y4OTNhZTJiMGMwZjdkZWQwYTcwMzQ2YzA3MjIyNWU2NGUxMDA4YTNlZDUwMTM0NjFjYmZiMjY0YjE1M2RiNjUzMjdkMzVlZjBiZTE0MDY0NjQ2M2RiYzhiOGY5NzYyMGJjMWY2MDhiODhiMzllZDljMGRiNjU5MWZjODM3NmVkMTM0NDk0MjNmNmMyYTNiMjc1ZTNmNGY3ZWJjNmY5NCIsIml0ZXJhdGlvbnMiOjk5OX0=',
            'password_confirmation' => 'eyJjaXBoZXJ0ZXh0IjoieXZ1bFgyUWFJN0hrbjZTNkFQRkVrUT09IiwiaXYiOiJjZGM3ZGQyYmI1M2UxYjJkMzYzNDllNDgzNmE4MDA3NyIsInNhbHQiOiIyODE3MGE1NTdiMTM1MWVmODRkYWYyYjc2MzhhMzk1N2ZlZDI0NDUwODA5ZWQ1MDMwMzkyZTQxMDI3MWIxODI2MDkxMDc4NWE1NzJjMmNkNDIxMjg5OGNkYTRlZTc1MDBiNjdhYTNjMTI0YzIzMTY0MTY4NWE2MmZmODY2MGMwYzBlYjZmN2RiZGI5MmUzNTlmZjY2MTJlMTRkMWJkOTQyMzkyMTUwNjBiODI3YjRiN2ZhYjVjM2RhMTViYWJmNGI4NjI1ZjBiMGU5N2QxYzIyNmM2NmNiZDBmOWEyZDE3ZjY3ZWQ3MzhlZTQ0MTMxMmM0ODQyM2VjYmVlYmQwZTUwNjVmZjFmZTc4MjA2Y2UwYzk5NTBjY2E0YjNhNDI3N2U3OTEyYTZhMGQyMGEyNmU3ZjM3YTAwYmM0NGVmZmUyNTE0NmQxNDY3ZTM4MWEyZGI1ZmEzY2EwMmQwOWFiZDQ2N2Y4OTNhZTJiMGMwZjdkZWQwYTcwMzQ2YzA3MjIyNWU2NGUxMDA4YTNlZDUwMTM0NjFjYmZiMjY0YjE1M2RiNjUzMjdkMzVlZjBiZTE0MDY0NjQ2M2RiYzhiOGY5NzYyMGJjMWY2MDhiODhiMzllZDljMGRiNjU5MWZjODM3NmVkMTM0NDk0MjNmNmMyYTNiMjc1ZTNmNGY3ZWJjNmY5NCIsIml0ZXJhdGlvbnMiOjk5OX0=',
        ])->assertJsonStructure([
            'success',
            // 'message',
        ])->assertJson(
            [
               'success' => true,
           ]
        );
    }
}
