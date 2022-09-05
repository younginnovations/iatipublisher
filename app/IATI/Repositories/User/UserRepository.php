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
    public function getModel(): string
    {
        return User::class;
    }

    /**
     * Returns user model.
     *
     * @return string
     */
    public function sendEmail($user): void
    {
        User::sendEmail($user);
    }

    /**
     * Returns user model.
     *
     * @return bool
     */
    public function getStatus($user_id): bool
    {
        return ($this->model->find($user_id))['email_verified_at'] ? true : false;
    }
}
