<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

use App\IATI\Repositories\Activity\IndicatorRepository;
use App\IATI\Repositories\Activity\ResultRepository;
use App\IATI\Repositories\Download\XlsDownloadStatusRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DownloadXlsService.
 */
class DownloadXlsService
{
    /**
     * Result Repository to get results data for download.
     *
     * @var ResultRepository
     */
    protected ResultRepository $resultRepository;

    /**
     * Indicator Repository for indicator related data for download.
     *
     * @var IndicatorRepository
     */
    protected IndicatorRepository $indicatorRepository;

    /**
     * XlsDownloadStatusRepository for store, get, update, increment file count, reset download status.
     *
     * @var XlsDownloadStatusRepository
     */
    protected XlsDownloadStatusRepository $xlsDownloadStatusRepository;

    /**
     * Download Xls Service constructor.
     *
     * @param ResultRepository $resultRepository
     * @param IndicatorRepository $indicatorRepository
     * @param XlsDownloadStatusRepository $xlsDownloadStatusRepository
     */
    public function __construct(ResultRepository $resultRepository, IndicatorRepository $indicatorRepository, XlsDownloadStatusRepository $xlsDownloadStatusRepository)
    {
        $this->resultRepository = $resultRepository;
        $this->indicatorRepository = $indicatorRepository;
        $this->xlsDownloadStatusRepository = $xlsDownloadStatusRepository;
    }

    /**
     * Returns results having given ids for downloading.
     *
     * @param $resultIds
     *
     * @return mixed
     */
    public function getResultsWithIndicatorQueryToDownload($resultIds): mixed
    {
        return $this->resultRepository->getResultsWithIndicatorQueryToDownload($resultIds);
    }

    /**
     * Returns indicators having given ids for downloading.
     *
     * @param $indicatorIds
     *
     * @return mixed
     */
    public function getIndicatorWithPeriodsQueryToDownload($indicatorIds): mixed
    {
        return $this->indicatorRepository->getIndicatorWithPeriodsQueryToDownload($indicatorIds);
    }

    /**
     * Stores initial state of download status.
     *
     * @param $userId
     * @param $selected_activities
     *
     * @return Model|null
     */
    public function storeStatus($userId, $selected_activities): ?Model
    {
        return $this->xlsDownloadStatusRepository->storeStatus($userId, 'xls', $selected_activities);
    }

    /**
     * Increment file count by one.
     *
     * @param $userId
     *
     * @return false|int
     */
    public function incrementFileCount($userId)
    {
        return $this->xlsDownloadStatusRepository->incrementFileCount($userId, 'xls');
    }

    /**
     * Update download status of a suer.
     *
     * @param $userId
     * @param $data
     *
     * @return bool
     */
    public function updateDownloadStatus($userId, $data): bool
    {
        return $this->xlsDownloadStatusRepository->updateDownloadStatus($userId, $data);
    }

    /**
     * Deletes download process of a user.
     *
     * @param $userId
     *
     * @return bool
     */
    public function deleteDownloadStatus($userId): bool
    {
        return $this->xlsDownloadStatusRepository->deleteDownloadStatus($userId);
    }

    /**
     * Get download progress status.
     *
     * @return array
     */
    public function getDownloadStatus(): array
    {
        return $this->xlsDownloadStatusRepository->getDownloadStatus(auth()->user()->id, 'xls');
    }

    /**
     * get download status of a specific user.
     *
     * @param $userId
     *
     * @return \Illuminate\Database\Eloquent\Builder|Model|mixed|object|null
     */
    public function getDownloadStatusByUserId($userId)
    {
        return $this->xlsDownloadStatusRepository->getDownloadStatusObject($userId, 'xls');
    }

    /**
     * Resets download status back to starting point.
     *
     * @return array|null
     */
    public function resetDownloadStatus(): ?array
    {
        return $this->xlsDownloadStatusRepository->resetDownloadStatus(auth()->user()->id, 'xls');
    }
}
