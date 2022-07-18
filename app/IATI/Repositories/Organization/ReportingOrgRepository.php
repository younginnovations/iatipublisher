<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReportingOrgRepository.
 */
class ReportingOrgRepository
{
    /**
     * @var Organization
     */
    protected Organization $organization;

    /**
     * ReportingOrgRepository Constructor.
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
     * @return array|null
     */
    public function getReportingOrgData($organizationId): ?array
    {
        return $this->organization->findorFail($organizationId)->reporting_org;
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
     * Updates organization reportingOrg.
     *
     * @param $reportingOrg
     * @param $organization
     *
     * @return bool
     */
    public function update($reportingOrg, $organization): bool
    {
        foreach ($reportingOrg['reporting_org'] as $key => $description) {
            $reportingOrg['reporting_org'][$key]['narrative'] = array_values($description['narrative']);
        }

        $organization->reporting_org = array_values($reportingOrg['reporting_org']);

        return $organization->save();
    }
}
