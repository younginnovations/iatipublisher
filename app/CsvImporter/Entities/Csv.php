<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities;

use App\CsvImporter\Entities\Activity\Components\ActivityRow;

/**
 * Class Csv.
 */
abstract class Csv
{
    /**
     * @var
     */
    protected $rows;

    /**
     * Current Organization's id.
     *
     * @var
     */
    protected $organizationId;

    /**
     * Current User's id.
     *
     * @var
     */
    protected $userId;

    /**
     * Rows from the uploaded CSV file.
     *
     * @var array
     */
    protected array $csvRows = [];

    /**
     * Initialize an ActivityRow object.
     *
     * @param $row
     * @param $activityIdentifiers
     * @param $organizationReportingOrg
     * @param $locale
     *
     * @return ActivityRow
     */
    protected function initialize($row, $activityIdentifiers, $organizationReportingOrg, $locale): ActivityRow
    {
        return new ActivityRow($row, $this->organizationId, $this->userId, $activityIdentifiers, $organizationReportingOrg, $locale);
    }

    /**
     * Get the rows in the CSV.
     *
     * @return array
     */
    public function getRows(): array
    {
        return $this->rows;
    }
}
