<?php

namespace Database\Factories\IATI\Models\User;

use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
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
        Role::factory()->create(['role' => 'superadmin']);

        return [
            'username'  => 'yipl_user',
            'email'     => 'yipl_user@gmail.com',
            'password'  => bcrypt('password'),
            'full_name' => 'Young Innovations',
            'address'   => 'Mahalaxmisthan, Lalitpur',
            'is_active' => true,
            'role_id'   => app(Role::class)->getOrganizationAdminId(),
        ];
    }
}
