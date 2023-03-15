<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Queue;

use App\Jobs\Job;
use App\XlsImporter\Foundation\XlsQueueProcessor;

class ImportXls extends Job
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
     * ImportXls constructor.
     *
     * @param $organizationId
     * @param $orgRef
     * @param $userId
     * @param $filename
     * @param $iatiIdentifiers
     */
    public function __construct($organizationId, $orgRef, $userId, $filename, $iatiIdentifiers)
    {
        $this->organizationId = $organizationId;
        $this->orgRef = $orgRef;
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
            $xlsImportQueue = app()->make(XlsQueueProcessor::class);
            $xlsImportQueue->import($this->filename, $this->organizationId, $this->orgRef, $this->userId, $this->iatiIdentifiers);

            $this->delete();
        } catch (\Exception $e) {
            logger()->error($e);
            awsUploadFile('error.log', $e->getMessage());
            $this->delete();
        }
    }
}
