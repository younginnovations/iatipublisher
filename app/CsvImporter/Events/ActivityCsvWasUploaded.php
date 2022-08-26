<?php

namespace App\CsvImporter\Events;

use Illuminate\Queue\SerializesModels;

/**
 * Class ActivityCsvWasUploaded.
 */
class ActivityCsvWasUploaded
{
    use SerializesModels;

    /**
     * @var
     */
    public $filename;

    /**
     * Create a new event instance.
     *
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
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
