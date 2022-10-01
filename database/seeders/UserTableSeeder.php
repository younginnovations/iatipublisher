<?php

namespace Database\Seeders;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $user = User::factory()->make([
                                  'username'  => 'yipl_user',
                                  'organization_id'  => app(Organization::class),
                                  'role_id'   => app(Role::class)->getOrganizationAdminId(),
                                  'password'  => Hash::make('passwordAuthenticationTest')
                              ])->makeVisible('password')->toArray();

        User::firstOrCreate(['username'=>$user['username']], $user);
    }
}
