<?php

declare(strict_types=1);

namespace App\IATI\Services\User;

use App\IATI\Repositories\Organization\OrganizationRepository;
use App\IATI\Repositories\Setting\SettingRepository;
use App\IATI\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
     * @var SettingRepository
     */
    private $settingRepo;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo, OrganizationRepository $organizationRepo, SettingRepository $settingRepo)
    {
        $this->userRepo = $userRepo;
        $this->organizationRepo = $organizationRepo;
        $this->settingRepo = $settingRepo;
    }

    /**
     * Store user.
     *
     * @param array $data
     */
    public function create(array $data): \Illuminate\Database\Eloquent\Model
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
        // dump('here');
        $organization = $this->organizationRepo->createOrganization([
            'publisher_id'        => $data['publisher_id'],
            'publisher_name'      => $data['publisher_name'],
            'country'             => isset($data['country']) ? $data['country'] : null,
            'registration_agency' => $data['registration_agency'],
            'registration_number' => $data['registration_number'],
            'identifier'          => $data['registration_agency'] . '-' . $data['registration_number'],
            'iati_status'         => 'pending',
        ]);
        // dd($organization);

        // Log::info($organization['id']);

        return $this->userRepo->store([
            'username'        => $data['username'],
            'full_name'       => $data['full_name'],
            'email'           => $data['email'],
            'organization_id' => $organization['id'],
            'password'        => Hash::make($data['password']),
        ]);
    }
}
