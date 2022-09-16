<?php

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
    protected $csvRows = [];

    /**
     * Initialize an ActivityRow object.
     *
     * @param $row
     * @param $activityIdentifiers
     * @return ActivityRow
     */
    protected function initialize($row, $activityIdentifiers, $version)
    {
        return  new ActivityRow($row, $this->organizationId, $this->userId, $activityIdentifiers, $version);
    }

    /**
     * Get the rows in the CSV.
     *
     * @return mixed
     */
    public function rows()
    {
        return $this->rows;
    }
}
