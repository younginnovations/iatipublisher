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
     * @var
     */
    protected $xlsType;

    /**
     * ImportXls constructor.
     *
     * @param $organizationId
     * @param $orgRef
     * @param $userId
     * @param $filename
     * @param $iatiIdentifiers
     * @param $xlsType
     */
    public function __construct($organizationId, $orgRef, $userId, $filename, $iatiIdentifiers, $xlsType)
    {
        $this->organizationId = $organizationId;
        $this->orgRef = $orgRef;
        $this->filename = $filename;
        $this->userId = $userId;
        $this->iatiIdentifiers = $iatiIdentifiers;
        $this->xlsType = $xlsType;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            $xlsImportQueue = app()->make(XlsQueueProcessor::class);
            $xlsImportQueue->import($this->filename, $this->organizationId, $this->orgRef, $this->userId, $this->iatiIdentifiers, $this->xlsType);

            $this->delete();
        } catch (\Exception $e) {
            logger()->error($e);
            awsUploadFile('error.log', $e->getMessage());
            awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $orgId, $userId, 'status.json'), json_encode(['success' => false, 'message' => 'Error has occurred while importing the file.'], JSON_THROW_ON_ERROR));
            $this->delete();
        }
    }
}
