<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exports\ActivityExport;
use App\Exports\IndicatorExport;
use App\Exports\PeriodExport;
use App\Exports\ResultExport;
use App\IATI\Services\Download\DownloadActivityService;
use App\IATI\Services\Download\DownloadXlsService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JsonException;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class ExportXlsJob.
 */
class ExportXlsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /**
     * Activities in an array with its relation data.
     *
     * @var object
     */
    protected object $activities;

    /**
     * Download Xls Service instance to get required methods.
     *
     * @var object
     */
    protected object $downloadXlsService;

    /**
     * Stores auth user.
     *
     * @var array
     */
    public array $authUser;

    /**
     * Request data to get filtered activities.
     *
     * @var array
     */
    public array $requestData;

    /**
     * Status id of download.
     *
     * @var int
     */
    public int $statusId;

    /**
     * Stores result identifiers.
     *
     * @var array
     */
    protected array $resultIdentifiers;

    /**
     * stores indicator identifiers.
     *
     * @var array
     */
    protected array $indicatorIdentifier;

    /**
     * Create a new job instance.
     * $requestData to get filtered activities in a chunk
     * Had to query again in this job instead of directly passing it through constructor is because
     * it cannot serialize also cannot store the relationship value as well.
     *
     * @param $requestData
     * @param $authUser
     * @param $statusId
     *
     * @throws BindingResolutionException
     *
     * @return void
     */
    public function __construct($requestData, $authUser, $statusId)
    {
        $this->requestData = $requestData;
        $this->authUser = $authUser;
        $this->statusId = $statusId;
        $this->downloadXlsService = app()->make(DownloadXlsService::class);
    }

    /**
     * Execute the job.
     *
     * @throws BindingResolutionException
     * @throws JsonException
     *
     * @return void
     */
    public function handle(): void
    {
        $downloadActivityService = app()->make(DownloadActivityService::class);

        $activityIds = (isset($this->requestData['activities']) && $this->requestData['activities'] !== 'all') ?
            json_decode($this->requestData['activities'], true, 512, JSON_THROW_ON_ERROR) : [];

        if (isset($this->requestData['activities']) && $this->requestData['activities'] === 'all') {
            $activities = $downloadActivityService->getAllActivitiesQueryToDownload($this->sanitizeRequest($this->requestData), $this->authUser);
        } else {
            $activities = $downloadActivityService->getActivitiesQueryToDownload($activityIds, $this->authUser);
        }

        $this->excelStoreActivity($activities);
        $this->excelStoreResult($activities);
        $this->excelStoreIndicator($activities);
        $this->excelStorePeriod($activities);
    }

    /**
     * Sanitizes the request for removing code injections.
     *
     * @param $request
     *
     * @return array
     */
    public function sanitizeRequest($request): array
    {
        $tableConfig = getTableConfig('activity');
        $queryParams = [];

        if ((isset($request['q']) && !empty($request['q'])) || (isset($request['q']) && $request['q'] === '0')) {
            $queryParams['query'] = $request['q'];
        }

        if (in_array($request['orderBy'] ?? '', $tableConfig['orderBy'], true)) {
            $queryParams['orderBy'] = $request['orderBy'];

            if (in_array($request['direction'] ?? '', $tableConfig['direction'], true)) {
                $queryParams['direction'] = $request['direction'];
            }
        }

        return $queryParams;
    }

    /**
     * stores activities in an excel file.
     *
     * @param $activities
     *
     * @return void
     */
    public function excelStoreActivity($activities): void
    {
        $activityExportObject = new ActivityExport($activities);
        $userId = $this->authUser['id'];
        Excel::store($activityExportObject, "Xls/$userId/$this->statusId/activity.xlsx", 's3', \Maatwebsite\Excel\Excel::XLSX);
        $this->incrementDownloadStatusFileCount();
    }

    /**
     * Stores results in an Excel file.
     *
     * @param $activities
     *
     * @return void
     */
    public function excelStoreResult($activities): void
    {
        $resultExportObject = new ResultExport($activities);
        $this->resultIdentifiers = $resultExportObject->resultIdentifiers;
        $userId = $this->authUser['id'];
        Excel::store($resultExportObject, "Xls/$userId/$this->statusId/result.xlsx", 's3', \Maatwebsite\Excel\Excel::XLSX);
        $this->incrementDownloadStatusFileCount();
    }

    /**
     * Stores indicator in an excel file.
     *
     * @param $activities
     *
     * @throws BindingResolutionException
     *
     * @return void
     */
    public function excelStoreIndicator($activities): void
    {
        $indicatorExportObject = new IndicatorExport($activities, $this->resultIdentifiers);
        $this->indicatorIdentifier = $indicatorExportObject->indicatorIdentifier;
        $userId = $this->authUser['id'];
        Excel::store($indicatorExportObject, "Xls/$userId/$this->statusId/indicator.xlsx", 's3', \Maatwebsite\Excel\Excel::XLSX);
        $this->incrementDownloadStatusFileCount();
    }

    /**
     * Stores period in an Excel file.
     *
     * @param $activities
     *
     * @return void
     */
    public function excelStorePeriod($activities): void
    {
        $indicatorIdentifier = $this->indicatorIdentifier;
        $periodExportObject = new PeriodExport($activities, $indicatorIdentifier);
        $userId = $this->authUser['id'];
        Excel::store($periodExportObject, "Xls/$userId/$this->statusId/period.xlsx", 's3', \Maatwebsite\Excel\Excel::XLSX);
        $this->incrementDownloadStatusFileCount();
    }

    /**
     * Triggers XlsDownloadStatusRepository incrementFileCount() method.
     *
     * @return void
     */
    public function incrementDownloadStatusFileCount(): void
    {
        $this->downloadXlsService->incrementFileCount($this->authUser['id'], $this->statusId);
    }

    /**
     * Handle a job failure.
     * if it fails then it uploads the download status table with failed status
     * also deletes status.json and cancelStatus.json from s3 so that it won't affect for future download.
     *
     * @return void
     */
    public function failed(): void
    {
        $userId = $this->authUser['id'];
        $downloadStatusData = [
            'status' => 'failed',
        ];
        $this->downloadXlsService->updateDownloadStatus($this->statusId, $downloadStatusData);
        awsDeleteFile("Xls/$userId/$this->statusId/status.json");
        awsDeleteFile("Xls/$userId/$this->statusId/cancelStatus.json");
    }
}
