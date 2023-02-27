<?php

namespace Tests\Unit;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
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
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();
        $this->actingAs($org->user);
        $this->user = $org->user;
        $this->organization = $org;
    }
}
