<?php

declare(strict_types=1);

namespace App\XlsImporter\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

/**
 * Class XlsWasUploaded.
 */
class XlsWasUploaded extends Event
{
    //    use SerializesModels;

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
    public $orgRef;

    /**
     * @var
     */
    public $iatiIdentifiers;

    /**
     * XlsWasUploaded constructor.
     * @param $filename
     * @param $userId
     * @param $organizationId
     * @param $orgRef
     * @param $iatiIdentifiers
     */
    public function __construct($filename, $userId, $organizationId, $orgRef, $iatiIdentifiers)
    {
        $this->filename = $filename;
        $this->userId = $userId;
        $this->organizationId = $organizationId;
        $this->orgRef = $orgRef;
        $this->iatiIdentifiers = $iatiIdentifiers;
    }
}
