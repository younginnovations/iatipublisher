<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation\Queue;

use App\Jobs\Job;
use App\XmlImporter\Foundation\XmlQueueProcessor;

class ImportXml extends Job
{
    /**
     * @var
     */
    protected $organizationId;
    /**
     * @var
     */
    protected $filename;
    /**
     * @var
     */
    protected $userId;
    /**
     * @var
     */
    protected $iatiIdentifiers;

    /**
     * ImportXml constructor.
     *
     * @param $organizationId
     * @param $userId
     * @param $filename
     * @param $iatiIdentifiers
     */
    public function __construct($organizationId, $userId, $filename, $iatiIdentifiers)
    {
        $this->organizationId = $organizationId;
        $this->filename = $filename;
        $this->userId = $userId;
        $this->iatiIdentifiers = $iatiIdentifiers;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            $xmlImportQueue = app()->make(XmlQueueProcessor::class);
            $xmlImportQueue->import($this->filename, $this->organizationId, $this->userId, $this->iatiIdentifiers);

            $this->delete();
        } catch (\Exception $e) {
            logger()->error($e);
            logger()->error($e->getMessage());
            awsUploadFile('error.log', $e);

            $this->delete();
        }
    }
}
