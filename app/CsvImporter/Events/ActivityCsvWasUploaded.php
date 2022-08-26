<?php

declare(strict_types=1);

namespace App\CsvImporter\Events;

use Illuminate\Queue\SerializesModels;

/**
 * Class ActivityCsvWasUploaded.
 */
class ActivityCsvWasUploaded
{
    use SerializesModels;

    /**
     * @var string
     */
    public string $filename;

    /**
     * Create a new event instance.
     *
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
}
