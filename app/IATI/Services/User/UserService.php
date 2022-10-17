<?php

declare(strict_types=1);

namespace App\IATI\Services\User;

use App\IATI\Models\User\User;
use App\IATI\Repositories\Organization\OrganizationRepository;
use App\IATI\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class UserService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepo;

    /**
     * @var OrganizationRepository
     */
    private OrganizationRepository $organizationRepo;

    /**
     * UserService constructor.
     *
     * @param UserRepository         $userRepo
     * @param OrganizationRepository $organizationRepo
     */
    public function __construct(UserRepository $userRepo, OrganizationRepository $organizationRepo)
    {
        $this->userRepo = $userRepo;
        $this->organizationRepo = $organizationRepo;
    }

    /**
     * Store user.
     *
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->userRepo->store($data);
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function registerExistingUser(array $data): Model
    {
        $organization = $this->organizationRepo->createOrganization([
            'publisher_id'        => $data['publisher_id'],
            'publisher_name'      => $data['publisher_name'],
            'country'             => $data['country'] ?? null,
            'registration_agency' => $data['registration_agency'],
            'registration_number' => $data['registration_number'],
            'identifier'          => $data['registration_agency'] . '-' . $data['registration_number'],
            'iati_status'         => 'pending',
        ]);

        $user = $this->userRepo->store([
            'username'        => $data['username'],
            'full_name'       => $data['full_name'],
            'email'           => $data['email'],
            'organization_id' => $organization['id'],
            'password'        => Hash::make($data['password']),
        ]);

        User::sendEmail();

        return $user;
    }

    /**
     * Stores the user that exists in IATI.
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->userRepo->getStatus(Auth::user()->id);
    }

    /**
     * Stores the user that exists in IATI.
     *
     * @return void
     */
    public function resendVerificationEmail(): void
    {
        User::sendEmail();
        User::resendEmail(Auth::user());
    }

    /**
     * Returns user if found.
     *
     * @param $id
     *
     * @return object
     */
    public function getUser($id): object
    {
        return $this->userRepo->getUser($id);
    }
}
