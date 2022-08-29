<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Organization\Organization;
use App\IATI\Repositories\Organization\OrganizationRepository;
use App\IATI\Traits\OrganizationXmlBaseElements;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ReportingOrgService.
 */
class ReportingOrgService
{
    use OrganizationXmlBaseElements;

    /**
     * @var OrganizationRepository
     */
    protected OrganizationRepository $organizationRepository;

    /**
     * ReportingOrgService constructor.
     *
     * @param OrganizationRepository $organizationRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(OrganizationRepository $organizationRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->organizationRepository = $organizationRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
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
        return $this->organizationRepository->find($organization_id)->reporting_org;
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
        return $this->organizationRepository->find($id);
    }

    /**
     * Updates Organization identifier.
     *
     * @param $id
     * @param $reportingOrg
     *
     * @return bool
     */
    public function update($id, $reportingOrg): bool
    {
        foreach ($reportingOrg['reporting_org'] as $key => $description) {
            $reportingOrg['reporting_org'][$key]['narrative'] = array_values($description['narrative']);
        }

        $reportingOrg = array_values($reportingOrg['reporting_org']);

        return $this->organizationRepository->update($id, ['reporting_org' => $reportingOrg]);
    }

    /**
     * Generates name form.
     *
     * @param $id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/organizationElementJsonSchema.json')), true);
        $model['reporting_org'] = $this->getReportingOrgData($id) ?? [];
        $this->parentCollectionFormCreator->url = route('admin.organisation.reporting-org.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['reporting_org'], 'PUT', '/organisation');
    }

    /**
     * Generates xml data for reporting org.
     *
     * @param Organization $organization
     *
     * @return array
     */
    public function getXmlData(Organization $organization): array
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
