<?php

declare(strict_types=1);

namespace App\XlsImporter\Listeners;

use App\IATI\Services\ImportActivity\ImportXlsService;
use App\XlsImporter\Events\XlsWasUploaded;
use App\XlsImporter\Foundation\Queue\ImportXls;
use App\XlsImporter\Foundation\XlsQueueProcessor;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class XlsUpload.
 */
class XlsUpload
{
    use DispatchesJobs;

    /**
     * @var ImportXlsService
     */
    protected ImportXlsService $importXmlService;

    /**
     * @var XlsQueueProcessor
     */
    protected XlsQueueProcessor $xlsQueueProcessor;

    /**
     * XmlUpload constructor.
     * @param ImportXlsService  $importXmlService
     * @param XlsQueueProcessor $xlsQueueProcessor
     */
    public function __construct(ImportXlsService $importXmlService, XlsQueueProcessor $xlsQueueProcessor)
    {
        $this->importXmlService = $importXmlService;
        $this->xlsQueueProcessor = $xlsQueueProcessor;
    }

    /**
     * Handle the XlsWasUploadedEvent.
     *
     * @param XlsWasUploaded $event
     * @return bool
     */
    public function handle(XlsWasUploaded $event): bool
    {
        $this->dispatch(new ImportXls($event->organizationId, $event->reportingOrg, $event->userId, $event->filename, $event->iatiIdentifiers, $event->xlsType));

        return true;
    }
}
