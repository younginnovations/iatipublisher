<?php

namespace Tests\Unit\Csv;

use App\CsvImporter\Entities\Activity\Components\Elements\DocumentLink;
use Illuminate\Support\Arr;

class DocumentLinkCsvTest extends CsvBaseTest
{
    /**
     * @param $rows
     * @return array
     * @throws \JsonException
     */
    public function getErrors($rows): array
    {
        $errors = [];

        foreach ($rows as $row) {
            $reportingOrg = new DocumentLink($row, $this->validation);
            $reportingOrg->validate()->withErrors();

            if (!empty($reportingOrg->errors()) || !empty($reportingOrg->criticals()) || !empty($reportingOrg->warnings())) {
                $errors[] = $reportingOrg->errors() + $reportingOrg->criticals() + $reportingOrg->warnings();
            }
        }

        return $errors;
    }

    public function valid_data(): array
    {
        $data = $this->completeData;
        $data[0]['document_link_url'] = ['https://www.google.com'];
        $data[0]['document_link_format'] = ['application/A2L'];
        $data[0]['document_link_title'] = ['title one'];
        $data[0]['document_link_description'] = ['title description'];
        $data[0]['document_link_category'] = ['A01'];
        $data[0]['document_link_language'] = ['aa'];
        $data[0]['document_date'] = ['01/12/2022'];

        $data[1]['document_link_url'] = ['https://www.google.com'];
        $data[1]['document_link_format'] = ['application/A2L'];
        $data[1]['document_link_title'] = ['title one'];
        $data[1]['document_link_description'] = ['title description'];
        $data[1]['document_link_category'] = ['A01'];
        $data[1]['document_link_language'] = ['aa'];
        $data[1]['document_date'] = ['01/12/2022'];

        return $data;
    }

    /**
     * @throws \JsonException
     * @test
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
        $this->assertContains('The document link format is invalid', $flattenErrors);
        $this->assertContains('The @url field must be a valid url.', $flattenErrors);
        $this->assertContains('The @iso-date field must be a proper date.', $flattenErrors);
        $this->assertContains('The @iso-date field must be a greater than 1900.', $flattenErrors);
        $this->assertContains('The document link category code field must be a unique.', $flattenErrors);
        $this->assertContains('The document link category code is invalid.', $flattenErrors);
        $this->assertContains('The document link language code field must be a unique.', $flattenErrors);
        $this->assertContains('The document link language code is invalid.', $flattenErrors);
    }

    /**
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->valid_data();
        $data[0]['document_link_url'] = ['invalid url'];
        $data[0]['document_link_format'] = ['invalid format'];
        $data[0]['document_link_title'] = ['title one'];
        $data[0]['document_link_description'] = ['title description'];
        $data[0]['document_link_category'] = ['invalid category', 'A01', 'A01'];
        $data[0]['document_link_language'] = ['invalid language'];
        $data[0]['document_date'] = ['invalid date format', '01/12/1300']; // before 1900

        return $data;
    }
}
