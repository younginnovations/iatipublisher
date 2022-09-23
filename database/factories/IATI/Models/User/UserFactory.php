<?php

namespace Database\Factories\IATI\Models\User;

use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use App\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Model>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $role = Role::factory()->make(['role' => 'superadmin'])->toArray();

        Role::firstOrCreate($role, $role);

        return [
            'username'  => 'yipl_user',
            'email'     => 'yipl_user@gmail.com',
            'password'  => Hash::make('password'),
            'full_name' => 'Young Innovations',
            'address'   => 'Mahalaxmisthan, Lalitpur',
            'is_active' => true,
            'role_id'   => app(Role::class)->getOrganizationAdminId(),
        ];
    }
}
