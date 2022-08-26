<?php

namespace App\CsvImporter\Entities\Activity\Result;

use App\CsvImporter\Entities\ResultCsv;

/**
 * Class Result.
 */
class Result extends ResultCsv
{
    /**
     * Result constructor.
     * @param $rows
     * @param $organizationId
     * @param $userId
     */
    public function __construct($rows, $organizationId, $userId)
    {
        $this->csvRows = $rows;
        $this->organizationId = $organizationId;
        $this->userId = $userId;
        $this->rows = $rows;
    }

    /**
     * Process the Result Csv.
     *
     * @return $this
     */
    public function process($version)
    {
        foreach ($this->rows() as $row) {
            $this->initialize($row, $version)
                 ->mapResultRow()
                 ->validate()
                 ->keep();
        }

        return $this;
    }
}
