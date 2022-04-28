<?php

namespace Tests\Feature;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Load setting page without authenticating.
     *
     * @return void
     */
    public function test_the_setting_page_loads_fail_for_unauthenticated_user(): void
    {
        $this->get('/setting')
            ->assertStatus(302);
    }

    /**
     * Load setting page as authenticated user.
     *
     * @return void
     */
    public function test_the_setting_page_loads_successfully_for_authenticated_user(): void
    {
        Organization::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)->get('/setting')
            ->assertStatus(200);
    }

    /**
     * Test validation of setting publishing form with empty data.
     *
     * @return void
     */
    public function test_validation_setting_default_form_empty_data(): void
    {
        Organization::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('api/setting/store/default', [
                'default_currency'      => '',
                'default_language'        => '',
                'humanitarian'        => '',
                'hierarchy'        => '',
                'linked_data_url'        => '',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    /**
     * Test validation of setting publishing form with properly filled data.
     *
     * @return void
     */
    public function test_validation_setting_default_form_filled_data(): void
    {
        Organization::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('api/setting/store/default', [
                'default_currency'      => '',
                'default_language'        => '',
                'humanitarian'        => '',
                'hierarchy'        => '',
                'linked_data_url'        => '',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    /**
     * Test validation of setting publishing form with empty data.
     *
     * @return void
     */
    public function test_validation_setting_publishing_form_empty_data(): void
    {
        Organization::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('api/setting/store/publisher', [
                'publisher_id'      => '',
                'api_token'        => '',
            ])
            ->assertSessionHasErrors(['publisher_id', 'api_token']);
    }

    /**
     * Test validation of setting publishing form with incorrect data.
     *
     * @return void
     */
    public function test_validation_setting_publishing_form_incorrect_data(): void
    {
        Organization::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('api/setting/store/publisher', [
                'publisher_id' => 'test111111',
                'api_token' => 'asdfkjasldfjlasjddflas',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    /**
     * Test validation of setting publishing form with incorrect publisher id.
     *
     * @return void
     */
    public function test_validation_setting_publishing_form_incorrect_publisher_id(): void
    {
        Organization::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('api/setting/store/publisher', [
                'publisher_id' => 'test111111',
                'api_token' => 'asdfkjasldfjlasjddflas',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    /**
     * Test validation of setting publishing form with incorrect api token.
     *
     * @return void
     */
    public function test_validation_setting_publishing_form_incorrect_api_token(): void
    {
        Organization::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('api/setting/store/publisher', [
                'publisher_id' => env('IATI_YIPL_PUBLISHER_ID'),
                'api_token' => 'asdfkjasldfjlasjddflas',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'publisher_id',
                    'api_token',
                    'publisher_verification',
                    'token_verification',
                ],
            ])->assertJson(
                ['data' => [
                    'publisher_verification' => true,
                    'token_verification' => false,
                ]]
            );
    }

    /**
     * Test validation of setting publishing form with incorrect data.
     *
     * @return void
     */
    public function test_edit_setting_publishing_form(): void
    {
        Organization::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('api/setting/store/publisher', [
                'publisher_id' => env('IATI_YIPL_PUBLISHER_ID'),
                'api_token' => 'asdfkjasldfjlasjddflas',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'publisher_id',
                    'api_token',
                    'publisher_verification',
                    'token_verification',
                ],
            ])->assertJson(
                ['data' => [
                    'publisher_verification' => true,
                    'token_verification' => false,
                ]]
            );
    }

    /**
     * Test validation of setting publishing form.
     *
     * @return void
     */
    public function test_edit_setting_default_form_filled_data(): void
    {
        Organization::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('api/setting/store/default', [
                'default_currency'      => '',
                'default_language'        => '',
                'humanitarian'        => '',
                'hierarchy'        => '',
                'linked_data_url'        => '',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }
}
