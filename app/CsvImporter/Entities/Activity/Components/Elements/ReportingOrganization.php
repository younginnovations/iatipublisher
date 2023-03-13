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
     * @var array
     */
    public array $reportingOrg = [];

    /**
     * @var string|int
     */
    public string|int $temp = '';

    /**
     * Csv Header for ReportingOrganization element.
     * @var array
     */
    private array $_csvHeaders = ['reporting_org_secondary_reporter'];

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
     * @param            $reportingOrg
     * @param Validation $factory
     */
    public function __construct($fields, $reportingOrg, Validation $factory)
    {
        $this->reportingOrg = $reportingOrg;
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = (new ReportingOrgRequest())->reportingOrganisationInOrganisation($reportingOrg);
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
        $this->data['reporting_org'] = $this->reportingOrg;

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
            $this->setSecondaryReporter($key, $index, $value);
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
        $this->temp = $value;
        $this->data['reporting_org'][$index]['secondary_reporter'] = $value;
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function rules(): array
    {
        return $this->request->getWarningForReportingOrganization(Arr::get($this->data, 'reporting_org', []));
    }

    /**
     * Error rules for reporting org.
     *
     * @return array
     */
    public function errorRules(): array
    {
        return $this->request->getErrorsForReportingOrganization(Arr::get($this->data, 'reporting_org', []));
    }

    /**
     * Critical error rules for reporting org.
     *
     * @return array
     */
    public function criticalErrors(): array
    {
        return $this->request->getCriticalErrorsForReportingOrganization(Arr::get($this->data, 'reporting_org', []));
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
        $this->errorValidator = $this->factory->sign($this->data())
            ->with($this->errorRules(), $this->messages())
            ->getValidatorInstance();
        $this->criticalValidator = $this->factory->sign($this->data())
            ->with($this->criticalErrors(), $this->messages())
            ->getValidatorInstance();

        $this->setValidity();

        return $this;
    }
}
