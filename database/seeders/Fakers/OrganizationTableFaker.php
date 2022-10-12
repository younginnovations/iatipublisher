<?php

namespace Database\Seeders\Fakers;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\Setting\Setting;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Database\Seeder;

/**
 * Class OrganizationTableFaker.
 */
class OrganizationTableFaker extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Organization::factory()
                    ->has(Setting::factory())
                    ->has(User::factory(['role_id' => app(Role::class)->getOrganizationAdminId()]))->create();
    }
}
