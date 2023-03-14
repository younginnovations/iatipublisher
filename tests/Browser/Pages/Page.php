<?php

namespace Tests\Browser\Pages;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Laravel\Dusk\Page as BasePage;

abstract class Page extends BasePage
{
    /**
     * Get the global element shortcuts for the site.
     *
     * @return array<string, string>
     */
    public static function siteElements(): array
    {
        return [
            '@element' => '#selector',
        ];
    }

    /**
     * Returns user.
     * @return object
     */
    public function getUser(): object
    {
        $role = Role::factory()->create();
        $org = Organization::factory()->has(User::factory(['role_id' => $role->id]))->create();

        return $org->user;
    }
}
