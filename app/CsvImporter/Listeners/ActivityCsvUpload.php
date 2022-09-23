<?php

declare(strict_types=1);

namespace App\CsvImporter\Listeners;

use App\CsvImporter\Events\ActivityCsvWasUploaded;
use App\IATI\Services\ImportActivity\ImportCsvService;

/**
 * Class ActivityCsvUpload.
 */
class ActivityCsvUpload
{
    /**
     * @var ImportCsvService
     */
    protected ImportCsvService $importCsvService;

    /**
     * Create the event listener.
     *
     * @param ImportCsvService $importCsvService
     */
    public function __construct(ImportCsvService $importCsvService)
    {
        $this->importCsvService = $importCsvService;
    }

    /**
     * Handle the event.
     *
     * @param  ActivityCsvWasUploaded $event
     * @return bool
     */
    public function handle(ActivityCsvWasUploaded $event): bool
    {
        $this->importCsvService->process($event->filename);

        return true;
    }
}
