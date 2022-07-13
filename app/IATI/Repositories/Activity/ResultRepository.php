<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Result;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ResultRepository.
 */
class ResultRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * @var Result
     */
    protected Result $activityResult;

    /**
     * ResultRepository Constructor.
     * @param Activity $activity
     * @param Result $activityResult
     */
    public function __construct(Activity $activity, Result $activityResult)
    {
        $this->activity = $activity;
        $this->activityResult = $activityResult;
    }

    /**
     * Create a new ActivityResult.
     *
     * @param array $resultData
     * @return Model
     */
    public function create(array $resultData): Model
    {
        $resultData = $this->sanitizeResultData($resultData);

        return $this->activityResult->create($resultData);
    }

    /**
     * Update Activity Result.
     * @param array          $resultData
     * @param Result $activityResult
     * @return bool
     */
    public function update(array $resultData, Result $activityResult): bool
    {
        $resultData = $this->sanitizeResultData($resultData);
        $activityResult->result = $resultData['result'];

        return $activityResult->save();
    }

    /**
     * Return specific result.
     * @param $id
     * @param $activityId
     * @return Model
     */
    public function getResult($id, $activityId): Model
    {
        return $this->activityResult->where('id', $id)->where('activity_id', $activityId)->first();
    }

    /**
     * Return specific result.
     * @param $id
     * @param $activityId
     * @return array
     */
    public function getActivityResult($activityId): array
    {
        return $this->activityResult->where('activity_id', $activityId)->get()->toArray();
    }

    /**
     * Function to sanitize result data.
     * @param array $resultData
     * @return array
     */
    public function sanitizeResultData(array $resultData): array
    {
        foreach ($resultData['result'] as $result_key => $result) {
            if (is_array($result)) {
                $resultData['result'][$result_key] = array_values($result);

                foreach ($result as $sub_key => $sub_element) {
                    if (is_array($sub_element)) {
                        foreach ($sub_element as $inner_key => $inner_element) {
                            if (is_array($inner_element)) {
                                $resultData['result'][$result_key][$sub_key][$inner_key] = array_values($inner_element);
                            }
                        }
                    }
                }
            }
        }

        return $resultData;
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
        return $this->activityResult->where('activity_id', $activityId)->with('indicators', 'indicators.periods')->get();
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
        return $this->activityResult->where('id', $resultId)->where('activity_id', $activityId)->with(['indicators', 'indicators.periods'])->first();
    }
}
