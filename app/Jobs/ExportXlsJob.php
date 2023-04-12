<?php

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
     * @var object
     */
    protected object $downloadXlsService;

    /**
     * @var array
     */
    public array $authUser;

    /**
     * @var array
     */
    public array $requestData;

    /**
     * @var array
     */
    protected array $resultIdentifiers;

    /**
     * @var array
     */
    protected array $indicatorIdentifier;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($requestData, $authUser)
    {
        $this->requestData = $requestData;
        $this->authUser = $authUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws BindingResolutionException
     * @throws \JsonException
     */
    public function handle(): void
    {
        $this->downloadXlsService = app()->make(DownloadXlsService::class);
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
        Excel::store($activityExportObject, "Xls/$userId/activity.xls", 'public');
        $this->incrementDownloadStatusFileCount();
    }

    /**
     * Stores results in an excel file.
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
        Excel::store($resultExportObject, "Xls/$userId/result.xls", 'public');
        $this->incrementDownloadStatusFileCount();
    }

    /**
     * Stores indicator in an excel file.
     *
     * @param $activities
     *
     * @return void
     */
    public function excelStoreIndicator($activities): void
    {
        $indicatorExportObject = new IndicatorExport($activities, $this->resultIdentifiers);
        $this->indicatorIdentifier = $indicatorExportObject->indicatorIdentifier;
        $userId = $this->authUser['id'];
        Excel::store($indicatorExportObject, "Xls/$userId/indicator.xls", 'public');
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
        Excel::store($periodExportObject, "Xls/$userId/period.xls", 'public');
        $this->incrementDownloadStatusFileCount();
    }

    /**
     * Triggers XlsDownloadStatusRepository incrementFileCount() method.
     *
     * @return void
     */
    public function incrementDownloadStatusFileCount(): void
    {
        $this->downloadXlsService->incrementFileCount($this->authUser['id']);
    }
}
