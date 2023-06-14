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
     * @var array
     */
    protected array $activityIdentifiers;

    /**
     * @var array
     */
    protected array $organizationReportingOrg;

    /**
     * @var string
     */
    public string $locale;

    /**
     * Activity constructor.
     *
     * @param $rows
     * @param $organizationId
     * @param $userId
     * @param $activityIdentifiers
     * @param $organizationReportingOrg
     */
    public function __construct($rows, $organizationId, $userId, $activityIdentifiers, $organizationReportingOrg)
    {
        $this->csvRows = $rows;
        $this->organizationId = $organizationId;
        $this->userId = $userId;
        $this->rows = $rows;
        $this->activityIdentifiers = $activityIdentifiers;
        $this->organizationReportingOrg = $organizationReportingOrg;
    }

    /**
     * Process the Activity Csv.
     *
     * @return $this
     * @throws \JsonException
     */
    public function process(): static
    {
        foreach ($this->getRows() as $row) {
            $this->initialize($row, $this->activityIdentifiers, $this->organizationReportingOrg, $this->locale)
                 ->process()
                 ->validate()
                 ->validateUnique($this->csvRows)
                 ->checkExistence($row)
                 ->keep();
        }

        return $this;
    }
}
