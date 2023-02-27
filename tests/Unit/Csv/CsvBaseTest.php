<?php

namespace Tests\Unit\Csv;

use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Unit\ImportBaseTest;

class CsvBaseTest extends ImportBaseTest
{
    private string $csvFile = 'tests/Unit/TestFiles/Csv/file.csv';
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
        $savedKeys = [];

        foreach ($data as $getKey => $value) {
            $savedKeys[] = $getKey;
        }

        $savedKeys = array_unique($savedKeys);
        fputcsv($fp, $savedKeys);

        foreach ($data as $fields) {
            foreach ($savedKeys as $checkKey) {
                if (!isset($field[$checkKey])) {
                    $field[$checkKey] = '';
                }
            }
            fputcsv($fp, $fields);
        }

        fclose($fp);
    }
}
