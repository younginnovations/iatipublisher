<?php

declare(strict_types=1);

namespace App\IATI\Services\User;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepo;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }
}
