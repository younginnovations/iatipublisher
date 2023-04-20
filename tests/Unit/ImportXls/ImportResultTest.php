<?php

namespace Tests\Unit\Xml;

use App\XlsImporter\Foundation\Mapper\Result;
use App\XlsImporter\Foundation\XlsProcessor\XlsToArray;
use Arr;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * Class ImportResultTeest.
 */
class ImportResultTest extends TestCase
{
    /**
     * Throw validation for all invalid data.
     *
     * @return void
     */
    public function test_processed_data_against_actual_data(): void
    {
        $systemDataFilePath = 'tests/Unit/TestFiles/Xls/SystemData/result.json';
        $xlsfilePath = 'tests/Unit/TestFiles/Xls/XlsData/Result.xlsx';
        $actualData = json_decode(file_get_contents($systemDataFilePath), true, 512, 0);
        $xlsToArray = new XlsToArray();
        Excel::import($xlsToArray, $xlsfilePath);
        $xlsData = $xlsToArray->sheetData;

        $xlsMapper = new Result();
        $xlsMapper->map($xlsData);
        $processedData = $xlsMapper->getResultData();

        foreach ($actualData as $key => $value) {
            $elementData = Arr::get($processedData, $key, []);
            if (is_array($value) && is_array($elementData)) {
                $difference = array_diff_assoc(Arr::dot($value), Arr::dot($elementData));
                $this->assertTrue(empty($difference));
            } elseif ($elementData !== $value && !(empty($value) && empty($elementData))) {
                $this->assertTrue(false);
            }
        }
    }
}
