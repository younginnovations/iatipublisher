<?php

namespace Tests\Feature\PageLoad;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneralPageLoad extends TestCase
{
    use RefreshDatabase;

    /**
     * Ensure 200 status code on page load.
     *
     * @return void
     * @test
     * @dataProvider general_page_url
     */
    public function general_page_load_test($route)
    {
        $role = Role::factory()->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();
        $this->actingAs($org->user);
        $response = $this->get(route($route));
        $response->assertStatus(200);
    }

    /**
     * Provide general page data.
     *
     * @return array[]
     */
    public function general_page_url(): array
    {
        return [
            ['admin.setting.index'],
            ['admin.import.index'],
            ['admin.user.index'],
            ['admin.user.profile'],
        ];
    }
}
