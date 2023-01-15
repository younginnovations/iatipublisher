<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\ReportingOrg\ReportingOrgRequest;
use Illuminate\Support\Arr;

/**
 * Class ReportingOrganization.
 */
class ReportingOrganization extends Element
{
    /**
     * Csv Header for ReportingOrganization element.
     * @var array
     */
    private array $_csvHeaders
    = [
        'reporting_org_reference',
        'reporting_org_type',
        'reporting_org_secondary_reporter',
        'reporting_org_narrative',
    ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'reporting_org';

    /**
     * @var ReportingOrgRequest
     */
    private ReportingOrgRequest $request;

    /**
     * ReportingOrganization constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new ReportingOrgRequest();
    }

    /**
     * Prepare ReportingOrganization element.
     *
     * @param $fields
     *
     * @return void
     */
    public function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeaders))) {
                foreach ($values as $index => $value) {
                    $this->map($key, $index, $value);
                }
            }
        }
    }

    /**
     * Map data from CSV file into ReportingOrganization data format.
     *
     * @param $key
     * @param $index
     * @param $value
     *
     * @return void
     */
    public function map($key, $index, $value): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->setReportingOrganizationReference($key, $index, $value);
            $this->setReportingOrganizationType($key, $index, $value);
            $this->setSecondaryReporter($key, $index, $value);
            $this->setReportingOrganizationNarrative($key, $index, $value);
        }
    }

    /**
     * Set reference for reporting organization.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setReportingOrganizationReference($key, $index, $value): void
    {
        if (!isset($this->data['reporting_org'][$index]['ref'])) {
            $this->data['reporting_org'][$index]['ref'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $value = is_null($value) ? '' : trim($value);
            $this->data['reporting_org'][$index]['ref'] = $value;
        }
    }

    /**
     * Maps reporting organization type.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setReportingOrganizationType($key, $index, $value): void
    {
        if (!isset($this->data['reporting_org'][$index]['type'])) {
            $this->data['reporting_org'][$index]['type'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $value = is_null($value) ? '' : trim($value);
            $validReportingOrgType = $this->loadCodeList('OrganizationType', 'Organization');

            if ($value) {
                foreach ($validReportingOrgType as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['reporting_org'][$index]['type'] = $value;
        }
    }

    /**
     * Set secondary reporter for reporting organization.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setSecondaryReporter($key, $index, $value): void
    {
        if (!isset($this->data['reporting_org'][$index]['secondary_reporter'])) {
            $this->data['reporting_org'][$index]['secondary_reporter'] = '';
        }

        if ($key === $this->_csvHeaders[2]) {
            if ((is_string($value) && (strtolower($value) === 'yes' || strtolower($value) === 'true')) || $value) {
                $value = '1';
            } elseif ((is_string($value) && (strtolower($value) === 'no' || strtolower($value) === 'false')) || !$value) {
                $value = '0';
            }

            $this->data['reporting_org'][$index]['secondary_reporter'] = $value;
        }
    }

    /**
     * Set narrative for reporting organization.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setReportingOrganizationNarrative($key, $index, $value): void
    {
        if (!isset($this->data['reporting_org'][$index]['narrative'][0]['narrative'])) {
            $this->data['reporting_org'][$index]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[3]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['reporting_org'][$index]['narrative'][0] = $narrative;
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
        return $this->request->getRulesForReportingOrganization(Arr::get($this->data, 'reporting_org', []));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForReportingOrganization(Arr::get($this->data, 'reporting_org', []));
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
        $this->setValidity();

        return $this;
    }
}
