<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Models\Organization\Organization;
use App\IATI\Repositories\IatiApiLog\IatiApiLogRepository;
use App\IATI\Repositories\Organization\OrganizationRepository;
use App\IATI\Traits\OrganizationXmlBaseElements;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

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
     * @var IatiApiLogRepository
     */
    private IatiApiLogRepository $iatiApiLogRepo;

    /**
     * UserService constructor.
     *
     * @param OrganizationRepository $organizationRepo
     * @param IatiApiLogRepository $iatiApiLogRepo
     */
    public function __construct(OrganizationRepository $organizationRepo, IatiApiLogRepository $iatiApiLogRepo)
    {
        $this->organizationRepo = $organizationRepo;
        $this->iatiApiLogRepo = $iatiApiLogRepo;
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
            'regionVocabulary' => getCodeList('RegionVocabulary', 'Activity', false),
            'region'           => getCodeList('Region', 'Activity', false),
        ];
    }

    /**
     * Returns organizations in paginated format.
     *
     * @param $page
     * @param $request
     *
     * @return null|LengthAwarePaginator
     */
    public function getPaginatedOrganizations($page, $request): ?LengthAwarePaginator
    {
        return $this->organizationRepo->getPaginatedOrganizations($page, $request);
    }

    /**
     * Returns list of organization name with their id.
     *
     * @return Collection
     */
    public function pluckAllOrganizations(): Collection
    {
        return $this->organizationRepo->pluckAllOrganizations();
    }

    /**
     * Check if publisher id is active in iati registry.
     *
     * @param string $publisher_id
     *
     * @return bool
     */
    public function isPublisherStateActive(string $publisher_id): bool
    {
        $clientConfig = ['base_uri' => env('IATI_API_ENDPOINT')];
        $requestConfig = [
            'http_errors' => false,
            'query'       => ['id' => $publisher_id ?? ''],
        ];
        $clientConfig['headers']['X-CKAN-API-Key'] = env('IATI_API_KEY');

        if (env('APP_ENV') !== 'production') {
            $requestConfig['auth'] = [env('IATI_USERNAME'), env('IATI_PASSWORD')];
        }

        $client = new Client($clientConfig);
        $res = $client->request('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', $requestConfig);
        $this->iatiApiLogRepo->store(generateApiInfo(new Request('GET', env('IATI_API_ENDPOINT') . '/action/organization_show', $requestConfig), $res));

        if ($res->getStatusCode() === 404) {
            return false;
        }

        $result = json_decode($res->getBody()->getContents())->result;

        if (strcasecmp($result->state, 'active') === 0) {
            return true;
        }

        return false;
    }
}
