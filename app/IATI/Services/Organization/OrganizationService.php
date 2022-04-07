<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\OrganizationRepository;

/**
 * Class OrganizationService.
 */
class OrganizationService
{
    /**
     * @var OrganizationRepository
     */
    private $organizationRepo;

    /**
     * UserService constructor.
     *
     * @param OrganizationRepository $organizationRepo
     */
    public function __construct(OrganizationRepository $organizationRepo)
    {
        $this->organizationRepo = $organizationRepo;
    }

    /**
     * Store user.
     *
     * @param array $data
     */
    public function create(array $data)
    {
        return $this->organizationRepo->store($data);
    }
}
