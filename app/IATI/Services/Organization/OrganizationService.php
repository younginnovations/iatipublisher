<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Models\Organization\Organization;
use App\IATI\Repositories\Organization\OrganizationRepository;
use App\IATI\Traits\OrganizationXmlBaseElements;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class OrganizationService.
 */
class OrganizationService
{
    use OrganizationXmlBaseElements;

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
     *
     * @return Model
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
    public function getReportingOrgXmlData(Organization $organization): array
    {
        $organizationData = [];
        $orgReportingOrg = (array) $organization->reporting_org;

        if (count($orgReportingOrg)) {
            foreach ($orgReportingOrg as $OrgReportingOrg) {
                $organizationData[] = [
                    '@attributes' => [
                        'type'               => Arr::get($OrgReportingOrg, 'type', null),
                        'ref'                => Arr::get($OrgReportingOrg, 'ref', null),
                        'secondary-reporter' => Arr::get($OrgReportingOrg, 'secondary_reporter', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($OrgReportingOrg, 'narrative', [])),
                ];
            }
        }

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
     * @return Application|mixed
     */
    public function getService($serviceName): mixed
    {
        return app(sprintf("App\IATI\Services\Organization\%s", $serviceName));
    }

    /**
     * Updates status column of activity row.
     *
     * @param $organization
     * @param $status
     * @param $alreadyPublished
     *
     * @return bool
     */
    public function updatePublishedStatus($organization, $status, $alreadyPublished): bool
    {
        return $this->organizationRepo->updatePublishedStatus($organization, $status, $alreadyPublished);
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
            if (array_key_exists(
                $mandatory_element,
                $organization->element_status
            ) && $organization->element_status[$mandatory_element]) {
                $completed_mandatory_element_count++;
            }
        }

        return round(($completed_mandatory_element_count / count($mandatory_elements)) * 100, 2);
    }

    /**
     * Returns array of dropdown elements in organization.
     *
     * @return array
     * @throws \JsonException
     */
    public function getOrganizationTypes(): array
    {
        return [
            'budgetType'       => getCodeList('BudgetStatus', 'Activity', false),
            'languages'        => getCodeList('Language', 'Organization', false),
            'documentCategory' => getCodeList('DocumentCategory', 'Activity', false),
            'organizationType' => getCodeList('OrganizationType', 'Organization', false),
            'country'          => getCodeList('Country', 'Organization', false),
            'regionVocabulary' => getCodeList('RegionVocabulary', 'Activity'),
            'region'           => getCodeList('Region', 'Activity'),
        ];
    }
}
