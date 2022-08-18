<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ResultElementFormCreator;
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
     * @param PeriodRepository         $periodRepository
     * @param ResultElementFormCreator $resultElementFormCreator
     */
    public function __construct(PeriodRepository $periodRepository, ResultElementFormCreator $resultElementFormCreator)
    {
        $this->periodRepository = $periodRepository;
        $this->resultElementFormCreator = $resultElementFormCreator;
    }

    /**
     * Return specific result indicator period.
     *
     * @param $indicatorId
     *
     * @return object
     */
    public function getPeriods($indicatorId): object
    {
        return $this->periodRepository->findAllBy('indicator_id', $indicatorId);
    }

    /**
     * Return specific result indicator period.
     *
     * @param $id
     *
     * @return object|null
     */
    public function getPeriod($id): ?object
    {
        return $this->periodRepository->find($id);
    }

    /**
     * Returns array of paginated period belonging to indicator of an result.
     *
     * @param int $indicatorId
     * @param int $page
     *
     * @return LengthAwarePaginator|Collection
     */
    public function getPaginatedPeriod(int $indicatorId, int $page): LengthAwarePaginator|Collection
    {
        return $this->periodRepository->getPaginatedPeriod($indicatorId, $page);
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
     * @param int $id
     * @param     $periodData
     *
     * @return bool
     */
    public function update(int $id, $periodData): bool
    {
        return $this->periodRepository->update($id, ['period' => Arr::get($this->sanitizePeriodData($periodData), 'period', [])]);
    }

    /**
     * Generates create period form.
     *
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return Form
     * @throws \JsonException
     */
    public function createFormGenerator($activityId, $resultId, $indicatorId): Form
    {
        $element = getElementSchema('period');
        $this->resultElementFormCreator->url = route('admin.indicator.period.store', [$activityId, $resultId, $indicatorId]);

        return $this->resultElementFormCreator->editForm([], $element, 'POST', '/activity/' . $activityId);
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
     * @throws \JsonException
     */
    public function editFormGenerator($activityId, $resultId, $indicatorId, $periodId): Form
    {
        $element = getElementSchema('period');
        $indicatorPeriod = $this->getPeriod($periodId);
        $this->resultElementFormCreator->url = route('admin.indicator.period.update', [$activityId, $resultId, $indicatorId, $periodId]);

        return $this->resultElementFormCreator->editForm($indicatorPeriod->period, $element, 'PUT', '/activity/' . $activityId);
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
