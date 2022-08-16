<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Models\Activity\Result;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IndicatorRepository.
 */
class IndicatorRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * @var Indicator
     */
    protected Indicator $resultIndicator;

    /**
     * IndicatorRepository Constructor.
     *
     * @param Activity $activity
     * @param Indicator $resultIndicator
     */
    public function __construct(Activity $activity, Indicator $resultIndicator)
    {
        $this->activity = $activity;
        $this->resultIndicator = $resultIndicator;
    }

    /**
     * Create a new ResultIndicator.
     *
     * @param array $indicatorData
     *
     * @return Model
     */
    public function create(array $indicatorData): Model
    {
        $indicatorData = $this->sanitizeIndicatorData($indicatorData);

        return $this->resultIndicator->create($indicatorData);
    }

    /**
     * Update Activity Result Indicator.
     *
     * @param array $indicatorData
     * @param Indicator $activityResultIndicator
     *
     * @return bool
     */
    public function update(array $indicatorData, Indicator $activityResultIndicator): bool
    {
        $indicatorData = $this->sanitizeIndicatorData($indicatorData);
        $activityResultIndicator->indicator = $indicatorData['indicator'];

        return $activityResultIndicator->save();
    }

    /**
     * Return Activity Result Indicators.
     *
     * @param $resultId
     * @return Collection
     */
    public function getResultIndicators($resultId): Collection
    {
        return $this->resultIndicator->where('result_id', $resultId)->get()->sortByDesc('updated_at');
    }

    /**
     * Function to sanitize indicator data.
     *
     * @param array $indicatorData
     *
     * @return array
     */
    public function sanitizeIndicatorData(array $indicatorData): array
    {
        foreach ($indicatorData['indicator'] as $indicator_key => $indicator) {
            if (is_array($indicator)) {
                $indicatorData['indicator'][$indicator_key] = array_values($indicator);

                foreach ($indicatorData['indicator'][$indicator_key] as $sub_key => $sub_element) {
                    if (is_array($sub_element)) {
                        foreach ($indicatorData['indicator'][$indicator_key][$sub_key] as $inner_key => $inner_element) {
                            if (is_array($inner_element)) {
                                $indicatorData['indicator'][$indicator_key][$sub_key][$inner_key] = array_values($inner_element);

                                foreach ($indicatorData['indicator'][$indicator_key][$sub_key][$inner_key] as $deep_key => $deep_element) {
                                    if (is_array($deep_element)) {
                                        foreach ($indicatorData['indicator'][$indicator_key][$sub_key][$inner_key][$deep_key] as $inner_deep_key => $inner_deep_element) {
                                            if (is_array($inner_deep_element)) {
                                                $indicatorData['indicator'][$indicator_key][$sub_key][$inner_key][$deep_key][$inner_deep_key] = array_values($inner_deep_element);

                                                foreach ($indicatorData['indicator'][$indicator_key][$sub_key][$inner_key][$deep_key][$inner_deep_key] as $deeperKey => $deeperValue) {
                                                    if (is_array($deeperValue)) {
                                                        foreach ($indicatorData['indicator'][$indicator_key][$sub_key][$inner_key][$deep_key][$inner_deep_key][$deeperKey] as $innerDeeperKey => $innerDeeperValue) {
                                                            if (is_array($innerDeeperValue)) {
                                                                $indicatorData['indicator'][$indicator_key][$sub_key][$inner_key][$deep_key][$inner_deep_key][$deeperKey][$innerDeeperKey] = array_values($innerDeeperValue);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $indicatorData;
    }

    /**
     * Return specific result indicator.
     *
     * @param $resultId
     * @param $resultIndicatorId
     *
     * @return Model|null
     */
    public function getResultIndicator($resultId, $resultIndicatorId): ?Model
    {
        return $this->resultIndicator->where('id', $resultIndicatorId)->where('result_id', $resultId)->first();
    }

    /**
     * Return specific indicator.
     *
     * @param $resultIndicatorId
     *
     * @return Model|null
     */
    public function getIndicator($resultIndicatorId): ?Model
    {
        return $this->resultIndicator->where('id', $resultIndicatorId)->first();
    }

    /**
     * Returns all indicator belonging to resultId.
     *
     * @param int $resultId
     * @param int $page
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaginatedIndicator($resultId, $page = 1): Collection | \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->resultIndicator->where('result_id', $resultId)->orderBy('created_at', 'DESC')->paginate(10, ['*'], 'indicator', $page);
    }
}
