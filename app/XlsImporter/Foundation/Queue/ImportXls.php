<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Queue;

use App\IATI\Repositories\Import\ImportStatusRepository;
use App\Jobs\Job;
use App\XlsImporter\Foundation\XlsQueueProcessor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class ImportXls extends Job implements ShouldQueue
{
    /**
     * @var
     */
    protected $organizationId;
    /**
     * @var
     */
    protected $reportingOrg;
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
     * @var string
     */
    private string $xls_file_storage_path;

    /**
     * @var string
     */
    private string $xls_data_storage_path;

    /**
     * ImportXls constructor.
     *
     * @param $organizationId
     * @param $reportingOrg
     * @param $userId
     * @param $filename
     * @param $iatiIdentifiers
     * @param $xlsType
     */
    public function __construct($organizationId, $reportingOrg, $userId, $filename, $iatiIdentifiers, $xlsType)
    {
        $this->organizationId = $organizationId;
        $this->reportingOrg = $reportingOrg;
        $this->filename = $filename;
        $this->userId = $userId;
        $this->iatiIdentifiers = $iatiIdentifiers;
        $this->xlsType = $xlsType;
        $this->xls_file_storage_path = env('XLS_FILE_STORAGE_PATH ', 'XlsImporter/file');
        $this->xls_data_storage_path = env('XLS_DATA_STORAGE_PATH ', 'XlsImporter/tmp');
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            $xlsImportQueue = app()->make(XlsQueueProcessor::class);
            $xlsImportQueue->import($this->filename, $this->organizationId, $this->reportingOrg, $this->userId, $this->iatiIdentifiers, $this->xlsType);

            $this->delete();
        } catch (\Exception $e) {
            logger()->error($e);
            awsUploadFile('error.log', $e->getMessage());
            awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->organizationId, $this->userId, 'status.json'), json_encode(['success' => false, 'message' => 'Error has occurred while importing the file.'], JSON_THROW_ON_ERROR));
            $this->delete();
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        awsUploadFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->organizationId, $this->userId, 'status.json'), json_encode(['success' => false, 'message' => 'Failed to import xls file. Please check your file for correctness before importing again.'], JSON_THROW_ON_ERROR));

        // Send user notification of failure, etc...
    }

    /**
     * Delete the job from the queue.
     *
     * @return void
     */
    public function delete()
    {
        if ($this->job) {
            $completionStatus = json_decode(awsGetFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $this->organizationId, $this->userId, 'status.json')), true, 512, 0);
            $importStatus = app()->make(ImportStatusRepository::class);
            $status = $importStatus->getImportStatus($this->organizationId, $this->userId);

            if (!empty($status)) {
                $importStatus->update($status['id'], ['status' => $completionStatus['message'] === 'Complete' ? 'completed' : 'failed']);
            }

            return $this->job->delete();
        }
    }
}
