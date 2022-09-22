<?php

declare(strict_types=1);

namespace App\Entities;

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
     *
     * @return ActivityRow
     */
    protected function initialize($row, $activityIdentifiers): ActivityRow
    {
        // return app()->make(ActivityRow::class, [$row, $this->organizationId, $this->userId, $activityIdentifiers, $version]);
        return  new ActivityRow($row, $this->organizationId, $this->userId, $activityIdentifiers);
    }

    /**
     * Get the rows in the CSV.
     *
     * @return mixed
     */
    public function rows(): mixed
    {
        return $this->rows;
    }
}
