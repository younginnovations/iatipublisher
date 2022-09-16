<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity;

use App\CsvImporter\Entities\Csv;

/**
 * Class Activity.
 */
class Activity extends Csv
{
    /**
     * @var
     */
    protected $activityIdentifiers;

    private $version;

    /**
     * Activity constructor.
     *
     * @param $rows
     * @param $organizationId
     * @param $userId
     * @param $activityIdentifiers
     * @param $version
     */
    public function __construct($rows, $organizationId, $userId, $activityIdentifiers, $version)
    {
        $this->csvRows = $rows;
        $this->organizationId = $organizationId;
        $this->userId = $userId;
        $this->rows = $rows;
        $this->activityIdentifiers = $activityIdentifiers;
        $this->version = $version;
    }

    /**
     * Process the Activity Csv.
     *
     * @return $this
     */
    public function process(): static
    {
        foreach ($this->rows() as $row) {
            $this->initialize($row, $this->activityIdentifiers, $this->version)
                 ->process()
                 ->validate()
                 ->validateUnique($this->csvRows)
                 ->checkExistence($row)
                 ->keep();
        }

        return $this;
    }
}
