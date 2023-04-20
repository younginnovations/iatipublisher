<?php

namespace Tests\Unit\Xml;

use App\XlsImporter\Foundation\Mapper\Activity;
use App\XlsImporter\Foundation\XlsProcessor\XlsToArray;
use Arr;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * Class ImportActivityTest.
 */
class ImportActivityTest extends TestCase
{
    /**
     * Throw validation for all invalid data.
     *
     * @return void
     */
    public function test_processed_data_against_actual_data(): void
    {
        $systemDataFilePath = 'tests/Unit/TestFiles/Xls/SystemData/activity.json';
        $xlsfilePath = 'tests/Unit/TestFiles/Xls/XlsData/Activity.xlsx';
        $actualData = json_decode(file_get_contents($systemDataFilePath), true, 512, 0);
        $xlsToArray = new XlsToArray();
        Excel::import($xlsToArray, $xlsfilePath);
        $xlsData = $xlsToArray->sheetData;

        $xlsMapper = new Activity();
        // $xlsMapper->initMapper($validatedDataFilePath, $statusFilePath, $dbIatiIdentifiers);

        // if ($xlsType === 'activity') {
        $xlsMapper->fillOrganizationReportingOrg(null);
        // }

        $xlsMapper->map($xlsData);
        $processedData = $xlsMapper->getActivityData();

        foreach ($actualData as $key => $value) {
            $elementData = Arr::get($processedData, $key, []);
            // $value = Arr::dot($value);
            // dump('testing ' . $key, $elementData, $value);
            // dump('testing ' . $key);

            if (is_array($value) && is_array($elementData)) {
                dump(Arr::dot($value), Arr::dot($elementData));
                $difference = array_diff_assoc(Arr::dot($value), Arr::dot($elementData));
                dump('difference', $difference);
                $this->assertTrue(empty($difference));
            } elseif ($elementData !== $value && !(empty($value) && empty($elementData))) {
                // dump($value, $elementData, empty($value) && empty($elementData), empty($value), empty($elementData));
                $this->assertTrue(false);
            }
        }
    }

    public function test_validation_message_of_processed_data(): void
    {
        $xlsfilePath = 'tests/Unit/TestFiles/Xls/XlsData/Activity.xlsx';
        $xlsToArray = new XlsToArray();
        Excel::import($xlsToArray, $xlsfilePath);
        $xlsData = $xlsToArray->sheetData;

        $xlsMapper = new Activity();
        $xlsMapper->fillOrganizationReportingOrg(null);

        $xlsMapper->map($xlsData);
        $processedData = $xlsMapper->getActivityData();

        foreach ($processedData as $key => $value) {
            $elementData = Arr::get($processedData, $key, []);
            // $value = Arr::dot($value);
            // dump('testing ' . $key, $elementData, $value);
            // dump('testing ' . $key);

            // if (is_array($value) && is_array($elementData)) {
            //     dump(Arr::dot($value), Arr::dot($elementData));
            //     $difference = array_diff_assoc(Arr::dot($value), Arr::dot($elementData));
            //     dump('difference', $difference);
            //     $this->assertTrue(empty($difference));
            // } elseif ($elementData !== $value && !(empty($value) && empty($elementData))) {
            //     // dump($value, $elementData, empty($value) && empty($elementData), empty($value), empty($elementData));
            //     $this->assertTrue(false);
            // }
        }
    }
}
