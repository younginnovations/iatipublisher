<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Repositories\Activity\IndicatorRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
     * @param array $indicatorData
     * @param Indicator $activityResultIndicator
     *
     * @return bool
     */
    public function update(array $indicatorData, Indicator $activityResultIndicator): bool
    {
        return $this->indicatorRepository->update($activityResultIndicator->id, ['indicator' => Arr::get($this->sanitizeIndicatorData($indicatorData), 'indicator', [])]);
    }

    /**
     * Return result indicators.
     *
     * @param $resultId
     *
     * @return Collection
     */
    public function getResultIndicators($resultId): Collection
    {
        return $this->indicatorRepository->getResultIndicators($resultId);
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
        return $this->indicatorRepository->getResultIndicator($resultId, $resultIndicatorId);
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
     * Generates indicator form.
     *
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return Form
     */
    public function editFormGenerator($activityId, $resultId, $indicatorId): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $resultIndicator = $this->getResultIndicator($resultId, $indicatorId) ?? [];
        $this->resultElementFormCreator->url = route('admin.result.indicator.update', [$activityId, $resultId, $indicatorId]);

        return $this->resultElementFormCreator->editForm($resultIndicator->indicator, $element['indicator'], 'PUT', '/activity/' . $activityId);
    }

    /**
     * Generates create indicator form.
     *
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return Form
     */
    public function createFormGenerator($activityId, $resultId): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $this->resultElementFormCreator->url = route('admin.result.indicator.store', [$activityId, $resultId]);

        return $this->resultElementFormCreator->editForm([], $element['indicator'], 'POST', '/activity/' . $activityId);
    }

    /**
     * Returns array of paginated indicator belonging to result of an activity.
     *
     * @param $resultId
     * @param $page
     *
     * return LengthAwarePaginator|Collection
     */
    public function getPaginatedIndicator($resultId, $page): LengthAwarePaginator|Collection
    {
        return $this->indicatorRepository->getPaginatedIndicator($resultId, $page);
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
