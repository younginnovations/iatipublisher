<?php

namespace App\XmlImporter\Listeners;

use App\IATI\Services\ImportActivity\ImportXmlService;
use App\XmlImporter\Events\XmlWasUploaded;
use App\XmlImporter\Foundation\Queue\ImportXml;
use App\XmlImporter\Foundation\XmlQueueProcessor;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class XmlUpload.
 */
class XmlUpload
{
    use DispatchesJobs;

    /**
     * @var ImportXmlService
     */
    protected $importXmlService;

    /**
     * @var XmlQueueProcessor
     */
    protected $xmlQueueProcessor;

    /**
     * XmlUpload constructor.
     * @param ImportXmlService  $importXmlService
     * @param XmlQueueProcessor $xmlQueueProcessor
     */
    public function __construct(ImportXmlService $importXmlService, XmlQueueProcessor $xmlQueueProcessor)
    {
        $this->importXmlService = $importXmlService;
        $this->xmlQueueProcessor = $xmlQueueProcessor;
    }

    /**
     * Handle the XmlWasUploadedEvent.
     *
     * @param XmlWasUploaded $event
     * @return bool
     */
    public function handle(XmlWasUploaded $event)
    {
        $this->dispatch(new ImportXml($event->organizationId, $event->userId, $event->filename, $event->consortium_id));

        return true;
    }
}
