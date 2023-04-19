<?php

namespace Tests\Unit\Xml;

use App\XlsImporter\Foundation\Mapper\Activity;
use App\XlsImporter\Foundation\XlsProcessor\XlsToArray;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * Class ImportDataTest.
 */
class ImportDataTest extends TestCase
{
    /**
     * Throw validation for all invalid data.
     *
     * @return void
     */
    public function test_validate_processed_data_against_actual_data(): void
    {
        $systemDataFilePath = 'tests/Unit/TestFiles/Xls/SystemData/activity.json';
        $xlsfilePath = 'tests/Unit/TestFiles/Xls/XlsData/Activity.xlsx';
        $actualData = file_get_contents($systemDataFilePath);
        $xlsToArray = new XlsToArray();
        Excel::import($xlsToArray, $xlsfilePath);
        $xlsData = $xlsToArray->sheetData;
        file_put_contents('tests/Unit/TestFiles/Xls/xlsData.json', json_encode($xlsData));
        dd('stop');

        $xlsMapper = new Activity();
        // $xlsMapper->initMapper($validatedDataFilePath, $statusFilePath, $dbIatiIdentifiers);

        // if ($xlsType === 'activity') {
        //     $xlsMapper->fillOrganizationReportingOrg($orgRef);
        // }

        $xlsMapper->map($xlsData);
        $processedData = json_encode($xlsMapper->getActivityData());
        file_put_contents('tests/Unit/TestFiles/Xls/activity-processed.json', $processedData);
        $this->assertEquals($actualData, $processedData);
    }
}
