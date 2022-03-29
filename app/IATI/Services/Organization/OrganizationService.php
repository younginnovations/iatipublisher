<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

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
}
