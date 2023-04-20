<?php

namespace Tests\Unit\Xml;

use App\XlsImporter\Foundation\Mapper\Period;
use App\XlsImporter\Foundation\XlsProcessor\XlsToArray;
use Arr;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * Class ImportPeriodTest.
 */
class ImportPeriodTest extends TestCase
{
    /**
     * Throw validation for all invalid data.
     *
     * @return void
     */
    public function test_processed_data_against_actual_data(): void
    {
        $systemDataFilePath = 'tests/Unit/TestFiles/Xls/SystemData/period.json';
        $xlsfilePath = 'tests/Unit/TestFiles/Xls/XlsData/Period.xlsx';
        $actualData = json_decode(file_get_contents($systemDataFilePath), true, 512, 0);
        $xlsToArray = new XlsToArray();
        Excel::import($xlsToArray, $xlsfilePath);
        $xlsData = $xlsToArray->sheetData;

        $xlsMapper = new Period();

        $xlsMapper->map($xlsData);
        $processedData = $xlsMapper->getPeriodData();

        foreach ($actualData as $key => $value) {
            $elementData = Arr::get($processedData, $key, []);
            // $value = Arr::dot($value);
            // dump('testing ' . $key, $elementData, $value);
            dump('testing ' . $key);

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
}
