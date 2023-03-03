<?php

namespace Tests\Unit\Csv;

use App\CsvImporter\Entities\Activity\Components\Elements\Location;
use Illuminate\Support\Arr;

class LocationCsvTest extends CsvBaseTest
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
            $reportingOrg = new Location($row, $this->validation);
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
        $data[0]['location_reference'] = ['ref 1'];
        $data[0]['location_reach_code'] = ['1'];
        $data[0]['location_id_vocabulary'] = ['A1'];
        $data[0]['location_id_code'] = ['code 1'];
        $data[0]['location_name'] = ['location name'];
        $data[0]['location_description'] = ['location description'];
        $data[0]['location_activity_description'] = ['activity description'];
        $data[0]['location_administrative_vocabulary'] = ['A1'];
        $data[0]['location_administrative_code'] = ['AF'];
        $data[0]['location_administrative_level'] = ['1'];
        $data[0]['location_point_srsname'] = ['srs name'];
        $data[0]['pos_latitude'] = ['1234.332'];
        $data[0]['pos_longitude'] = ['123.3333'];
        $data[0]['location_exactness'] = ['1'];
        $data[0]['location_class'] = ['1'];
        $data[0]['feature_designation'] = ['AIRQ'];

        $data[1]['location_reference'] = [];
        $data[1]['location_reach_code'] = [];
        $data[1]['location_id_vocabulary'] = [];
        $data[1]['location_id_code'] = [];
        $data[1]['location_name'] = [];
        $data[1]['location_description'] = [];
        $data[1]['location_activity_description'] = [];
        $data[1]['location_administrative_vocabulary'] = [];
        $data[1]['location_administrative_code'] = [];
        $data[1]['location_administrative_level'] = [];
        $data[1]['location_point_srsname'] = [];
        $data[1]['pos_latitude'] = [];
        $data[1]['pos_longitude'] = [];
        $data[1]['location_exactness'] = [];
        $data[1]['location_class'] = [];
        $data[1]['feature_designation'] = [];

        return $data;
    }

    /**
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
     * @return void
     * @test
     * @throws \JsonException
     */
    public function throw_validation_if_invalid_data(): void
    {
        $this->signIn();
        $rows = $this->invalid_data();
        $errors = $this->getErrors($rows);
        $flattenErrors = Arr::flatten($errors);

        $this->assertContains('The location reference field shouldn\'t contain the symbols /, &, | or ?.', $flattenErrors);
        $this->assertContains('The location reach code is invalid.', $flattenErrors);
        $this->assertContains('The location exactness is invalid.', $flattenErrors);
        $this->assertContains('The location class is invalid.', $flattenErrors);
        $this->assertContains('The location feature designation is invalid.', $flattenErrors);
        $this->assertContains('The location id vocabulary is invalid.', $flattenErrors);
        $this->assertContains('The location administrative vocabulary is invalid.', $flattenErrors);
        $this->assertContains('The location administrative code is invalid.', $flattenErrors);
        $this->assertContains('The location administrative level must not have negative value.', $flattenErrors);
        $this->assertContains('The location administrative level must be an integer.', $flattenErrors);
        $this->assertContains('The pos latitude must be numeric', $flattenErrors);
        $this->assertContains('The pos longitude must be numeric', $flattenErrors);
    }

    public function invalid_data(): array
    {
        $data = $this->valid_data();
        $data[1]['location_reference'] = ['//'];
        $data[1]['location_reach_code'] = ['invalid reach code'];
        $data[1]['location_id_vocabulary'] = ['invalid vocabulary'];
        $data[1]['location_id_code'] = [];
        $data[1]['location_name'] = [];
        $data[1]['location_description'] = [];
        $data[1]['location_activity_description'] = [];
        $data[1]['location_administrative_vocabulary'] = ['invalid vocabulary'];
        $data[1]['location_administrative_code'] = ['invalid code'];
        $data[1]['location_administrative_level'] = ['invalid ldevel', '-123'];
        $data[1]['location_point_srsname'] = [];
        $data[1]['pos_latitude'] = ['not numeric'];
        $data[1]['pos_longitude'] = ['not numeric'];
        $data[1]['location_exactness'] = ['invalid exactness'];
        $data[1]['location_class'] = ['invalid class'];
        $data[1]['feature_designation'] = ['invalid desgnation'];

        return $data;
    }
}
