<?php

declare(strict_types=1);

namespace Tests\Unit\Csv;

use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\CsvImporter\Queue\CsvProcessor;
use App\Imports\CsvToArrayWithHeaders;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Tests\Unit\ImportBaseTest;

/**
 * Class CsvBaseTest.
 */
class CsvBaseTest extends ImportBaseTest
{
    /**
     * @var string
     */
    private string $completeCsvFile = 'tests/Unit/TestFiles/Csv/complete.csv';

    /**
     * @var string
     */
    public string $csvFile;
    /**
     * @var object
     */
    protected object $validation;

    /**
     * @var array
     */
    protected array $completeData;

    /**
     * @return void
     * @throws BindingResolutionException
     * @throws \ReflectionException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->validation = app()->make(Validation::class);
        $this->getCompleteData();
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

        foreach ($data as $rows) {
            fputcsv($fp, $rows);
        }

        fclose($fp);
    }

    /**
     * Fetches csv rows in to array.
     *
     * @param $filePath
     * @return array
     * @throws \ReflectionException
     * @throws BindingResolutionException
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

    /**
     * Sets 100% complete csv file to array variable.
     *
     * @return void
     * @throws BindingResolutionException
     * @throws \ReflectionException
     */
    public function getCompleteData(): void
    {
        $this->completeData = $this->getCsvRows($this->completeCsvFile);
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->csvFile, $this->validation, $this->completeData, $this->user, $this->organization);
    }
}
