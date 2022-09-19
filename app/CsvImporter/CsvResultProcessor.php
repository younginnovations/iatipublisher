<?php

declare(strict_types=1);

namespace App\Services\CsvImporter;

use App\CsvImporter\Entities\Activity\Result\Result;
// use Maatwebsite\Excel\Excel;
use App\Imports\CsvToArrayWithHeaders;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class CsvProcessor.
 */
class CsvResultProcessor
{
    /**
     * @var
     */
    protected $csv;

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var
     */
    public $result;

    /**
     * @var array|string[]
     */
    protected array $csvIdentifier = ['type', 'aggregation_status'];

    /**
     * Total no. of header present in basic csv version 203.
     */
    public const CSV_HEADERS_COUNT = 69;

    /**
     * CsvProcessor constructor.
     * @param $csv
     */
    public function __construct($csv)
    {
        $this->csv = $csv;
    }

    /**
     * Handle the import functionality.
     *
     * @param $organizationId
     * @param $userId
     *
     * @return void
     */
    public function handle($organizationId, $userId): void
    {
        if ($this->isCorrectCsv()) {
            $this->groupValues();
            $this->initResult(['organization_id' => $organizationId, 'user_id' => $userId]);
            $this->result->process();
        } else {
            $filepath = storage_path('csvImporter/tmp/result/' . $organizationId);
            $filename = 'header_mismatch.json';

            if (!file_exists($filepath)) {
                mkdir($filepath, 0777, true);
            }

            file_put_contents($filepath . '/' . $filename, json_encode(['mismatch' => true]));
        }
    }

    /**
     * Fix file permission while on staging environment.
     *
     * @param $path
     *
     * @return void
     */
    protected function fixStagingPermission($path): void
    {
        // TODO: Remove this.
        shell_exec(sprintf('chmod 777 -R %s', $path));
    }

    /**
     * Initialize an object for the Result class with the provided options.
     *
     * @param array $options
     *
     * @return void
     */
    protected function initResult(array $options = []): void
    {
        if (class_exists(Result::class)) {
            // $this->result = app()->make(Result::class, [$this->data, Arr::get($options, ['organization_id']), Arr::get($options, ['user_id'])]);
            $this->result = new Result($this->data, Arr::get($options, 'organization_id'), Arr::get($options, 'user_id'));
        }
    }

    /**
     * Group rows into single Results.
     *
     * @return void
     */
    protected function groupValues(): void
    {
        $index = -1;

        $this->data[0]['type'] = null;
        $this->data[0]['aggregation_status'] = null;

        foreach ($this->csv as $row) {
            if (!$this->isSameEntity($row)) {
                $index++;

                $this->data[$index]['type'] = null;
                $this->data[$index]['aggregation_status'] = null;
            }

            $this->group($row, $index);
        }
    }

    /**
     * Group the values of a row to a specific index.
     *
     * @param $row
     * @param $index
     *
     * @return void
     */
    protected function group($row, $index): void
    {
        foreach ($row as $key => $value) {
            $this->setValue($index, $key, $value);
        }
    }

    /**
     * Set the provided value to the provided key/index.
     *
     * @param $index
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setValue($index, $key, $value): void
    {
        if ($index >= 0) {
            $this->data[$index][$key][] = $value;
        }
    }

    /**
     * Check if the next row is new row or not.
     *
     * @param $row
     *
     * @return bool
     */
    protected function isSameEntity($row): bool
    {
        if (is_null($row[$this->csvIdentifier[0]]) || $row[$this->csvIdentifier[0]] === '') {
            if (is_null($row[$this->csvIdentifier[1]]) || $row[$this->csvIdentifier[1]] === '') {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the headers are correct according to the provided template.
     *
     * @return bool
     */
    protected function isCorrectCsv(): bool
    {
        if (!$this->csv) {
            return false;
        }

        return $this->hasCorrectHeaders();
    }

    /**
     * Load Csv template.
     *
     * @param $filename
     *
     * @return mixed
     */
    protected function loadTemplate($filename): mixed
    {
        $file = Excel::toCollection(new CsvToArrayWithHeaders, app_path(sprintf('CsvImporter/Templates/Activity/%s.csv', $filename)))->first();

        return $file->toArray();
    }

    /**
     * Check if the difference of the csv headers is empty.
     *
     * @param array $diffHeaders
     *
     * @return bool
     */
    protected function isSameCsvHeader(array $diffHeaders): bool
    {
        if (empty($diffHeaders)) {
            return true;
        }

        return false;
    }

    /**
     * Check if the headers are correct for the uploaded Csv File.
     *
     * @param $csvHeaders
     * @param $templateFileName
     *
     * @return bool
     */
    protected function checkHeadersFor($csvHeaders, $templateFileName): bool
    {
        $templateHeaders = $this->loadTemplate($templateFileName);
        $templateHeaders = array_keys($templateHeaders[0]);
        $diffHeaders = array_diff($csvHeaders, $templateHeaders);

        return $this->isSameCsvHeader($diffHeaders);
    }

    /**
     * Check if the headers for the uploaded Csv file matches with the provided header count.
     *
     * @param array $actualHeaders
     * @param       $providedHeaderCount
     *
     * @return bool
     */
    protected function headerCountMatches(array $actualHeaders, $providedHeaderCount): bool
    {
        return count($actualHeaders) === $providedHeaderCount;
    }

    /**
     * Check if the uploaded Csv file has correct headers.
     *
     * @return bool
     */
    protected function hasCorrectHeaders(): bool
    {
        $csvHeaders = array_keys($this->csv[0]);
        $headerCount = self::CSV_HEADERS_COUNT;

        if ($this->headerCountMatches($csvHeaders, $headerCount)) {
            return $this->checkHeadersFor($csvHeaders, 'result');
        }

        return false;
    }
}
