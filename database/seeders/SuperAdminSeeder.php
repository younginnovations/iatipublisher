<?php

namespace Database\Seeders;

use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserTableSeeder.
 */
class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::firstOrCreate([
            'username'  => 'superadmin',
            'full_name' => 'superadmin',
            'email'     => 'superadmin@gmail.com',
            'address'   => 'kathmandu',
            'is_active' => true,
            'password'  => Hash::make('password'),
            'role_id'   => app(Role::class)->getSuperAdminId(),
        ]);
    }
}
