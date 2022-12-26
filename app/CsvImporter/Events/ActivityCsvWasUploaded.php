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
     * @var string
     */
    public string $locale;

    /**
     * Create a new event instance.
     *
     * @param $filename
     * @param $locale
     */
    public function __construct($filename, $locale)
    {
        $this->filename = $filename;
        $this->locale = $locale;
    }
}
