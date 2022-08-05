<?php

namespace Tests\Feature;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ActivityCreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * All required fields for creating activity test.
     *
     * @return void
     */
    public function test_user_must_enter_all_fields_for_creating_activity(): void
    {
        $org = Organization::factory()->create();
        $user = User::factory()->create();
        Activity::factory()->create(['org_id' => $org->id]);

        $this->actingAs($user)->post('/activities', [])
             ->assertSessionHasErrors(['narrative', 'language', 'activity_identifier']);
    }

    /**
     * Activity identifier must be unique for a particular organization.
     *
     * @return void
     */
    public function test_activity_identifier_must_be_unique_for_organization(): void
    {
        $org = Organization::factory()->create();
        $user = User::factory()->create();
        Activity::factory()->create(['org_id' => $org->id]);

        $this->actingAs($user)->post('/activities', ['narrative' => 'Test text', 'language' => 'en', 'activity_identifier' => 'SYRZ000041', 'iati_identifier_text' => 'CR-NP-SYRZ000041'])
             ->assertStatus(302)
             ->assertSessionHasErrors('activity_identifier');
    }

    /**
     * Create Activity success test.
     *
     * @return void
     */
    public function test_successful_activity_creation(): void
    {
        $org = Organization::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)->post('/activities', [
            'narrative'            => Str::random(5),
            'language'             => 'en',
            'activity_identifier'  => '111111',
            'iati_identifier_text' => 'CR-NP-111111',
            'org_id'               => $org['id'],
        ])
             ->assertStatus(200)
             ->assertJsonStructure(['success', 'message', 'data']);
    }
}
