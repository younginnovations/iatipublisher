<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\ResultRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ResultService.
 */
class ResultService
{
    /**
     * @var ResultRepository
     */
    protected ResultRepository $resultRepository;

    /**
     * ResultService constructor.
     *
     * @param ResultRepository $resultRepository
     */
    public function __construct(ResultRepository $resultRepository)
    {
        $this->resultRepository = $resultRepository;
    }

    /**
     * Create a new ActivityResult.
     *
     * @param array $resultData
     * @return Model
     */
    public function create(array $resultData): Model
    {
        return $this->resultRepository->create($resultData);
    }

    /**
     * Update Activity Result.
     * @param array          $resultData
     * @param $activityResult
     * @return bool
     */
    public function update(array $resultData, $activityResult): bool
    {
        return $this->resultRepository->update($resultData, $activityResult);
    }

    /**
     * Return specific result.
     * @param $id
     * @param $activityId
     * @return Model
     */
    public function getResult($id, $activityId): Model
    {
        return $this->resultRepository->getResult($id, $activityId);
    }

    /**
     * Returns all results with its indicators and their periods for a particular activity.
     *
     * @param $activityId
     *
     * @return Collection
     */
    public function getActivityResultsWithIndicatorsAndPeriods($activityId): Collection
    {
        return $this->resultRepository->getActivityResultsWithIndicatorsAndPeriods($activityId);
    }

    /**
     * Returns result with its indicators and their periods.
     *
     * @param $resultId
     * @param $activityId
     *
     * @return Model
     */
    public function getResultWithIndicatorAndPeriod($resultId, $activityId): Model
    {
        return $this->resultRepository->getResultWithIndicatorAndPeriod($resultId, $activityId);
    }

    /**
     * Return specific result.
     *
     * @param $activityId
     * @return array
     */
    public function getActivityResult($activityId): array
    {
        return $this->resultRepository->getActivityResult($activityId);
    }

    /**
     * Returns array of paginated results belonging to an activity.
     *
     * @param $activityId
     * @param $page
     *
     * return LengthAwarePaginator|Collection
     */
    public function getPaginatedResult($activityId, $page): LengthAwarePaginator|Collection
    {
        return $this->resultRepository->getPaginatedResult($activityId, $page);
    }
}
