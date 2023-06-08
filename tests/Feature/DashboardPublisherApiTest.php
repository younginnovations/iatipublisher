<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
 * Class DashboardPublisherApiTest.
 */
class DashboardPublisherApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    private User $user;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getSuperadmin();
    }

    /**
     * Test status 200 and data structure in dashboard data grouped by type api.
     *
     * @return void
     */
    public function test_publisher_grouped_by_type()
    {
        $response = $this->actingAs($this->user)->get(url('/dashboard/publisher/type?startDate=2010-01-31&endDate=' . Carbon::now()->format('Y-m-d')));

        $response->assertStatus(200)->assertJsonStructure(['publisher_type'=>[], 'codelist'=>[]], $response['data']);
    }

    /**
     * Test status 200 and data structure in dashboard data grouped by status api.
     *
     * @return void
     */
    public function test_publisher_grouped_by_stats()
    {
        $response = $this->actingAs($this->user)->get(url('/dashboard/publisher/stats'));

        $response->assertStatus(200)->assertJsonStructure(['totalCount'=>[], 'lastRegisteredPublisher'=>[]], $response['data']);
    }

    /**
     * Test status 200 and data structure in dashboard data grouped by data_licence api.
     *
     * @return void
     */
    public function test_publisher_grouped_by_data_license()
    {
        $response = $this->actingAs($this->user)->get(url('/dashboard/publisher/data-license'));

        $response->assertStatus(200)->assertJsonStructure(['data_license'=>[], 'codelist'=>[]], $response['data']);
    }

    /**
     * Test status 200 and data structure in dashboard data grouped by country api.
     *
     * @return void
     */
    public function test_publisher_grouped_by_country()
    {
        $response = $this->actingAs($this->user)->get(url('/dashboard/publisher/country'));

        $response->assertStatus(200)->assertJsonStructure(['country'=>[], 'codelist'=>[]], $response['data']);
    }

    /**
     * Test status 200 and data structure in dashboard data grouped by registration type api.
     *
     * @return void
     */
    public function test_publisher_grouped_by_registration_type()
    {
        //$response = $this->actingAs($this->user)->get(url('/dashboard/publisher/registration-type'));

        //Review this @momik. method doesn't exist in DashboardController.
        //$response->assertStatus(200)->assertJsonStructure(['totalCount'=>[], 'lastRegisteredPublisher'=>[]], $response['data']);
    }

    /**
     * Test status 200 and data structure in dashboard data grouped by setup api.
     *
     * @return void
     */
    public function test_publisher_grouped_by_setup()
    {
        $response = $this->actingAs($this->user)->get(url('/dashboard/publisher/setup'));

        $response->assertStatus(200)->assertJsonStructure(['completeSetup'=>[], 'incompleteSetup'=>[]], $response['data']);
    }

    /**
     * Test status 200 and data structure in dashboard data grouped by registration count api.
     *
     * @return void
     */
    public function test_publisher_grouped_by_registration_count()
    {
        $response = $this->actingAs($this->user)->get(url('/dashboard/publisher/registration-count'));

        $response->assertStatus(200)->assertJsonStructure(['created_at'=>[]], $response['data']);
    }

    /**
     * Test status 200 at download endpoint.
     *
     * @return void
     */
    public function test_publisher_grouped_by_download()
    {
        // Review this @momik.
        // Cant assert 200 because it's not json response.
        // but why is response empty array and not true/false or array of org data.
        // $response = $this->actingAs($this->user)->get(url('/dashboard/publisher/download'));
        //
        // $response->assertStatus(200);
    }

    /**
     * @return User
     */
    private function getSuperadmin(): User
    {
        $role = Role::factory(['role'=>'superadmin'])->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->reportingOrg()->create();

        return $org->user;
    }
}
