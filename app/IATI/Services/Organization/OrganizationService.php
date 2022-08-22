<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Models\Organization\Organization;
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

        $organizationData[] = [
            '@attributes' => [
                'type'               => '21',
                'ref'                => 'MCfAE',
                'secondary-reporter' => null,
            ],
            'narrative'   => [
                [
                    '@value' => 'Dummy reporting org',
                    '@attributes' => [
                        'xml:lang' => 'en',
                    ],
                ],
            ],
        ];

        return $organizationData;
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

    /**
     * Returns required service file.
     *
     * @param $serviceName
     *
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    public function getService($serviceName)
    {
        return app(sprintf("App\IATI\Services\Organization\%s", $serviceName));
    }

    /**
     * Updates status column of activity row.
     *
     * @param $organization
     * @param $status
     * @param $alreadyPublished
     * @param $linkedToIati
     *
     * @return bool
     */
    public function updatePublishedStatus($organization, $status, $alreadyPublished, $linkedToIati): bool
    {
        return $this->organizationRepo->updatePublishedStatus($organization, $status, $alreadyPublished, $linkedToIati);
    }

    /**
     * Return organization mandatory elements progress in percentage.
     *
     * @param $organization
     *
     * @return float|int
     */
    public function organizationMandatoryCompletePercentage($organization): float|int
    {
        $mandatory_elements = getMandatoryElements();
        $completed_mandatory_element_count = 0;

        foreach ($mandatory_elements as $mandatory_element) {
            if (array_key_exists($mandatory_element, $organization->element_status) && $organization->element_status[$mandatory_element]) {
                $completed_mandatory_element_count++;
            }
        }

        return round(($completed_mandatory_element_count / count($mandatory_elements)) * 100, 2);
    }
}
