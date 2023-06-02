<?php

declare(strict_types=1);

namespace App\Jobs;

use App\IATI\Models\User\User;
use App\IATI\Services\Download\DownloadXlsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class XlsExportMailJob.
 */
class XlsExportMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $username;

    /**
     * @var int
     */
    public int $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $username, $userId)
    {
        $this->email = $email;
        $this->username = $username;
        $this->userId = $userId;
    }

    /**
     * After zip file is uploaded in aws, a download link is sent to the user in mail.
     *
     * @return void
     */
    public function handle(): void
    {
        $awsCancelStatusFile = awsGetFile("Xls/$this->userId/cancelStatus.json");

        if (empty($awsCancelStatusFile)) {
            User::sendXlsDownloadLink($this->email, $this->username, $this->userId);
        }
    }

    public function failed(): void
    {
        $downloadXlsService = app()->make(DownloadXlsService::class);
        $downloadStatusData = [
            'status' => 'completed',
            'url' => route('admin.activities.download-xls'),
        ];
        $downloadXlsService->updateDownloadStatus($this->userId, $downloadStatusData);
    }
}
