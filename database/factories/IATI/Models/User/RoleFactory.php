<?php

declare(strict_types=1);

namespace Database\Factories\IATI\Models\User;

use App\IATI\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use function now;

/**
 * Class RoleFactory.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'id' => 1,
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
