<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Models\Activity\Period;
use App\IATI\Repositories\Activity\PeriodRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class PeriodService.
 */
class PeriodService
{
    /**
     * @var PeriodRepository
     */
    protected PeriodRepository $periodRepository;

    /**
     * @var ResultElementFormCreator
     */
    protected ResultElementFormCreator $resultElementFormCreator;

    /**
     * PeriodService constructor.
     *
     * @param PeriodRepository $periodRepository
     * @param ResultElementFormCreator $resultElementFormCreator
     */
    public function __construct(PeriodRepository $periodRepository, ResultElementFormCreator $resultElementFormCreator)
    {
        $this->periodRepository = $periodRepository;
        $this->resultElementFormCreator = $resultElementFormCreator;
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
        return $this->periodRepository->store($this->sanitizePeriodData($periodData));
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
        return $this->periodRepository->update($resultIndicatorPeriod->id, ['period' => Arr::get($this->sanitizePeriodData($periodData), 'period', [])]);
    }

    /**
     * Return specific result indicator period.
     *
     * @param $indicatorId
     * @param $indicatorPeriodId
     *
     * @return Model
     */
    public function getIndicatorPeriod($indicatorId, $indicatorPeriodId): Model
    {
        return $this->periodRepository->getIndicatorPeriod($indicatorId, $indicatorPeriodId);
    }

    /**
     * Generates create period form.
     *
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     * @param $periodId
     *
     * @return Form
     */
    public function editFormGenerator($activityId, $resultId, $indicatorId, $periodId): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $indicatorPeriod = $this->getIndicatorPeriod($indicatorId, $periodId);
        $this->resultElementFormCreator->url = route('admin.indicator.period.update', [$activityId, $resultId, $indicatorId, $periodId]);

        return $this->resultElementFormCreator->editForm($indicatorPeriod->period, $element['period'], 'PUT', '/activity/' . $activityId);
    }

    /**
     * Generates create period form.
     *
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return Form
     */
    public function createFormGenerator($activityId, $resultId, $indicatorId): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $this->resultElementFormCreator->url = route('admin.indicator.period.store', [$activityId, $resultId, $indicatorId]);

        return $this->resultElementFormCreator->editForm([], $element['period'], 'POST', '/activity/' . $activityId);
    }

    /**
     * Return specific result indicator period.
     *
     * @param $indicatorId
     *
     * @return object
     */
    public function getPeriodOfIndicator($indicatorId): object
    {
        return $this->periodRepository->findAllBy('indicator_id', $indicatorId);
    }

    /**
     * Returns specific period.
     *
     * @param $periodId
     *
     * @return object|null
     */
    public function getPeriod($periodId): ?object
    {
        return $this->periodRepository->find($periodId);
    }

    /**
     * Returns array of paginated period belonging to indicator of an result.
     *
     * @param $indicatorId
     * @param $page
     *
     * return LengthAwarePaginator|Collection
     */
    public function getPaginatedPeriod($indicatorId, $page): LengthAwarePaginator|Collection
    {
        return $this->periodRepository->getPaginatedPeriod($indicatorId, $page);
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
}
