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
    protected $orgRef;
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
     * @var
     */
    private $organizationReportingOrg;

    /**
     * @var
     */
    public $locale;

    /**
     * ImportXml constructor.
     *
     * @param $organizationId
     * @param $orgRef
     * @param $userId
     * @param $filename
     * @param $iatiIdentifiers
     * @param $organizationReportingOrg
     * @param $locale
     */
    public function __construct($organizationId, $orgRef, $userId, $filename, $iatiIdentifiers, $organizationReportingOrg, $locale)
    {
        $this->organizationId = $organizationId;
        $this->orgRef = $orgRef;
        $this->filename = $filename;
        $this->userId = $userId;
        $this->iatiIdentifiers = $iatiIdentifiers;
        $this->organizationReportingOrg = $organizationReportingOrg;
        $this->locale = $locale;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            $xmlImportQueue = app()->make(XmlQueueProcessor::class);
            $xmlImportQueue->locale = $this->locale;
            $xmlImportQueue->import($this->filename, $this->organizationId, $this->orgRef, $this->userId, $this->iatiIdentifiers, $this->organizationReportingOrg);

            $this->delete();
        } catch (\Exception $e) {
            awsUploadFile('error.log', $e->getMessage());
            $this->delete();
        }
    }
}
