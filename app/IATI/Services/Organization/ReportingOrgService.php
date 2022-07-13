<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Models\Organization\Organization;
use App\IATI\Repositories\Organization\ReportingOrgRepository;
use App\IATI\Traits\OrganizationXmlBaseElements;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReportingOrgService.
 */
class ReportingOrgService
{
    use OrganizationXmlBaseElements;

    /**
     * @var ReportingOrgRepository
     */
    protected ReportingOrgRepository $reportingOrgRepository;

    /**
     * ReportingOrgService constructor.
     *
     * @param ReportingOrgRepository $reportingOrgRepository
     */
    public function __construct(ReportingOrgRepository $reportingOrgRepository)
    {
        $this->reportingOrgRepository = $reportingOrgRepository;
    }

    /**
     * Returns reporting org data of an organization.
     *
     * @param int $organization_id
     *
     * @return array|null
     */
    public function getReportingOrgData(int $organization_id): ?array
    {
        return $this->reportingOrgRepository->getReportingOrgData($organization_id);
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
        return $this->reportingOrgRepository->getOrganizationData($id);
    }

    /**
     * Updates Organization identifier.
     *
     * @param $reportingOrg
     * @param $organization
     *
     * @return bool
     */
    public function update($reportingOrg, $organizationData): bool
    {
        return $this->reportingOrgRepository->update($reportingOrg, $organizationData);
    }

    /**
     * @param Organization $organization
     * @return array
     */
    public function getXmlData(Organization $organization)
    {
        $organizationData = [];
        $orgReportingOrg = (array) $organization->reporting_org;
        foreach ($orgReportingOrg as $reportingOrg) {
            $organizationData[] = [
                '@attributes' => [
                    'type'                  => $reportingOrg['type'],
                    'ref'                   => $reportingOrg['ref'],
                    'secondary-reporter'    => $reportingOrg['secondary_reporter'],
                ],
                'narrative'   => $this->buildNarrative($reportingOrg['narrative']),
            ];
        }

        return $organizationData;
    }
}
