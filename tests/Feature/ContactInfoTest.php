<?php

namespace Tests\Feature;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactInfoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_contact_info_redirects_to_activity_page()
    {
        $role = Role::factory()->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();

        $activity = Activity::create([
            'org_id' => $org->id,
            'iati_identifier' => [
                'activity_identifier'             => 'SYRZ000041',
                'iati_identifier_text'            => 'CZ-ICO-25755277-SYRZ000041',
                'present_organization_identifier' => 'CZ-ICO-25755277',
            ],
            'title' => [
                [
                    'narrative' => 'DGGF Track 3',
                    'language'  => 'en',
                ],
            ],
        ]);

        $postData = [
            'contact_info'=>[
            [
                'type'=>'1',
                'telephone'=>[
                    'telephone'=>'+977-9849792399',
                ],
            ],
            ],
        ];

        $response = $this->actingAs($org->user)->put("/activity/$activity->id/contact_info", $postData);

        $response->assertRedirect("/activity/{$activity->id}");
    }
}
