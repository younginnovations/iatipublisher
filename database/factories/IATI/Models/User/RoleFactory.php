<?php

declare(strict_types=1);

namespace Database\Factories\IATI\Models\User;

use App\IATI\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use function now;

/**
 * Class RoleFactory.
 *
 * @extends Factory<Model>
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
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
