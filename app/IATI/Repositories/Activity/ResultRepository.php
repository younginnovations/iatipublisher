<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Result;
use App\IATI\Repositories\Repository;
use App\IATI\Traits\FillDefaultValuesTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ResultRepository.
 */
class ResultRepository extends Repository
{
    use FillDefaultValuesTrait;

    /**
     * @return string
     */
    public function getModel(): string
    {
        return Result::class;
    }

    /**
     * Returns results of specific activity.
     *
     * @param $activityId
     *
     * @return array
     */
    public function getActivityResults($activityId): array
    {
        return $this->model->where('activity_id', $activityId)->get()->toArray();
    }

    /**
     * Returns paginated results.
     *
     * @param int $activityId
     * @param int $page
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getPaginatedResult(int $activityId, int $page = 1): Collection|LengthAwarePaginator
    {
        return $this->model->where('activity_id', $activityId)->orderBy('created_at', 'DESC')->paginate(10, ['*'], 'result', $page);
    }

    /**
     * Returns specific result of specific activity.
     *
     * @param int $activityId
     * @param int $id
     *
     * @return mixed
     */
    public function getActivityResult(int $activityId, int $id): mixed
    {
        return $this->model->where(['activity_id'=>$activityId, 'id'=>$id])->first();
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getResult(int $id): array
    {
        return $this->model->where(['id'=>$id])->first()->toArray();
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
        return $this->model->where('activity_id', $activityId)->orderBy('created_at', 'DESC')->with('indicators', 'indicators.periods')->limit(4)->get();
    }

    /**
     * Returns result with its indicators and their periods.
     *
     * @param $resultId
     * @param $activityId
     *
     * @return Model|null
     */
    public function getResultWithIndicatorAndPeriod($resultId, $activityId): ?Model
    {
        return $this->model->where('id', $resultId)->where('activity_id', $activityId)->with(['indicators', 'indicators.periods'])->first();
    }

    /**
     * Returns result with its indicators.
     *
     * @param $resultId
     *
     * @return array
     */
    public function getResultWithIndicator($resultId): array
    {
        return $this->model->where('id', $resultId)->with(['indicators'])->first()->toArray();
    }

    /**
     * Deletes result with activity id.
     *
     * @param $activity_id
     *
     * @return mixed
     */
    public function deleteResult($activity_id): mixed
    {
        $results = $this->model->where('activity_id', $activity_id)->get();

        if (!empty($results)) {
            return $results->each->delete();
        }

        return false;
    }

    /**
     * Inserts multiple results.
     *
     * @param $results
     *
     * @return bool
     */
    public function insert($results): bool
    {
        return $this->model->insert($results);
    }

    /**
     * get result with indicator from an array of result ids.
     *
     * @param array $resultIds
     *
     * @return Builder
     */
    public function getResultsWithIndicatorQueryToDownload(array $resultIds): Builder
    {
        return $this->model->has('indicators')->with('indicators')->whereIn('id', $resultIds);
    }

    public function getActivityByResultId($resultId)
    {
        $result = $this->model->where('id', $resultId)->first();

        return $result->activity;
    }
}
