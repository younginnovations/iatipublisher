<?php

declare(strict_types=1);

namespace App\XlsImporter\Events;

use App\Events\Event;

/**
 * Class XlsWasUploaded.
 */
class XlsWasUploaded extends Event
{
    /**
     * @var
     */
    public $filename;

    /**
     * @var
     */
    public $userId;

    /**
     * @var
     */
    public $organizationId;

    /**
     * @var
     */
    public $reportingOrg;

    /**
     * @var array
     */
    public array $iatiIdentifiers;

    /**
     * @var string
     */
    public string $xlsType;

    /**
     * XlsWasUploaded constructor.
     *
     * @param $filename
     * @param $userId
     * @param $organizationId
     * @param $reportingOrg
     * @param $iatiIdentifiers
     * @param $xlsType
     */
    public function __construct($filename, $userId, $organizationId, $reportingOrg, $iatiIdentifiers, $xlsType)
    {
        $this->filename = $filename;
        $this->userId = $userId;
        $this->organizationId = $organizationId;
        $this->reportingOrg = $reportingOrg;
        $this->iatiIdentifiers = $iatiIdentifiers;
        $this->xlsType = $xlsType;
    }
}
