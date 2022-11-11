<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
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
     * ReportingOrganization constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
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
            $this->setReportingOrganizationReference($key, $value);
            $this->setReportingOrganizationType($key, $value);
            $this->setSecondaryReporter($key, $value);
            $this->setReportingOrganizationNarrative($key, $value);
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
    protected function setReportingOrganizationReference($key, $value): void
    {
        if (!isset($this->data['reporting_org'][0]['ref'])) {
            $this->data['reporting_org'][0]['ref'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $value = (!$value) ? '' : $value;
            $this->data['reporting_org'][0]['ref'] = $value;
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
    protected function setReportingOrganizationType($key, $value): void
    {
        if (!isset($this->data['reporting_org'][0]['type'])) {
            $this->data['reporting_org'][0]['type'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $value = (!$value) ? '' : $value;
            $validReportingOrgType = $this->loadCodeList('OrganizationType', 'Organization');

            if ($value) {
                foreach ($validReportingOrgType as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['reporting_org'][0]['type'] = $value;
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
    protected function setSecondaryReporter($key, $value): void
    {
        if (!isset($this->data['reporting_org'][0]['secondary_reporter'])) {
            $this->data['reporting_org'][0]['secondary_reporter'] = '';
        }

        if ($key === $this->_csvHeaders[2]) {
            if (is_string($value) && ((strtolower($value) === 'yes') || (strtolower($value) === 'true'))) {
                $value = '1';
            } elseif (is_string($value) && ((strtolower($value) === 'no') || (strtolower($value) === 'false'))) {
                $value = '0';
            }

            $this->data['reporting_org'][0]['secondary_reporter'] = $value;
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
    protected function setReportingOrganizationNarrative($key, $value): void
    {
        if (!isset($this->data['reporting_org'][0]['narrative'][0]['narrative'])) {
            $this->data['reporting_org'][0]['narrative'][0] = [
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

            $this->data['reporting_org'][0]['narrative'][0] = $narrative;
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
        $validReportingOrganizationType = implode(
            ',',
            $this->validReportingOrganizationCodeList('OrganizationType', 'Organization')
        );

        $rules = [];

        foreach (Arr::get($this->data, 'reporting_org', []) as $key => $reportingOrganization) {
            $reportingOrgForm = sprintf('reporting_org.%s', $key);
            $rules[sprintf('%s.type', $reportingOrgForm)] = sprintf(
                'in:%s|required',
                $validReportingOrganizationType,
            );
            $rules[sprintf('%s.secondary_reporter', $reportingOrgForm)] = 'nullable|in:0,1';
            $rules[sprintf('%s.narrative.0.narrative', $reportingOrgForm)] = 'required';
        }

        return $rules;
    }

    /**
     * Return Valid ReportingOrganization Type.
     *
     * @param $name
     * @param string $type
     *
     * @return array
     * @throws \JsonException
     */
    protected function validReportingOrganizationCodeList($name, string $type = 'Activity'): array
    {
        return array_keys($this->loadCodeList($name, $type));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = [];

        foreach (Arr::get($this->data, 'reporting_org', []) as $key => $reportingOrganization) {
            $reportingOrgForm = sprintf('reporting_org.%s', $key);
            $messages[sprintf('%s.type.%s', $reportingOrgForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.reporting_org_type')]
            );
            $messages[sprintf('%s.type.%s', $reportingOrgForm, 'required')] = trans(
                'validation.required',
                [
                    'attribute' => trans('elementForm.reporting_org_type'),
                ]
            );
            $messages[sprintf('%s.secondary_reporter.%s', $reportingOrgForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.reporting_org_secondary_reporter')]
            );
            $messages[sprintf('%s.narrative.0.narrative.%s', $reportingOrgForm, 'required')] = trans(
                'validation.required',
                [
                    'attribute' => trans('elementForm.reporting_org_narrative'),
                ]
            );
        }

        return $messages;
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
