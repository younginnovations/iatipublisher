<?php

namespace App\CsvImporter\Queue;

use App\CsvImporter\Entities\Activity\Activity;
use App\CsvImporter\Traits\ChecksCsvHeaders;
use Illuminate\Support\Arr;

/**
 * Class CsvProcessor.
 */
class CsvProcessor
{
    use ChecksCsvHeaders;

    /**
     * @var
     */
    protected $csv;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var Activity
     */
    public $activity;

    /**
     * @var string
     */
    protected $csvIdentifier = 'activity_identifier';

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
     * @param $organizationId
     * @param $userId
     * @param $activityIdentifiers
     */
    public function handle($organizationId, $userId, $activityIdentifiers, $version)
    {
        $this->filterHeader();
        if ($this->isCorrectCsv($version)) {
            $this->groupValues();

            $this->initActivity(['organization_id' => $organizationId, 'user_id' => $userId, 'activity_identifiers' => $activityIdentifiers, 'version' => $version]);

            $this->activity->process();
        } else {
            $filepath = storage_path('csvImporter/tmp/' . $organizationId . '/' . $userId);
            $filename = 'header_mismatch.json';

            if (!is_dir($filepath)) {
                mkdir($filepath, 0777, true);
            }

            file_put_contents($filepath . '/' . $filename, json_encode(['mismatch' => true]));
        }
    }

    /**
     * Initialize an object for the Activity class with the provided options.
     *
     * @param array $options
     */
    protected function initActivity(array $options = [])
    {
        $this->activity = new Activity($this->data, Arr::get($options, 'organization_id'), Arr::get($options, 'user_id'), Arr::get($options, 'activity_identifiers'), Arr::get($options, 'version'));
    }

    /**
     * Group rows into single Activities.
     */
    protected function groupValues()
    {
        $index = -1;

        foreach ($this->csv as $row) {
            if (!$this->isSameEntity($row)) {
                $index++;
            }

            $this->group($row, $index);
        }
    }

    /**
     * Group the values of a row to a specific index.
     * @param $row
     * @param $index
     */
    protected function group($row, $index)
    {
        foreach ($row as $key => $value) {
            $this->setValue($index, $key, $value);
        }
    }

    /**
     * Set the provided value to the provided key/index.
     * @param $index
     * @param $key
     * @param $value
     */
    protected function setValue($index, $key, $value)
    {
        $this->data[$index][$key][] = $value;
    }

    /**
     * Check if the next row is new row or not.
     * @param $row
     * @return bool
     */
    protected function isSameEntity($row)
    {
        if (is_null($row[$this->csvIdentifier]) || $row[$this->csvIdentifier] == '') {
            return true;
        }

        return false;
    }

    /**
     * Check if the headers are correct according to the provided template.
     * @return bool
     */
    protected function isCorrectCsv($version)
    {
        if (!$this->csv) {
            return false;
        }

        return $this->hasCorrectHeaders($version);
    }

    /**
     * Filter unwanted keys generated while copying and pasting csv headers. For ex 0 index.
     * @return mixed
     */
    protected function filterHeader()
    {
        foreach ($this->csv as $index => $csvHeaders) {
            foreach ($csvHeaders as $headerIndex => $header) {
                if ($headerIndex === 0) {
                    unset($this->csv[$index][$headerIndex]);
                }
            }
        }
    }
}
