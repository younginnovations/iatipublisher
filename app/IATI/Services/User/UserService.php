<?php

declare(strict_types=1);

namespace App\IATI\Services\User;

use App\IATI\Repositories\Organization\OrganizationRepository;
use App\IATI\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepo;

    /**
     * @var OrganizationRepository
     */
    private $organizationRepo;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepo
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
     */
    public function create(array $data)
    {
        return $this->userRepo->store($data);
    }

    /**
     * Stores the user that exists in IATI.
     *
     * @param array $data
     */
    public function registerExistingUser(array $data)
    {
        // $organization = $this->organizationRepo->store([
        //   'publisher_id' => $data['publisher_id'],
        //   'publisher_type' => 'government',
        //   'country' => $data['country'],
        //   // 'country' => 'ZW',
        //   'registration_agency' => $data['registration_agency'],
        //   // 'registration_agency' => 'PK-NTN',
        //   'registration_number' => $data['registration_number'],
        //   'identifier' => $data['registration_agency'].'-'.$data['registration_number'],
        //   'status' => 'pending',
        // ]);

        $organization = $this->organizationRepo->createOrganization([
        'publisher_id' => $data['publisher_id'],
        'publisher_type' => 'government',
        // 'country' => $data['country'],
        'country' => 'ZW',
        // 'registration_agency' => $data['registration_agency'],
        'registration_agency' => 'PK-NTN',
        'registration_number' => $data['registration_number'],
        'identifier' => $data['registration_agency'] . '-' . $data['registration_number'],
        'status' => 'pending',
      ]);

        // dd($organization);

        return $this->userRepo->store([
          'username' => $data['username'],
          'full_name' => $data['full_name'],
          'email' => $data['email'],
          'organization_id' => $organization['id'],
          'password' => Hash::make($data['password']),
      ]);
    }
}
