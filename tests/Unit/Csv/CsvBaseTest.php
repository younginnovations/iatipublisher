<?php

namespace Tests\Unit\Csv;

use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\CsvImporter\Queue\CsvProcessor;
use App\Imports\CsvToArrayWithHeaders;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Tests\Unit\ImportBaseTest;

class CsvBaseTest extends ImportBaseTest
{
    /**
     * @var string
     */
    public string $csvFile;
    /**
     * @var object
     */
    protected object $validation;

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->validation = app()->make(Validation::class);
    }

    /**
     * Receives data set and makes csv files.
     *
     * @param array $data
     * @return void
     */
    public function initializeCsv(array $data): void
    {
        $dirname = dirname($this->csvFile);

        if (!is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }

        $fp = fopen($this->csvFile, 'w');
        foreach ($this->convertActivityData($data) as $rows) {
            fputcsv($fp, $rows);
        }

        fclose($fp);
    }

    /**
     * @param $data
     * @return array
     */
    public function convertActivityData($data): array
    {
        $keys = array_keys($data);
        $values = array_values($data);
        $num_rows = max(array_map('count', $values));
        $num_cols = count($keys);
        $new_data = [array_values($keys)];

        for ($i = 0; $i < $num_rows; $i++) {
            $row = [];
            for ($j = 0; $j < $num_cols; $j++) {
                if (isset($values[$j][$i])) {
                    $row[] = $values[$j][$i];
                } else {
                    $row[] = '';
                }
            }
            $new_data[] = $row;
        }

        return $new_data;
    }

    /**
     * Sets csv file path to generate csv.
     * @param $path
     * @return void
     */
    public function setCsvFilePath($path): void
    {
        $this->csvFile = $path;
    }

    /**
     * Fetches csv rows in to array.
     *
     * @param $filePath
     * @return array
     * @throws \ReflectionException
     */
    public function getCsvRows($filePath): array
    {
        $file = new UploadedFile($filePath, basename($filePath));
        $str = mb_convert_encoding(file_get_contents($file->getPathName()), 'UTF-8');
        file_put_contents($file->getPathName(), $str);
        $csv = Excel::toCollection(new CsvToArrayWithHeaders, $file)->first()->toArray();

        $csvProcessorObj = new CsvProcessor($csv);
        $csvProcessorObjReflection = new \ReflectionClass($csvProcessorObj);

        $groupvalues = $csvProcessorObjReflection->getMethod('groupValues');
        $groupvalues->setAccessible(true);
        $groupvalues->invoke($csvProcessorObj);

        $dataProperty = $csvProcessorObjReflection->getProperty('data');
        $dataProperty->setAccessible(true);

        return $dataProperty->getValue($csvProcessorObj);
    }
}
