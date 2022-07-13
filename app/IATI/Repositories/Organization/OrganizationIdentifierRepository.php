<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrganizationIdentifierRepository.
 */
class OrganizationIdentifierRepository
{
    /**
     * @var Organization
     */
    protected Organization $organization;

    /**
     * OrganizationIdentifierRepository Constructor.
     *
     * @param Organization $organization
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Returns organization identifier data of an Organization.
     *
     * @param $organizationId
     *
     * @return string
     */
    public function getIdentifierData($organizationId): string
    {
        return $this->organization->findorFail($organizationId)->identifier;
    }

    /**
     * Returns organization object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getOrganizationData($id): Model
    {
        return $this->organization->findOrFail($id);
    }

    /**
     * Updates organization name.
     *
     * @param $organizationIdentifier
     * @param $organizaiton
     *
     * @return bool
     */
    public function update($organizationIdentifier, $organization): bool
    {
        return $this->organization->update($organizationIdentifier, $organization);
    }
}
