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
     * @var ResultRepository
     */
    protected ResultRepository $resultRepository;

    /**
     * @var IndicatorRepository
     */
    protected IndicatorRepository $indicatorRepository;

    /**
     * @var XlsDownloadStatusRepository
     */
    protected XlsDownloadStatusRepository $xlsDownloadStatusRepository;

    /**
     * Download Xls Service constructor.
     *
     * @param ResultRepository $resultRepository
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
     * @param $userId
     *
     * @return false|int
     */
    public function incrementFileCount($userId)
    {
        return $this->xlsDownloadStatusRepository->incrementFileCount($userId, 'xls');
    }

    /**
     * @param $userId
     *
     * @return bool
     */
    public function updateDownloadStatus($userId, $data): bool
    {
        return $this->xlsDownloadStatusRepository->updateDownloadStatus($userId, $data);
    }

    /**
     * @param $userId
     *
     * @return bool
     */
    public function deleteDownloadStatus($userId): bool
    {
        return $this->xlsDownloadStatusRepository->deleteDownloadStatus($userId);
    }

    /**
     * @return array
     */
    public function getDownloadStatus(): array
    {
        return $this->xlsDownloadStatusRepository->getDownloadStatus(auth()->user()->id, 'xls');
    }

    public function getDownloadStatusByUserId($userId)
    {
        return $this->xlsDownloadStatusRepository->getDownloadStatusObject($userId, 'xls');
    }

    public function resetDownloadStatus()
    {
        return $this->xlsDownloadStatusRepository->resetDownloadStatus(auth()->user()->id, 'xls');
    }
}
