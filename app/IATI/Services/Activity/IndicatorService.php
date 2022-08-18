<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Repositories\Activity\IndicatorRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class IndicatorService.
 */
class IndicatorService
{
    /**
     * @var IndicatorRepository
     */
    protected IndicatorRepository $indicatorRepository;

    /**
     * @var ResultElementFormCreator
     */
    protected ResultElementFormCreator $resultElementFormCreator;

    /**
     * IndicatorService constructor.
     *
     * @param IndicatorRepository $indicatorRepository
     * @param ResultElementFormCreator $resultElementFormCreator
     */
    public function __construct(IndicatorRepository $indicatorRepository, ResultElementFormCreator $resultElementFormCreator)
    {
        $this->indicatorRepository = $indicatorRepository;
        $this->resultElementFormCreator = $resultElementFormCreator;
    }

    /**
     * Returns array of paginated indicator belonging to result of an activity.
     *
     * @param int $resultId
     * @param int $page
     *
     * @return LengthAwarePaginator|Collection
     */
    public function getPaginatedIndicator(int $resultId, int $page): LengthAwarePaginator|Collection
    {
        return $this->indicatorRepository->getPaginatedIndicator($resultId, $page);
    }

    /**
     * Return result indicators.
     *
     * @param $resultId
     *
     * @return Collection
     */
    public function getIndicators($resultId): Collection
    {
        return $this->indicatorRepository->getResultIndicators($resultId);
    }

    /**
     * Return specific result indicator.
     *
     * @param $id
     *
     * @return object|null
     */
    public function getIndicator($id): ?object
    {
        return $this->indicatorRepository->find($id);
    }

    /**
     * Create a new ResultIndicator.
     *
     * @param array $indicatorData
     *
     * @return object
     */
    public function create(array $indicatorData): object
    {
        return $this->indicatorRepository->store($this->sanitizeIndicatorData($indicatorData));
    }

    /**
     * Update Activity Result Indicator.
     *
     * @param       $id
     * @param array $indicatorData
     *
     * @return bool
     */
    public function update($id, array $indicatorData): bool
    {
        return $this->indicatorRepository->update($id, ['indicator' => Arr::get($this->sanitizeIndicatorData($indicatorData), 'indicator', [])]);
    }

    /**
     * Generates create indicator form.
     *
     * @param $activityId
     * @param $resultId
     *
     * @return Form
     * @throws \JsonException
     */
    public function createFormGenerator($activityId, $resultId): Form
    {
        $element = getElementSchema('indicator');
        $this->resultElementFormCreator->url = route('admin.result.indicator.store', [$activityId, $resultId]);

        return $this->resultElementFormCreator->editForm([], $element, 'POST', '/activity/' . $activityId);
    }

    /**
     * Generates indicator form.
     *
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return Form
     * @throws \JsonException
     */
    public function editFormGenerator($activityId, $resultId, $indicatorId): Form
    {
        $element = getElementSchema('indicator');
        $resultIndicator = $this->getIndicator($indicatorId);
        $this->resultElementFormCreator->url = route('admin.result.indicator.update', [$activityId, $resultId, $indicatorId]);

        return $this->resultElementFormCreator->editForm($resultIndicator->indicator, $element, 'PUT', '/activity/' . $activityId);
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
}
