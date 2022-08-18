<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Models\Activity\Period;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PeriodRepository.
 */
class PeriodRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * @var Period
     */
    protected Period $indicatorPeriod;

    /**
     * PeriodRepository Constructor.
     *
     * @param Activity $activity
     * @param Period $indicatorPeriod
     */
    public function __construct(Activity $activity, Period $indicatorPeriod)
    {
        $this->activity = $activity;
        $this->indicatorPeriod = $indicatorPeriod;
    }

    /**
     * Create a new Period.
     *
     * @param array $periodData
     *
     * @return Model
     */
    public function create(array $periodData): Model
    {
        $periodData = $this->sanitizePeriodData($periodData);

        return $this->indicatorPeriod->create($periodData);
    }

    /**
     * Update Indicator Period.
     *
     * @param array $periodData
     * @param Period $resultIndicatorPeriod
     *
     * @return bool
     */
    public function update(array $periodData, Period $resultIndicatorPeriod): bool
    {
        $periodData = $this->sanitizePeriodData($periodData);
        $resultIndicatorPeriod->period = $periodData['period'];

        return $resultIndicatorPeriod->save();
    }

    /**
     * Function to sanitize indicator data.
     *
     * @param array $periodData
     *
     * @return array
     */
    public function sanitizePeriodData(array $periodData): array
    {
        foreach ($periodData['period'] as $period_key => $period) {
            if (is_array($period)) {
                $periodData['period'][$period_key] = array_values($period);

                foreach ($periodData['period'][$period_key] as $sub_key => $sub_element) {
                    if (is_array($sub_element)) {
                        foreach ($periodData['period'][$period_key][$sub_key] as $inner_key => $inner_element) {
                            if (is_array($inner_element)) {
                                $periodData['period'][$period_key][$sub_key][$inner_key] = array_values($inner_element);

                                foreach ($periodData['period'][$period_key][$sub_key][$inner_key] as $deep_key => $deep_element) {
                                    if (is_array($deep_element)) {
                                        foreach ($periodData['period'][$period_key][$sub_key][$inner_key][$deep_key] as $inner_deep_key => $inner_deep_element) {
                                            if (is_array($inner_deep_element)) {
                                                $periodData['period'][$period_key][$sub_key][$inner_key][$deep_key][$inner_deep_key] = array_values($inner_deep_element);

                                                foreach ($periodData['period'][$period_key][$sub_key][$inner_key][$deep_key][$inner_deep_key] as $deeperKey => $deeperValue) {
                                                    if (is_array($deeperValue)) {
                                                        foreach ($periodData['period'][$period_key][$sub_key][$inner_key][$deep_key][$inner_deep_key][$deeperKey] as $innerDeeperKey => $innerDeeperValue) {
                                                            if (is_array($innerDeeperValue)) {
                                                                $periodData['period'][$period_key][$sub_key][$inner_key][$deep_key][$inner_deep_key][$deeperKey][$innerDeeperKey] = array_values($innerDeeperValue);
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

        return $periodData;
    }

    /**
     * Return specific indicator period.
     *
     * @param $indicatorId
     * @param $periodId
     *
     * @return Model
     */
    public function getIndicatorPeriod($indicatorId, $periodId): Model
    {
        return $this->indicatorPeriod->where('id', $periodId)->where('indicator_id', $indicatorId)->first();
    }

    /**
     * Return periods belonging to an indicator.
     *
     * @param $indicatorId
     *
     * @return Collection
     */
    public function getPeriodOfIndicator($indicatorId): Collection
    {
        return $this->indicatorPeriod->where('indicator_id', $indicatorId)->get();
    }

    /**
     * Returns all period belonging to indicator id.
     *
     * @param int $indicatorId
     * @param int $page
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaginatedPeriod($indicatorId, $page = 1): Collection | \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->indicatorPeriod->where('indicator_id', $indicatorId)->orderBy('created_at', 'DESC')->paginate(10, ['*'], 'indicator', $page);
    }

    /**
     * Returns specific period.
     *
     * @param $id
     *
     * @return Model
     */
    public function getPeriod($id): Model
    {
        return $this->indicatorPeriod->where('id', $id)->first();
    }
}
