<?php

namespace Database\Seeders;

use App\IATI\Models\User\Role;
use Illuminate\Database\Seeder;

/**
 * Class RoleTableSeeder.
 */
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        /** Create or update superadmin role */
        /** @var array $superAdminRole */
        $superAdminRole = Role::factory()->make(['role' => 'superadmin'])->toArray();
        Role::updateOrCreate(['role' => 'superadmin'], $superAdminRole);

        /** Create or update iati_admin role */
        /** @var array $iati_admin */
        $iatiAdminRole = Role::factory()->make(['role' => 'iati_admin'])->toArray();
        Role::updateOrCreate(['role' => 'iati_admin'], $iatiAdminRole);

        /** Create or update admin role */
        /** @var array $adminRole */
        $adminRole = Role::factory()->make(['role' => 'admin'])->toArray();
        Role::updateOrCreate(['role' => 'admin'], $adminRole);

        /**Create or update general_user */
        /** @var array $generalUserRole */
        $generalUserRole = Role::factory()->make(['role' => 'general_user'])->toArray();
        Role::updateOrCreate(['role' => 'general_user'], $generalUserRole);
    }
}
