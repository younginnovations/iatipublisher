<?php

declare(strict_types=1);

namespace App\Jobs;

use App\IATI\Services\Download\DownloadXlsService;
use Illuminate\Bus\Queueable;
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
     * @return void
     */
    public function handle(): void
    {
        $downloadXlsService = app()->make(DownloadXlsService::class);
        $zip_file = "storage/app/public/Xls/$this->userId/xlsFiles.zip";
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addFile(storage_path("app/public/Xls/$this->userId/activity.xls"), 'activity.xls');
        $zip->addFile(storage_path("app/public/Xls/$this->userId/result.xls"), 'result.xls');
        $zip->addFile(storage_path("app/public/Xls/$this->userId/indicator.xls"), 'indicator.xls');
        $zip->addFile(storage_path("app/public/Xls/$this->userId/period.xls"), 'period.xls');
        $zip->close();
        awsUploadFile("Xls/$this->userId/xlsFiles.zip", file_get_contents(storage_path("app/public/Xls/$this->userId/xlsFiles.zip")));
        Storage::disk('public')->deleteDirectory("Xls/$this->userId");
        $downloadXlsService->updateDownloadStatus($this->userId);
    }
}
