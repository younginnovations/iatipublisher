<?php

namespace Tests\Unit\Csv;

use App\CsvImporter\Entities\Activity\Components\Elements\PolicyMarker;
use Illuminate\Support\Arr;

class PolicyMakerCsvTest extends CsvBaseTest
{
    /**
     * Throw validation for all invalid data.
     * @return void
     * @test
     * @throws \JsonException
     */
    public function throw_all_possible_validation_if_invalid_data(): void
    {
        $this->signIn();
        $rows = $this->invalid_data();
        $errors = $this->getErrors($rows);
        $flattenErrors = Arr::flatten($errors);

        $this->assertContains('The policy marker vocabulary is invalid.', $flattenErrors);
        $this->assertContains('The policy marker significance is invalid.', $flattenErrors);
        $this->assertContains('The policy marker code is invalid.', $flattenErrors);
        $this->assertContains('The @vocabulary-uri field must be a valid url.', $flattenErrors);
        $this->assertContains('The narrative field is required when vocabulary is reporting organisation.', $flattenErrors);
    }

    /**
     * Collects validation messages.
     * @param $rows
     * @return array
     * @throws \JsonException
     */
    public function getErrors($rows): array
    {
        $errors = [];
        foreach ($rows as $row) {
            $element = new PolicyMarker($row, $this->validation);
            $element->validate()->withErrors();

            if (!empty($element->errors()) || !empty($element->criticals()) || !empty($element->warnings())) {
                $errors[] = $element->errors() + $element->criticals() + $element->warnings();
            }
        }

        return $errors;
    }

    /**
     * Invalid data.
     *
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeData;
        $data[0]['policy_marker_vocabulary'] = ['1', '4354', '99']; // invalid vocab
        $data[0]['policy_marker_code'] = ['1', '123', '123']; // invalid marker code
        $data[0]['policy_marker_significance'] = ['1', '32423', '9887']; // invalid signaificane
        $data[0]['policy_marker_vocabulary_uri'] = ['', '', 'invalid uri']; // invalid url
        $data[0]['policy_marker_narrative'] = ['narr one', 'narr two', '']; // empty narrative when vocab 99

        $data[1]['policy_marker_vocabulary'] = ['99'];
        $data[1]['policy_marker_code'] = ['1'];
        $data[1]['policy_marker_significance'] = ['1'];
        $data[1]['policy_marker_vocabulary_uri'] = [''];
        $data[1]['policy_marker_narrative'] = [''];

        return $data;
    }
}
