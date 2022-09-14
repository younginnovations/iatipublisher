<?php

namespace Database\Factories\IATI\Models\User;

use App\IATI\Models\User\Role;
use App\IATI\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
        Role::factory()->create();

        return [
            'username'        => 'test_username',
            'email'           => 'test@gmail.com',
            'password'        => Hash::make('password'),
            'full_name'       => 'test_fullname',
            'address'         => 'test_address',
            'organization_id' => 1,
            'is_active'       => true,
        ];
    }
}
