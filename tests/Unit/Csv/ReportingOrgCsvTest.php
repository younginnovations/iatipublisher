<?php

namespace Tests\Unit\Csv;

use App\CsvImporter\Entities\Activity\Components\Elements\ReportingOrganization;
use Illuminate\Support\Arr;

class ReportingOrgCsvTest extends CsvBaseTest
{
    /**
     * All value invalid for reporting org and its related data
     * and test if related validation exists.
     *
     * @return void
     * @test
     * @throws \JsonException
     */
    public function check_throws_validation_if_invalid_data(): void
    {
        $this->signIn();
        $rows = $this->reporting_org_invalid_data();
        $errors = [];

        foreach ($rows as $row) {
            $reportingOrg = new ReportingOrganization($row, $this->validation);
            $reportingOrg->validate()->withErrors();

            if (!empty($reportingOrg->errors()) || !empty($reportingOrg->criticals()) || !empty($reportingOrg->warnings())) {
                $errors[] = $reportingOrg->errors() + $reportingOrg->criticals() + $reportingOrg->warnings();
            }
        }

        $flattenErrors = Arr::flatten($errors);

        $this->assertContains('The reporting organisation should not have multiple values or narratives.', $flattenErrors);
        $this->assertContains('The type for reporting organisation is invalid.', $flattenErrors);
        $this->assertContains('The selected reporting org.0.secondary reporter is invalid.', $flattenErrors);
        $this->assertContains('The reference format for reporting organisation is invalid.', $flattenErrors);
    }

    /**
     * @return array
     */
    public function reporting_org_invalid_data(): array
    {
        $data = $this->completeData;
        $data[0]['reporting_org_reference'] = ['reference 1', 'reference 2']; // multiple not allowed
        $data[0]['reporting_org_type'] = ['0000', '99999']; // this type not available
        $data[0]['reporting_org_secondary_reporter'] = [10]; // invalid type as it should be 1 or 0
        $data[0]['reporting_org_narrative'] = ['narrative one', 'narrative two'];

        $data[1]['reporting_org_reference'] = ['\//adsfasf||nice']; // multiple not allowed
        $data[1]['reporting_org_type'] = null;
        $data[1]['reporting_org_secondary_reporter'] = null;
        $data[1]['reporting_org_narrative'] = null;

        return $data;
    }

    /**
     * All the reporting org data are valid
     * Should not contain any errors i.e. $errors array should be empty.
     *
     * @return void
     * @test
     * @throws \JsonException
     */
    public function check_if_passes_when_valid_data_reporting_org(): void
    {
        $this->signIn();
        $rows = $this->reporting_org_valid_data();
        $errors = [];

        foreach ($rows as $row) {
            $reportingOrg = new ReportingOrganization($row, $this->validation);
            $reportingOrg->validate()->withErrors();

            if (!empty($reportingOrg->errors()) || !empty($reportingOrg->criticals()) || !empty($reportingOrg->warnings())) {
                $errors[] = $reportingOrg->errors() + $reportingOrg->criticals() + $reportingOrg->warnings();
            }
        }

        $flattenErrors = Arr::flatten($errors);
        $this->assertEmpty($flattenErrors);
    }

    /**
     * @return array
     */
    public function reporting_org_valid_data(): array
    {
        $data = $this->completeData;
        $data[0]['reporting_org_reference'] = ['reference 1']; // multiple not allowed
        $data[0]['reporting_org_type'] = ['11']; // this type not available
        $data[0]['reporting_org_secondary_reporter'] = [1]; // invalid type as it should be 1 or 0
        $data[0]['reporting_org_narrative'] = ['narrative one'];
        $data[1]['reporting_org_reference'] = ['reference 2']; // multiple not allowed
        $data[1]['reporting_org_type'] = ['10'];
        $data[1]['reporting_org_secondary_reporter'] = [0];
        $data[1]['reporting_org_narrative'] = ['narrative two'];

        return $data;
    }
}
