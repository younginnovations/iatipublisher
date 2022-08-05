<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Models\Activity\Period;
use App\IATI\Repositories\Activity\PeriodRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
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
        return $this->periodRepository->create($periodData);
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
        return $this->periodRepository->update($periodData, $resultIndicatorPeriod);
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
        $this->resultElementFormCreator->url = route('admin.activities.result.indicator.period.update', [$activityId, $resultId, $indicatorId, $periodId]);

        return $this->resultElementFormCreator->editForm($indicatorPeriod->period, $element['period'], 'PUT', '/activities/' . $activityId);
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
        $this->resultElementFormCreator->url = route('admin.activities.result.indicator.period.store', [$activityId, $resultId, $indicatorId]);

        return $this->resultElementFormCreator->editForm([], $element['period'], 'POST', '/activities/' . $activityId);
    }

    /*
     * Return specific result indicator period.
     *
     * @param $indicatorId
     *
     * @return Collection
     */
    public function getPeriodOfIndicator($indicatorId): Collection
    {
        return $this->periodRepository->getPeriodOfIndicator($indicatorId);
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
}
