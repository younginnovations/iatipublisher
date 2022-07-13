<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\OrganizationRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrganizationService.
 */
class OrganizationService
{
    /**
     * @var OrganizationRepository
     */
    private OrganizationRepository $organizationRepo;

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
    public function create(array $data): Model
    {
        return $this->organizationRepo->store($data);
    }

    /**
     * Returns Organization object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getOrganizationData($id): Model
    {
        return $this->organizationRepo->getOrganizationData($id);
    }
}
