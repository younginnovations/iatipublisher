<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NameRepository.
 */
class NameRepository
{
    /**
     * @var organization
     */
    protected organization $organization;

    /**
     * NameRepository Constructor.
     *
     * @param organization $organization
     */
    public function __construct(organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Returns name data of an organization.
     *
     * @param $organizationId
     *
     * @return array|null
     */
    public function getNameData($organizationId): ?array
    {
        return $this->organization->findorFail($organizationId)->name;
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
     * @param $organizationName
     * @param $organization
     *
     * @return bool
     */
    public function update($organizationName, $organization): bool
    {
        return $this->organization->update($organizationName, $organization);
    }
}
