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
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
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
        $awsCancelStatusFile = awsGetFile("Xls/$this->userId/cancelStatus.json");

        if (!empty($awsCancelStatusFile)) {
            $this->fail();
        }

        $zip_file = "storage/app/public/Xls/$this->userId/xlsFiles.zip";
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addFile(storage_path("app/public/Xls/$this->userId/activity.xlsx"), 'activity.xlsx');
        $zip->addFile(storage_path("app/public/Xls/$this->userId/result.xlsx"), 'result.xlsx');
        $zip->addFile(storage_path("app/public/Xls/$this->userId/indicator.xlsx"), 'indicator.xlsx');
        $zip->addFile(storage_path("app/public/Xls/$this->userId/period.xlsx"), 'period.xlsx');
        $zip->close();
        awsUploadFile("Xls/$this->userId/xlsFiles.zip", file_get_contents(storage_path("app/public/Xls/$this->userId/xlsFiles.zip")));
        Storage::disk('public')->deleteDirectory("Xls/$this->userId");
        awsUploadFile("Xls/$this->userId/status.json", json_encode(['success' => true, 'message' => 'Completed'], JSON_THROW_ON_ERROR));

        $downloadXlsService = app()->make(DownloadXlsService::class);
        $downloadStatusData = [
            'url' => route('admin.activities.download-xls'),
        ];
        $downloadXlsService->updateDownloadStatus($this->userId, $downloadStatusData);
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
        $downloadXlsService = app()->make(DownloadXlsService::class);
        $userId = $this->userId;
        $downloadStatusData = [
            'status' => 'failed',
        ];
        $downloadXlsService->updateDownloadStatus($userId, $downloadStatusData);
        awsDeleteFile("Xls/$userId/status.json");
        awsDeleteFile("Xls/$userId/cancelStatus.json");
    }
}
