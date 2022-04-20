<?php

declare(strict_types=1);

namespace App\IATI\Repositories\User;

use App\IATI\Models\User\User;
use App\IATI\Repositories\Repository;

/**
 * Class UserRepository.
 */
class UserRepository extends Repository
{
    /**
     * Returns user model.
     *
     * @return string
     */
    public function getModel():string
    {
        return User::class;
    }
}
