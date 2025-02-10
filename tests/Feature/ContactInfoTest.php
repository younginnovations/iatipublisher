<?php

namespace Tests\Feature;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
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
            'org_id'          => $org->id,
            'iati_identifier' => [
                'activity_identifier'             => 'SYRZ000041',
                'iati_identifier_text'            => 'CZ-ICO-25755277-SYRZ000041',
                'present_organization_identifier' => 'CZ-ICO-25755277',
            ],
            'title'           => [
                [
                    'narrative' => 'DGGF Track 3',
                    'language'  => 'en',
                ],
            ],
        ]);

        $postData = [
            'contact_info' => [
                [
                    'type'      => '1',
                    'telephone' => [
                        'telephone' => '+9779849792399',
                    ],
                ],
            ],
        ];

        $response = $this->actingAs($org->user)->put("/activity/$activity->id/contact_info", $postData);
        $response->assertStatus(302);

        $response->assertRedirect("/activity/{$activity->id}");
    }

    public function test_if_redirects_incase_contact_info_fails_to_save_contact_info()
    {
        $role = Role::factory()->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();

        $activity = Activity::create([
            'org_id'          => $org->id,
            'iati_identifier' => [
                'activity_identifier'             => 'SYRZ000041',
                'iati_identifier_text'            => 'CZ-ICO-25755277-SYRZ000041',
                'present_organization_identifier' => 'CZ-ICO-25755277',
            ],
            'title'           => [
                [
                    'narrative' => 'DGGF Track 3',
                    'language'  => 'en',
                ],
            ],
        ]);

        $postData = [
            'contact_info' => [
                [
                    'type'      => '1',
                    'telephone' => [
                        'telephone' => '+977-9849792399',
                    ],
                ],
            ],
        ];

        $validator = Validator::make($postData, [
            'contact_info.*.telephone.telephone' => ['nullable', 'regex:/^(?:\+977\d{10}|\d{10}|\d{4}-\d{2}-\d{4}|\(\+977\)\d{10})$/', 'min:7', 'max:20'],
        ]);

        $this->assertTrue($validator->fails());

        Session::start();
        $this->withSession(['_previous' => ['url' => "/activity/$activity->id"]]);

        $response = $this->actingAs($org->user)
            ->from("/activity/$activity->id")
            ->put("/activity/$activity->id/contact_info", $postData);

        $response->assertRedirect("/activity/$activity->id");
    }
}
