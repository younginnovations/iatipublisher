<?php

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Reset page load tests.
     *
     * @return void
     */
    public function test_the_reset_page_loads_successfully(): void
    {
        $this->get('/password/email')->assertStatus(200);
    }

    /**
     * Email field require test.
     *
     * @return void
     */
    public function test_user_must_enter_email(): void
    {
        $this->post('/password/email')
             ->assertStatus(302)
             ->assertSessionHasErrors(['email']);
    }

    /**
     * Email field validation test.
     *
     * @return void
     */
    public function test_user_must_enter_valid_email(): void
    {
        $this->post('/password/email', ['email' => 'test'])
             ->assertStatus(302)
             ->assertSessionHasErrors(['email']);
    }

    /**
     * Email exists test.
     *
     * @return void
     */
    public function test_user_email_exists(): void
    {
        $this->post('/password/email', ['email' => 'test@hotmail.com'])
             ->assertStatus(302)
             ->assertSessionHasErrors(['email']);
    }

    /**
     * Email recovery test.
     *
     * @return void
     */
    public function test_user_email_recovery(): void
    {
        // $role = Role::factory()->create();
        // $org = Organization::factory()->has(User::factory(['role_id'=>$role->id]))->create();

        // $this->json('post', '/password/email', ['email' => $org->user->email])
        //      ->assertStatus(200)
        //      ->assertJsonStructure(['success', 'message']);
    }
}
