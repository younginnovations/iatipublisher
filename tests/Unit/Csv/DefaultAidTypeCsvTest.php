<?php

namespace Tests\Unit\Csv;

use App\CsvImporter\Entities\Activity\Components\Elements\DefaultAidType;
use Illuminate\Support\Arr;

class DefaultAidTypeCsvTest extends CsvBaseTest
{
    /**
     * Collects validation error messages.
     *
     * @throws \JsonException
     */
    public function getErrors($rows): array
    {
        $errors = [];
        foreach ($rows as $row) {
            $element = new DefaultAidType($row, $this->validation);
            $element->validate()->withErrors();

            if (!empty($element->errors()) || !empty($element->criticals()) || !empty($element->warnings())) {
                $errors[] = $element->errors() + $element->criticals() + $element->warnings();
            }
        }

        return $errors;
    }

    /**
     * Pass if all data are valid.
     *
     * @return void
     * @test
     * @throws \JsonException
     */
    public function pass_if_valid_data(): void
    {
        $this->signIn();
        $rows = $this->valid_data();
        $errors = $this->getErrors($rows);
        $flattenErrors = Arr::flatten($errors);
        $this->assertEmpty($flattenErrors);
    }

    /**
     * Valid data.
     * @return array
     */
    public function valid_data(): array
    {
        $data = $this->completeData;
        $data[0]['default_aid_type_vocabulary'] = ['1', '2', '3', '4'];
        $data[0]['default_aid_type_code'] = ['A01', '1', 'A', '1'];

        $data[1]['default_aid_type_vocabulary'] = ['1', '2', '3', '4'];
        $data[1]['default_aid_type_code'] = ['A01', '1', 'A', '1'];

        return $data;
    }

    /**
     * Throws validation messages for all invalid data.
     * @throws \JsonException
     * @test
     */
    public function throw_validation_if_invalid_data(): void
    {
        $this->signIn();
        $rows = $this->invalid_data();
        $errors = $this->getErrors($rows);
        $flattenErrors = Arr::flatten($errors);

        $this->assertContains('The default aid type is invalid.', $flattenErrors);
        $this->assertContains('The default aid type vocabulary is invalid.', $flattenErrors);
        $this->assertContains('The default aid type cash and voucher modalities is invalid.', $flattenErrors);
        $this->assertContains('The default aid type earmarking modality is invalid.', $flattenErrors);
        $this->assertContains('The default aid type earmarking category is invalid.', $flattenErrors);
        $this->assertContains('The default aid type is invalid.', $flattenErrors);
    }

    /**
     * Invalid Default Aid Type.
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeData;
        $data[0]['default_aid_type_vocabulary'] = ['1', '2', '3', '4', 'asdf'];
        $data[0]['default_aid_type_code'] = ['asdfadsf', 'asdf', 'Aasf', '1asdf', 'adsf'];

        $data[1]['default_aid_type_vocabulary'] = ['1', '2', '3', '4'];
        $data[1]['default_aid_type_code'] = ['A01', '1', 'A', '1'];

        return $data;
    }
}
