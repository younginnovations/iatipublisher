<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;

/**
 * Class ParticipatingOrganization.
 */
class ParticipatingOrganization extends Element
{
    /**
     * @var array
     */
    private array $_csvHeaders = ['participating_organisation_role', 'participating_organisation_type', 'participating_organisation_name', 'participating_organisation_identifier'];

    /**
     * Index under which the data is stored within the object.
     * @var string
     */
    protected string $index = 'participating_organization';

    /**
     * @var array
     */
    protected array $template = ['type' => '', 'date' => '', 'narrative' => ['narrative' => '', 'language' => '']];

    /**
     * @var array
     */
    protected array $types = [];

    /**
     * @var
     */
    protected $narratives;

    /**
     * @var array
     */
    protected array $orgRoles = [];

    /**
     * ParticipatingOrganisation constructor.
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
    }

    /**
     * Prepare ParticipatingOrganisation Element.
     *
     * @param $fields
     *
     * @return void
     */
    public function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (array_key_exists($key, array_flip($this->_csvHeaders))) {
                foreach ($values as $index => $value) {
                    $this->map($key, $value, $index);
                }
            }
        }
    }

    /**
     * Map data from CSV file into ParticipatingOrganisation data format.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    public function map($key, $value, $index): void
    {
        if (!is_null($value)) {
            $this->setOrganisationRole($key, $value, $index);
            $this->setIdentifier($key, $value, $index);
            $this->setOrganisationType($key, $value, $index);
            $this->data['participating_organization'][$index]['ref'] = '';
            $this->data['participating_organization'][$index]['crs_channel_code'] = $value;
            $this->setNarrative($key, $value, $index);
        }
    }

    /**
     * Set Organisation Role of Participating Organisation.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     * @throws \JsonException
     */
    protected function setOrganisationRole($key, $value, $index): void
    {
        if (!isset($this->data['participating_organization'][$index]['organization_role'])) {
            $this->data['participating_organization'][$index]['organization_role'] = '';
        }

        if ($key === $this->_csvHeaders[0] && (!is_null($value))) {
            $validOrganizationRoles = $this->loadCodeList('OrganisationRole', 'Organization');

            // foreach ($validOrganizationRoles as $name => $role) {
            //     if (strcasecmp($value, $role) === 0) {
            //         $value = $name;
            //         break;
            //     }
            // }

            $this->orgRoles[] = $value;
            $this->orgRoles = array_unique($this->orgRoles);

            $this->data['participating_organization'][$index]['organization_role'] = $value;
        }
    }

    /**
     * Set Identifier of Participating Organisation.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setIdentifier($key, $value, $index): void
    {
        if (!isset($this->data['participating_organization'][$index]['identifier'])) {
            $this->data['participating_organization'][$index]['identifier'] = '';
        }

        if ($key === $this->_csvHeaders[3] && (!is_null($value))) {
            $this->data['participating_organization'][$index]['identifier'] = $value;
        }
    }

    /**
     * Set OrganisationType for Participating Organisation.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     * @throws \JsonException
     */
    protected function setOrganisationType($key, $value, $index): void
    {
        if (!isset($this->data['participating_organization'][$index]['type'])) {
            $this->data['participating_organization'][$index]['type'] = '';
        }

        if ($key === $this->_csvHeaders[0] && (!is_null($value))) {
            $validOrganizationTypes = $this->loadCodeList('OrganizationType', 'Organization');

            // foreach ($validOrganizationTypes as $name => $role) {
            //     if (strcasecmp($value, $role) == 0) {
            //         $value = $name;
            //         break;
            //     }
            // }

            $this->types[] = $value;
            $this->types = array_unique($this->types);

            $this->data['participating_organization'][$index]['type'] = $value;
        }

        // if (!isset($this->data['participating_organization'][$index]['type'])) {
        //     $this->data['participating_organization'][$index]['type'] = '';
        // }

        // if ($key == $this->_csvHeaders[1] && (!is_null($value))) {
        //     $validOrganizationType = $this->loadCodeList('OrganizationType', 'Organization');

        //     foreach ($validOrganizationType as $index => $type) {
        //         if (strcasecmp($value, $type) == 0) {
        //             $value = $index;
        //             break;
        //         }
        //     }

        //     $types[] = $value;
        //     $types = array_unique($types);

        //     $this->data['participating_organization'][$index]['type'] = $value;
        // }
    }

    /**
     * Set Narrative for ParticipatingOrganisation.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setNarrative($key, $value, $index): void
    {
        if (!isset($this->data['participating_organization'][$index]['narrative'])) {
            $this->data['participating_organization'][$index]['narrative'][] = ['narrative' => '', 'language' => ''];
        } else {
            if ($key === $this->_csvHeaders[2]) {
                foreach ($this->data['participating_organization'][$index]['narrative'] as $d) {
                    $this->data['participating_organization'][$index]['narrative'] = array_filter($d);
                }

                $narrative = ['narrative' => $value, 'language' => ''];
                $this->narratives[] = $narrative;

                $this->data['participating_organization'][$index]['narrative'][] = $narrative;
            }
        }
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            // 'participating_organization'                     => 'nullable|required_only_one_among:identifier,narrative',
            'participating_organization'                     => 'nullable',
            // 'participating_organization.*.organization_role' => sprintf('nullable|in:%s', $this->validOrganizationRoles()),
            'participating_organization.*.organization_role' => sprintf('nullable|in:%s', $this->validOrganizationRoles()),
            'participating_organization.*.type' => sprintf('in:%s', $this->validOrganizationTypes()),
        ];
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'participating_organization.required'                      => trans('validation.required', ['attribute' => trans('elementForm.participating_organisation')]),
            'participating_organization.*.organization_role.required'  => trans('validation.required', ['attribute' => trans('elementForm.participating_organisation_role')]),
            'participating_organization.required_only_one_among'       => trans(
                'validation.required_only_one_among',
                [
                    'attribute' => trans('elementForm.participating_organisation_identifier'),
                    'values'    => trans('elementForm.participating_organisation_name'),
                ]
            ),
            'participating_organization.*.organization_role.in'        => trans('validation.code_list', ['attribute' => trans('elementForm.participating_organisation_role')]),
            'participating_organization.*.type.in'        => trans('validation.code_list', ['attribute' => trans('elementForm.participating_organisation_type')]),
        ];
    }

    /**
     * Validate data for IATI Element.
     *
     * @return $this
     */
    public function validate(): static
    {
        $this->validator = $this->factory->sign($this->data())
            ->with($this->rules(), $this->messages())
            ->getValidatorInstance();

        $this->setValidity();

        return $this;
    }

    /**
     * Get the valid OrganizationRole from the OrganizationRole codelist as a string.
     *
     * @return string
     * @throws \JsonException
     */
    protected function validOrganizationRoles(): string
    {
        [$organizationRoleCodeList, $organizationRoles] = [$this->loadCodeList('OrganisationRole', 'Organization'), []];
        $organizationRoles = array_keys($organizationRoleCodeList) + array_values($organizationRoleCodeList);

        return implode(',', array_keys(array_flip($organizationRoles)));
    }

    /**
     * Get the valid OrganizationType from the OrganizationType codelist as a string.
     *
     * @return string
     * @throws \JsonException
     */
    protected function validOrganizationTypes(): string
    {
        [$organizationTypeCodeList, $organizationTypes] = [$this->loadCodeList('OrganizationType', 'Organization'), []];

        $organizationTypes = array_keys($organizationTypeCodeList) + array_values($organizationTypeCodeList);

        return implode(',', array_keys(array_flip($organizationTypes)));
    }
}
