<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Models\Organization\Organization;
use App\IATI\Repositories\Organization\OrganizationRepository;

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
    public function create(array $data): \Illuminate\Database\Eloquent\Model
    {
        return $this->organizationRepo->store($data);
    }

    /**
     * Returns data in required xml array format.
     *
     * @param Organization $organization
     *
     * @return array
     */
    public function getReportingOrgXmlData(Organization $organization)
    {
        $organizationData = [];
//        $orgReportingOrg = (array) $organization->reporting_org;
//
//        foreach ($orgReportingOrg as $OrgReportingOrg) {
//            $organizationData[] = [
//                '@attributes' => [
//                    'type'               => $OrgReportingOrg['reporting_organization_type'],
//                    'ref'                => $OrgReportingOrg['reporting_organization_identifier'],
//                    'secondary-reporter' => $organization->secondary_reporter
//                ],
//                'narrative'   => $this->buildNarrative($OrgReportingOrg['narrative']),
//            ];
//        }

        return $organizationData;
    }
}
