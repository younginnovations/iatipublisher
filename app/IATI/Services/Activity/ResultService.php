<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Repositories\Activity\ResultRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ResultService.
 */
class ResultService
{
    /**
     * @var ResultRepository
     */
    protected ResultRepository $resultRepository;

    /**
     * @var ResultElementFormCreator
     */
    protected ResultElementFormCreator $resultElementFormCreator;

    /**
     * ResultService constructor.
     *
     * @param ResultRepository $resultRepository
     * @param ResultElementFormCreator $resultElementFormCreator
     */
    public function __construct(ResultRepository $resultRepository, ResultElementFormCreator $resultElementFormCreator)
    {
        $this->resultRepository = $resultRepository;
        $this->resultElementFormCreator = $resultElementFormCreator;
    }

    /**
     * Create a new ActivityResult.
     *
     * @param array $resultData
     *
     * @return Model
     */
    public function create(array $resultData): Model
    {
        return $this->resultRepository->create($resultData);
    }

    /**
     * Update Activity Result.
     *
     * @param array          $resultData
     * @param $activityResult
     *
     * @return bool
     */
    public function update(array $resultData, $activityResult): bool
    {
        return $this->resultRepository->update($resultData, $activityResult);
    }

    /**
     * Return specific result.
     *
     * @param $id
     *
     * @return Model
     */
    public function getResult($id): Model
    {
        return $this->resultRepository->getResult($id);
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
        return $this->resultRepository->getActivityResultsWithIndicatorsAndPeriods($activityId);
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
        return $this->resultRepository->getResultWithIndicatorAndPeriod($resultId, $activityId);
    }

    /**
     * Generates transaction create form.
     *
     * @param $activityId
     *
     * @return Form
     */
    public function createFormGenerator($activityId): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $this->resultElementFormCreator->url = route('admin.activity.result.store', $activityId);

        return $this->resultElementFormCreator->editForm([], $element['result'], 'POST', '/activity/' . $activityId);
    }

    /**
     * Generates transaction edit form.
     *
     * @param $resultId
     * @param $activityId
     *
     * @return Form
     */
    public function editFormGenerator($resultId, $activityId): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $activityResult = $this->getResult($resultId, $activityId);
        $this->resultElementFormCreator->url = route('admin.activity.result.update', [$activityId, $resultId]);

        return $this->resultElementFormCreator->editForm($activityResult->result, $element['result'], 'PUT', '/activity/' . $activityId);
    }

    /**
     * Checks if result has indicator and periods.
     *
     * @param $result
     */
    public function checkResultIndicatorPeriod($results): array
    {
        $hasIndicator = 0;
        $hasPeriod = 0;

        if (count($results)) {
            foreach ($results as $result) {
                if (count($result->indicators)) {
                    $hasIndicator = 1;

                    foreach ($result->indicators as $indicator) {
                        if (count($indicator->periods)) {
                            $hasPeriod = 1;
                            break;
                        }
                    }
                }
            }
        }

        return [
            'indicator' => $hasIndicator,
            'period' => $hasPeriod,
        ];
    }

    /*
     * Return specific result.
     *
     * @param $activityId
     * @return array
     */
    public function getActivityResult($activityId): array
    {
        return $this->resultRepository->getActivityResult($activityId);
    }

    /**
     * Returns array of paginated results belonging to an activity.
     *
     * @param $activityId
     * @param $page
     *
     * return LengthAwarePaginator|Collection
     */
    public function getPaginatedResult($activityId, $page): LengthAwarePaginator|Collection
    {
        return $this->resultRepository->getPaginatedResult($activityId, $page);
    }
}
