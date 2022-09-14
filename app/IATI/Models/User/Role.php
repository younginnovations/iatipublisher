<?php

namespace App\IATI\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Role.
 */
class Role extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * Many users have role.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
