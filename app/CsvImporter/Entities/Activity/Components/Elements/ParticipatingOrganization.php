<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\ParticipatingOrganization\ParticipatingOrganizationRequest;

/**
 * Class ParticipatingOrganization.
 */
class ParticipatingOrganization extends Element
{
    /**
     * @var array
     */
    private array $_csvHeaders = ['participating_organisation_role', 'participating_organisation_reference', 'participating_organisation_type', 'participating_organisation_name', 'participating_organisation_identifier', 'participating_organisation_crs_channel_code'];

    /**
     * Index under which the data is stored within the object.
     * @var string
     */
    protected string $index = 'participating_org';

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
     * @var ParticipatingOrganizationRequest
     */
    private ParticipatingOrganizationRequest $request;

    /**
     * ParticipatingOrganisation constructor.
     *
     * @param            $fields
     * @param Validation $factory
     *
     * @throws \JsonException
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new ParticipatingOrganizationRequest();
    }

    /**
     * Prepare ParticipatingOrganisation Element.
     * @param $fields
     *
     * @return void
     * @throws \JsonException
     */
    public function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeaders))) {
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
     * @throws \JsonException
     */
    public function map($key, $value, $index): void
    {
        if (!is_null($value)) {
            $this->setOrganisationRole($key, $value, $index);
            $this->setOrganisationReference($key, $value, $index);
            $this->setIdentifier($key, $value, $index);
            $this->setOrganisationType($key, $value, $index);
            $this->setNarrative($key, $value, $index);
            $this->setOrganisationCrsChannelCode($key, $value, $index);
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
     * @throw \JsonExceptioon
     * @throws \JsonException
     */
    protected function setOrganisationRole($key, $value, $index): void
    {
        if (!isset($this->data['participating_org'][$index]['organization_role'])) {
            $this->data['participating_org'][$index]['organization_role'] = '';
        }

        if ($key === $this->_csvHeaders[0] && (!is_null($value))) {
            $validOrganizationRoles = $this->loadCodeList('OrganisationRole', 'Organization');
            $value = $value ? trim($value) : '';

            if ($value) {
                foreach ($validOrganizationRoles as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->orgRoles[] = $value;
            $this->orgRoles = array_unique($this->orgRoles);

            $this->data['participating_org'][$index]['organization_role'] = $value;
        }
    }

    /**
     * Set Reference of Participating Organisation.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setOrganisationReference($key, $value, $index): void
    {
        if (!isset($this->data['participating_org'][$index]['ref'])) {
            $this->data['participating_org'][$index]['ref'] = '';
        }

        if ($key === $this->_csvHeaders[1] && (!is_null($value))) {
            $this->data['participating_org'][$index]['ref'] = $value;
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
        if (!isset($this->data['participating_org'][$index]['identifier'])) {
            $this->data['participating_org'][$index]['identifier'] = '';
        }

        if ($key === $this->_csvHeaders[4] && (!is_null($value))) {
            $this->data['participating_org'][$index]['identifier'] = $value;
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
        if (!isset($this->data['participating_org'][$index]['type'])) {
            $this->data['participating_org'][$index]['type'] = '';
        }

        if ($key === $this->_csvHeaders[2] && (!is_null($value))) {
            $validOrganizationType = $this->loadCodeList('OrganizationType', 'Organization');
            $value = $value ? trim($value) : '';

            if ($value) {
                foreach ($validOrganizationType as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->types[] = $value;
            $this->types = array_unique($this->types);

            $this->data['participating_org'][$index]['type'] = $value;
        }
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
        if (!isset($this->data['participating_org'][$index]['narrative'])) {
            $this->data['participating_org'][$index]['narrative'][] = ['narrative' => '', 'language' => ''];
        } else {
            if ($key === $this->_csvHeaders[3]) {
                foreach ($this->data['participating_org'][$index]['narrative'] as $d) {
                    $this->data['participating_org'][$index]['narrative'] = array_filter($d);
                }

                $narrative = ['narrative' => $value, 'language' => ''];
                $this->narratives[] = $narrative;

                $this->data['participating_org'][$index]['narrative'][] = $narrative;
            }
        }
    }

    /**
     * Set Organisation crs channel code for Participating Organisation.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     * @throws \JsonException
     */
    protected function setOrganisationCrsChannelCode($key, $value, $index): void
    {
        if (!isset($this->data['participating_org'][$index]['crs_channel_code'])) {
            $this->data['participating_org'][$index]['crs_channel_code'] = '';
        }

        if ($key === $this->_csvHeaders[5] && (!is_null($value))) {
            $validOrganizationCrsCode = $this->loadCodeList('CRSChannelCode');

            if (!is_int($value)) {
                foreach ($validOrganizationCrsCode as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = is_int($code) ? (int) $code : $code;
                        break;
                    }
                }
            }

            $this->data['participating_org'][$index]['crs_channel_code'] = $value;
        }
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function rules(): array
    {
        return $this->request->getWarningForParticipatingOrg($this->data('participating_org'));
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function errorRules(): array
    {
        return $this->request->getErrorsForParticipatingOrg($this->data('participating_org'));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForParticipatingOrg($this->data('participating_org'));
    }

    /**
     * Validate data for IATI Element.
     *
     * @return $this
     * @throws \JsonException
     */
    public function validate(): static
    {
        $this->validator = $this->factory->sign($this->data())
                                         ->with($this->rules(), $this->messages())
                                         ->getValidatorInstance();
        $this->errorValidator = $this->factory->sign($this->data())
                                         ->with($this->errorRules(), $this->messages())
                                         ->getValidatorInstance();

        $this->setValidity();

        return $this;
    }

    /**
     * Get the valid OrganizationRole from the OrganizationRole codelist as a string.
     *
     * @return string
     * @throw \JsonException
     * @throws \JsonException
     */
    protected function validOrganizationRoles(): string
    {
        $organizationRoleCodeList = $this->loadCodeList('OrganisationRole', 'Organization');
        $organizationRoles = array_keys($organizationRoleCodeList) + array_values($organizationRoleCodeList);

        return implode(',', array_keys(array_flip($organizationRoles)));
    }

    /**
     * Get the valid OrganizationType from the OrganizationType code list as a string.
     *
     * @return string
     * @throw \JsonException
     * @throws \JsonException
     */
    protected function validOrganizationTypes(): string
    {
        $organizationTypeCodeList = $this->loadCodeList('OrganizationType', 'Organization');

        $organizationTypes = array_keys($organizationTypeCodeList) + array_values($organizationTypeCodeList);

        return implode(',', array_keys(array_flip($organizationTypes)));
    }

    /**
     * Get the valid Organization crs channel codes from the OrganizationType code list as a string.
     *
     * @return string
     * @throw \JsonException
     * @throws \JsonException
     */
    protected function validOrganizationCrsChannelCodes(): string
    {
        $organizationCrsChannelCodeList = $this->loadCodeList('CRSChannelCode');

        $organizationCrsChannelCodes = array_keys($organizationCrsChannelCodeList) + array_values($organizationCrsChannelCodeList);

        return implode(',', array_keys(array_flip($organizationCrsChannelCodes)));
    }
}
