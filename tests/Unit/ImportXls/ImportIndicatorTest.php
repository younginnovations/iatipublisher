<?php

namespace Tests\Unit\Xml;

use App\XlsImporter\Foundation\Mapper\Indicator;
use App\XlsImporter\Foundation\XlsProcessor\XlsToArray;
use Arr;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * Class ImportIndicatorTest.
 */
class ImportIndicatorTest extends TestCase
{
    /**
     * Throw validation for all invalid data.
     *
     * @return void
     */
    public function test_processed_data_against_actual_data(): void
    {
        $systemDataFilePath = 'tests/Unit/TestFiles/Xls/SystemData/indicator.json';
        $xlsfilePath = 'tests/Unit/TestFiles/Xls/XlsData/Indicator.xlsx';
        $actualData = json_decode(file_get_contents($systemDataFilePath), true, 512, 0);
        $xlsToArray = new XlsToArray();
        Excel::import($xlsToArray, $xlsfilePath);
        $xlsData = $xlsToArray->sheetData;

        $xlsMapper = new Indicator();
        $xlsMapper->map($xlsData);
        $processedData = $xlsMapper->getIndicatorData();
        // dd($processedData);

        foreach ($actualData as $key => $value) {
            $elementData = Arr::get($processedData, $key, []);
            if (is_array($value) && is_array($elementData)) {
                dump(Arr::dot($value), Arr::dot($elementData));
                $difference = array_diff_assoc(Arr::dot($value), Arr::dot($elementData));
                dump('difference:', $difference);
                $this->assertTrue(empty($difference));
            } elseif ($elementData !== $value && !(empty($value) && empty($elementData))) {
                dd($elementData, $value);
                // $this->assertTrue(false);
            }
        }
    }
}
