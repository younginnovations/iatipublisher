<?php

namespace Tests\Unit\Csv;

use App\CsvImporter\Entities\Activity\Components\Elements\ContactInfo;
use Illuminate\Support\Arr;

/**
 * Class ContactInfoCsvTest.
 */
class ContactInfoCsvTest extends CsvBaseTest
{
    /**
     * Collects error messages.
     *
     * @param $rows
     * @return array
     * @throws \JsonException
     */
    public function getErrors($rows): array
    {
        $errors = [];

        foreach ($rows as $row) {
            $reportingOrg = new ContactInfo($row, $this->validation);
            $reportingOrg->validate()->withErrors();

            if (!empty($reportingOrg->errors()) || !empty($reportingOrg->criticals()) || !empty($reportingOrg->warnings())) {
                $errors[] = $reportingOrg->errors() + $reportingOrg->criticals() + $reportingOrg->warnings();
            }
        }

        return $errors;
    }

    /**
     * All valid data.
     *
     * @return array
     */
    public function valid_data(): array
    {
        $data = $this->completeData;
        $data[0]['contact_type'] = ['1'];
        $data[0]['contact_organization'] = ['org 1'];
        $data[0]['contact_department'] = ['contact dept 1'];
        $data[0]['contact_person_name'] = ['contact person 1'];
        $data[0]['contact_job_title'] = ['contact job title'];
        $data[0]['contact_telephone'] = ['9999999999'];
        $data[0]['contact_email'] = ['email@gmail.com'];
        $data[0]['contact_website'] = ['https://www.google.com'];
        $data[0]['contact_mailing_address'] = ['contact mailing address'];

        $data[1]['contact_type'] = [];
        $data[1]['contact_organization'] = [];
        $data[1]['contact_department'] = [];
        $data[1]['contact_person_name'] = [];
        $data[1]['contact_job_title'] = [];
        $data[1]['contact_telephone'] = [];
        $data[1]['contact_email'] = [];
        $data[1]['contact_website'] = [];
        $data[1]['contact_mailing_address'] = [];

        return $data;
    }

    /**
     * Pass if all valid data.
     *
     * @return void
     * @test
     * @throws \JsonException
     */
    public function pass_if_all_valid_data(): void
    {
        $this->signIn();
        $rows = $this->valid_data();
        $errors = $this->getErrors($rows);
        $flattenErrors = Arr::flatten($errors);
        $this->assertEmpty($flattenErrors);
    }

    /**
     * Throw validation messages for all invalid data.
     *
     * @return void
     * @throws \JsonException
     * @test
     */
    public function throw_validation_if_invalid_data(): void
    {
        $this->signIn();
        $rows = $this->invalid_data();
        $errors = $this->getErrors($rows);
        $flattenErrors = Arr::flatten($errors);

        $this->assertContains('The contact info type is invalid.', $flattenErrors);
        $this->assertContains('The contact info telephone number is invalid.', $flattenErrors);
        $this->assertContains('The contact info telephone number must have atleast 7 digits.', $flattenErrors);
        $this->assertContains('The contact info telephone number must not have more than 20 digits.', $flattenErrors);
        $this->assertContains('The contact info email must be valid. The contact info email format is invalid.', $flattenErrors);
        $this->assertContains('The contact info website url must be valid url.', $flattenErrors);
    }

    /**
     * Invalid Contact info data.
     *
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->valid_data();
        $data[0]['contact_type'] = ['invalid type'];
        $data[0]['contact_organization'] = ['org 1'];
        $data[0]['contact_department'] = ['contact dept 1'];
        $data[0]['contact_person_name'] = ['contact person 1'];
        $data[0]['contact_job_title'] = ['contact job title'];
        $data[0]['contact_telephone'] = ['asfdsaf'];
        $data[0]['contact_email'] = ['invalid email'];
        $data[0]['contact_website'] = ['invalid url'];
        $data[0]['contact_mailing_address'] = ['contact mailing address'];

        $data[1]['contact_telephone'] = ['123'];
        $data[2]['contact_telephone'] = ['123456789012345678901'];

        return $data;
    }
}
