<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Repositories\Activity\IndicatorRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
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
     * @return Model
     */
    public function create(array $indicatorData): Model
    {
        return $this->indicatorRepository->create($indicatorData);
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
        return $this->indicatorRepository->update($indicatorData, $activityResultIndicator);
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
     * @return Model|null
     */
    public function getIndicator($id): ?Model
    {
        return $this->indicatorRepository->getIndicator($id);
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

    /*
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
}
