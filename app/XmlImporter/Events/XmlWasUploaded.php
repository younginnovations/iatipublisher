<?php

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
     * @var int
     */
    public $consortium_id;

    /**
     * XmlWasUploaded constructor.
     * @param $filename
     * @param $userId
     * @param $organizationId
     * @param $consortium_id
     */
    public function __construct($filename, $userId, $organizationId, $consortium_id = null)
    {
        $this->filename = $filename;
        $this->userId = $userId;
        $this->organizationId = $organizationId;
        $this->consortium_id = $consortium_id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
