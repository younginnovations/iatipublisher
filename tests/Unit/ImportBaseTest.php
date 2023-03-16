<?php

namespace Tests\Unit;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use App\IATI\Services\ImportActivity\ImportCsvService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportBaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var object
     */
    protected object $user;

    /**
     * @var object
     */
    protected object $organization;

    /**
     * Signs In For Test and sets user and organization object.
     * @return void
     */
    public function signIn(): void
    {
        $role = Role::factory()->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->reportingOrg()->create();
        $this->actingAs($org->user);
        $this->user = $org->user;
        $this->organization = $org;
    }

    /**
     * Gets activity identifiers.
     * @return array
     * @throws BindingResolutionException
     * @throws \ReflectionException
     */
    public function getIdentifiers(): array
    {
        $importCsvService = app()->make(ImportCsvService::class);
        $reflectionImportCsvService = new \ReflectionClass($importCsvService);
        $activityIdentifier = $reflectionImportCsvService->getMethod('getIdentifiers');
        $activityIdentifier->setAccessible(true);

        return $activityIdentifier->invoke($importCsvService);
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->user, $this->organization);
    }
}
