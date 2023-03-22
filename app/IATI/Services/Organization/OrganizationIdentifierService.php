<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Organization\Organization;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Repositories\Organization\OrganizationRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class OrganizationIdentifierService.
 */
class OrganizationIdentifierService
{
    /**
     * @var OrganizationRepository
     */
    protected OrganizationRepository $organizationRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * OrganizationIdentifierService constructor.
     *
     * @param OrganizationRepository $organizationRepository
     * @param ActivityRepository $activityRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(
        OrganizationRepository $organizationRepository,
        ActivityRepository $activityRepository,
        BaseFormCreator $baseFormCreator
    ) {
        $this->organizationRepository = $organizationRepository;
        $this->activityRepository = $activityRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns organization identifier data of an organization.
     *
     * @param int $organization_id
     *
     * @return string
     */
    public function getIdentifierData(int $organization_id): string
    {
        return $this->organizationRepository->find($organization_id)->identifier;
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
        return $this->organizationRepository->getOrganizationData($id);
    }

    /**
     * Updates Organization identifier.
     *
     * @param $id
     * @param $organizationIdentifiers
     *
     * @return bool
     */
    public function update($id, $organizationIdentifiers): bool
    {
        $organization = $this->organizationRepository->find($id);
        $reportingOrg = $organization->reporting_org;
        $reportingOrg[0]['ref'] = $organizationIdentifiers['organization_registration_agency'] . '-' . $organizationIdentifiers['registration_number'];

        $organizationIdentifiers = [
            'identifier'          => $reportingOrg[0]['ref'],
            'country'             => $organizationIdentifiers['organization_country'],
            'registration_agency' => $organizationIdentifiers['organization_registration_agency'],
            'registration_number' => $organizationIdentifiers['registration_number'],
            'reporting_org'       => $reportingOrg,
        ];

        $organization->fill($organizationIdentifiers);

        return $organization->save() && (!$organization->isDirty('identifier') || empty($this->syncActivityReportingOrgFromIdentifier($id)));
    }

    /**
     * Generates name form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/organizationElementJsonSchema.json')), true, 512, JSON_THROW_ON_ERROR);
        $organization = $this->getOrganizationData($id);
        $model['organisation_identifier'] = $organization['identifier'];
        $model['organization_country'] = $organization['country'];
        $model['organization_registration_agency'] = $organization['registration_agency'];
        $model['registration_number'] = $organization['registration_number'];
        $this->baseFormCreator->url = route('admin.organisation.identifier.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['organisation_identifier'], 'PUT', '/organisation');
    }

    /**
     * Returns organization identifier data for xml generation.
     *
     * @param Organization $organization
     *
     * @return array
     */
    public function getXMLData(Organization $organization): array
    {
        $organizationData[] = $organization->identifier;

        return $organizationData;
    }

    /**
     * Updates activity->reporting_org when there's change in organaisation identifier.
     *
     * @param $id
     *
     * @return int
     */
    public function syncActivityReportingOrgFromIdentifier($id): int
    {
        $orgReportingOrg = $this->organizationRepository->find($id)->reporting_org[0];

        return $this->activityRepository->syncReportingOrg($id, $orgReportingOrg);
    }
}
