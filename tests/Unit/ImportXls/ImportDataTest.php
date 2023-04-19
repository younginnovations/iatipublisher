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
        $filePath = 'tests/Unit/TestFiles/Csv/complete.csv';
        $actualData = file_get_contents($filePath);
        $xlsToArray = new XlsToArray();
        Excel::import($xlsToArray, $filePath);
        $xlsData = $xlsToArray->sheetData;

        $xlsMapper = new Activity();
        // $xlsMapper->initMapper($validatedDataFilePath, $statusFilePath, $dbIatiIdentifiers);

        // if ($xlsType === 'activity') {
        //     $xlsMapper->fillOrganizationReportingOrg($orgRef);
        // }

        $xlsMapper->map($xlsData);
        // $processedData = json_encode();
        $this->assertEquals($actualData, $actualData);
    }
}
