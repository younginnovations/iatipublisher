<?php

declare(strict_types=1);

namespace App\XmlImporter\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

/**
 * Class XmlWasUploaded.
 */
class XmlWasUploaded extends Event
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
    public $iatiIdentifiers;

    /**
     * XmlWasUploaded constructor.
     * @param $filename
     * @param $userId
     * @param $organizationId
     * @param $iatiIdentifiers
     */
    public function __construct($filename, $userId, $organizationId, $iatiIdentifiers)
    {
        $this->filename = $filename;
        $this->userId = $userId;
        $this->organizationId = $organizationId;
        $this->iatiIdentifiers = $iatiIdentifiers;
    }
}
