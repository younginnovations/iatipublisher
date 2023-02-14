<?php

declare(strict_types=1);

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
    protected array $data = [];

    /**
     * @var Activity
     */
    public Activity $activity;

    /**
     * @var string
     */
    protected string $csvIdentifier = 'activity_identifier';

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
     * @param $orgId
     * @param $userId
     * @param $activityIdentifiers
     *
     * @throws \JsonException
     */
    public function handle($orgId, $userId, $activityIdentifiers, $organizationReportingOrg): void
    {
        $this->filterHeader();

        if ($this->isCorrectCsv()) {
            $this->groupValues();

            $this->initActivity(['organization_id' => $orgId, 'user_id' => $userId, 'activity_identifiers' => $activityIdentifiers, 'reporting_org' => $organizationReportingOrg]);

            $this->activity->process();
        } else {
            throw new \RuntimeException('Mismatch CSV header');
        }
    }

    /**
     * Initialize an object for the Activity class with the provided options.
     *
     * @param array $options
     *
     * @return void
     */
    protected function initActivity(array $options = []): void
    {
        $this->activity = new Activity($this->data, Arr::get($options, 'organization_id'), Arr::get($options, 'user_id'), Arr::get($options, 'activity_identifiers'), Arr::get($options, 'reporting_org'));
    }

    /**
     * Group rows into single Activities.
     *
     * @return void
     */
    protected function groupValues(): void
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
        $this->data[$index][$key][] = $value;
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
        return is_null($row[$this->csvIdentifier]) || $row[$this->csvIdentifier] === '';
    }

    /**
     * Check if the headers are correct according to the provided template.
     *
     * @return bool
     */
    public function isCorrectCsv(): bool
    {
        if (!$this->csv) {
            return false;
        }

        return $this->hasCorrectHeaders();
    }

    /**
     * Filter unwanted keys generated while copying and pasting csv headers. For ex 0 index.
     *
     * @return void
     */
    protected function filterHeader(): void
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
