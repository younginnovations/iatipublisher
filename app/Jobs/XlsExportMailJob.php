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

/**
 * Class XlsExportMailJob.
 */
class XlsExportMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Stores Email.
     *
     * @var string
     */
    public string $email;

    /**
     * Stores username.
     *
     * @var string
     */
    public string $username;

    /**
     * Stores user id.
     *
     * @var int
     */
    public int $userId;

    /**
     * Stores statusID of download.
     *
     * @var int
     */
    public int $statusId;

    /**
     * Create a new job instance.
     *
     * @param $email
     * @param $userId
     * @param $username
     * @param $statusId
     *
     * @return void
     */
    public function __construct($email, $username, $userId, $statusId)
    {
        $this->email = $email;
        $this->username = $username;
        $this->userId = $userId;
        $this->statusId = $statusId;
    }

    /**
     * After zip file is uploaded in aws, a download link is sent to the user in mail.
     *
     * @throws BindingResolutionException
     *
     * @return void
     */
    public function handle(): void
    {
        if (empty(awsGetFile("Xls/$this->userId/$this->statusId/cancelStatus.json"))) {
            User::sendXlsDownloadLink($this->email, $this->username, $this->statusId);
        }
    }

    /**
     * If Export mail jobs fails to send a mail to user then update download progress as completed.
     *
     * @throws BindingResolutionException
     *
     * @return void
     */
    public function failed(): void
    {
        $downloadXlsService = app()->make(DownloadXlsService::class);
        $downloadStatusData = [
            'status' => 'completed',
            'url' => route('admin.activities.download-xls'),
        ];
        $downloadXlsService->updateDownloadStatus($this->statusId, $downloadStatusData);
    }
}
