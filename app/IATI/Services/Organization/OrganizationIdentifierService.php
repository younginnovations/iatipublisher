<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Repositories\Organization\OrganizationIdentifierRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrganizationIdentifierService.
 */
class OrganizationIdentifierService
{
    /**
     * @var OrganizationIdentifierRepository
     */
    protected OrganizationIdentifierRepository $organizationIdentifierRepository;

    /**
     * OrganizationIdentifierService constructor.
     *
     * @param OrganizationIdentifierRepository $organizationIdentifierRepository
     */
    public function __construct(OrganizationIdentifierRepository $organizationIdentifierRepository)
    {
        $this->organizationIdentifierRepository = $organizationIdentifierRepository;
    }

    /**
     * Returns organization identifier data of an organization.
     *
     * @param int $organization_id
     *
     * @return array
     */
    public function getOrganizationIdentifierData(int $organization_id): array
    {
        return $this->organizationIdentifierRepository->getOrganizationIdentifierData($organization_id);
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
        return $this->organizationIdentifierRepository->getOrganizationData($id);
    }

    /**
     * Updates Organization identifier.
     *
     * @param $organizationIdentifier
     * @param $organization
     *
     * @return bool
     */
    public function update($organizationIdentifier, $organization): bool
    {
        $organization->organizationIdentifier = $organizationIdentifier['narrative'];

        return $organization->save();
    }
}
