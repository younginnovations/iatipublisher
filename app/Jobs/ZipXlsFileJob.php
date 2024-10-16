<?php

declare(strict_types=1);

namespace App\Jobs;

use App\IATI\Models\User\User;
use App\IATI\Services\Download\DownloadXlsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

/**
 * Class ZipXlsFileJob.
 */
class ZipXlsFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Stores user id.
     *
     * @var int
     */
    protected int $userId;

    /**
     * Status id of download.
     *
     * @var int
     */
    protected int $statusId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId, $statusId)
    {
        $this->userId = $userId;
        $this->statusId = $statusId;
    }

    /**
     * get all the generated xls file from local disk and zips it
     * uploads it in aws and deletes all the generated xls file from local disk.
     *
     * @throws \JsonException
     * @throws BindingResolutionException
     *
     * @return void
     */
    public function handle(): void
    {
        $awsCancelStatusFile = awsGetFile("Xls/$this->userId/$this->statusId/cancelStatus.json");

        if (!empty($awsCancelStatusFile)) {
            $this->deleteJob();
        }

        $zip_file = "storage/app/public/Xls/$this->userId/xlsFiles.zip";
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $activityFile = awsGetFile("Xls/$this->userId/$this->statusId/activity.xlsx");
        localUploadFile("public/Xls/$this->userId/$this->statusId/activity.xlsx", $activityFile);
        $resultFile = awsGetFile("Xls/$this->userId/$this->statusId/result.xlsx");
        localUploadFile("public/Xls/$this->userId/$this->statusId/result.xlsx", $resultFile);
        $indicatorFile = awsGetFile("Xls/$this->userId/$this->statusId/indicator.xlsx");
        localUploadFile("public/Xls/$this->userId/$this->statusId/indicator.xlsx", $indicatorFile);
        $periodFile = awsGetFile("Xls/$this->userId/$this->statusId/period.xlsx");
        localUploadFile("public/Xls/$this->userId/$this->statusId/period.xlsx", $periodFile);

        $zip->addFile(storage_path("app/public/Xls/$this->userId/$this->statusId/activity.xlsx"), 'activity.xlsx');
        $zip->addFile(storage_path("app/public/Xls/$this->userId/$this->statusId/result.xlsx"), 'result.xlsx');
        $zip->addFile(storage_path("app/public/Xls/$this->userId/$this->statusId/indicator.xlsx"), 'indicator.xlsx');
        $zip->addFile(storage_path("app/public/Xls/$this->userId/$this->statusId/period.xlsx"), 'period.xlsx');

        $zip->close();

        awsUploadFile("Xls/$this->userId/$this->statusId/xlsFiles.zip", file_get_contents(storage_path("app/public/Xls/$this->userId/xlsFiles.zip")));
        Storage::disk('public')->deleteDirectory("Xls/$this->userId");
        awsUploadFile("Xls/$this->userId/$this->statusId/status.json", json_encode(['success' => true, 'message' => 'Completed'], JSON_THROW_ON_ERROR));

        $downloadXlsService = app()->make(DownloadXlsService::class);
        $downloadStatusData = [
            'url' => route('admin.activities.download-xls'),
        ];
        $downloadXlsService->updateDownloadStatus($this->statusId, $downloadStatusData);
    }

    /**
     * if class fails to zip a xls files then update as failed download status
     * also delete status and cancel status json if exists.
     *
     * @throws BindingResolutionException
     *
     * @return void
     */
    public function failed(): void
    {
        $downloadStatusData = [
            'status' => 'failed',
        ];
        $this->updateDownloadStatus($downloadStatusData);
        $this->updateDownloadProcessJob();
    }

    /**
     * Deletes job if cancel status.
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function deleteJob(): void
    {
        $downloadXlsService = app()->make(DownloadXlsService::class);
        $downloadXlsService->deleteDownloadStatus($this->userId, $this->statusId);
        $this->updateDownloadProcessJob();
        $this->delete();
    }

    /**
     * Updates download process like status, delete files from aws.
     *
     * @return void
     */
    public function updateDownloadProcessJob(): void
    {
        $userId = $this->userId;
        awsDeleteFile("Xls/$userId/$this->statusId/status.json");
        awsDeleteFile("Xls/$userId/$this->statusId/cancelStatus.json");
    }

    /**
     * Updates on going download status.
     *
     * @param $downloadStatusData
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function updateDownloadStatus($downloadStatusData): void
    {
        $downloadXlsService = app()->make(DownloadXlsService::class);
        $downloadXlsService->updateDownloadStatus($this->statusId, $downloadStatusData);
    }
}
