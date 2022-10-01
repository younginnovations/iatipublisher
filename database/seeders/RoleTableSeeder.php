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
        Role::firstOrCreate($superAdminRole, $superAdminRole);

        /** Create or update admin role */
        /** @var array $adminRole */
        $adminRole = Role::factory()->make(['role' => 'admin'])->toArray();
        Role::firstOrCreate($adminRole, $adminRole);
    }
}
