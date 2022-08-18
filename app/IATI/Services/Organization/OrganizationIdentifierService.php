<?php

declare(strict_types=1);

namespace App\IATI\Services\Organization;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Organization\Organization;
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
     * OrganizationIdentifierService constructor.
     *
     * @param OrganizationRepository $organizationRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(OrganizationRepository $organizationRepository, BaseFormCreator $baseFormCreator)
    {
        $this->organizationRepository = $organizationRepository;
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
     * @param $organizationIdentifier
     *
     * @return bool
     */
    public function update($id, $organizationIdentifier): bool
    {
        $organizationIdentifier = [
            'identifier' => $organizationIdentifier['organization_registration_agency'] . '-' . $organizationIdentifier['registration_number'],
            'country' => $organizationIdentifier['organization_country'],
            'registration_agency' => $organizationIdentifier['organization_registration_agency'],
            'registration_number' => $organizationIdentifier['registration_number'],
        ];

        return $this->organizationRepository->update($id, $organizationIdentifier);
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
}
