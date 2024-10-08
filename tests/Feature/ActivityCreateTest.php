<?php

namespace Tests\Feature;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
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
        $role = Role::factory()->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();
        Activity::factory()->create([
            'org_id' => $org->id,
            'created_by' => $org->user->id,
            'updated_by' => $org->user->id,
        ]);
        $this->actingAs($org->user)->post('/activity', [])
            ->assertSessionHasErrors(['narrative', 'activity_identifier']);
    }

    /**
     * Activity identifier must be unique for a particular organization.
     *
     * @return void
     */
    public function test_activity_identifier_must_be_unique_for_organization(): void
    {
        $role = Role::factory()->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();
        Activity::factory()->create([
            'org_id' => $org->id,
            'created_by' => $org->user->id,
            'updated_by' => $org->user->id,
        ]);

        $this->actingAs($org->user)->post('/activity', [
            'narrative' => 'Test text',
            'language' => 'en',
            'activity_identifier' => 'SYRZ000041',
            'iati_identifier_text' => 'CR-NP-SYRZ000042',

        ])
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
        $role = Role::factory()->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();

        $this->actingAs($org->user)->post('/activity', [
            'narrative'            => Str::random(5),
            'language'             => 'en',
            'activity_identifier'  => '11111',
            'iati_identifier_text' => 'CR-NP-11111',
            'org_id'               => $org['id'],
            'created_by'           => $org->user->id,
            'updated_by'           => $org->user->id,
        ])
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'message', 'data']);
    }
}
