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
     * @param ResultRepository         $resultRepository
     * @param ResultElementFormCreator $resultElementFormCreator
     */
    public function __construct(ResultRepository $resultRepository, ResultElementFormCreator $resultElementFormCreator)
    {
        $this->resultRepository = $resultRepository;
        $this->resultElementFormCreator = $resultElementFormCreator;
    }

    /**
     * Returns paginated results.
     *
     * @param $activityId
     * @param $page
     *
     * @return LengthAwarePaginator|Collection
     */
    public function getPaginatedResult($activityId, $page): LengthAwarePaginator|Collection
    {
        return $this->resultRepository->getPaginatedResult($activityId, $page);
    }

    /*
     * Return results of specific activity
     *
     * @param $activityId
     * @return array
     */
    public function getActivityResults($activityId): array
    {
        return $this->resultRepository->getActivityResults($activityId);
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
        return $this->resultRepository->create($this->sanitizeResultData($resultData));
    }

    /**
     * Update Activity Result.
     *
     * @param       $resultId
     * @param array $resultData
     *
     * @return bool
     */
    public function update($resultId, array $resultData): bool
    {
        return $this->resultRepository->update($resultId, $this->sanitizeResultData($resultData));
    }

    /**
     * Returns specific result.
     *
     * @param $id
     *
     * @return object|null
     */
    public function getResult($id): ?object
    {
        return $this->resultRepository->find($id);
    }

    /**
     * Function to sanitize result data.
     *
     * @param array $resultData
     *
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
     * Returns result create form.
     *
     * @param $activityId
     *
     * @return Form
     * @throws \JsonException
     */
    public function createFormGenerator($activityId): Form
    {
        $element = getElementSchema('result');
        $this->resultElementFormCreator->url = route('admin.activity.result.store', $activityId);

        return $this->resultElementFormCreator->editForm([], $element, 'POST', '/activity/' . $activityId);
    }

    /**
     * Generates result edit form.
     *
     * @param $activityId
     * @param $resultId
     *
     * @return Form
     * @throws \JsonException
     */
    public function editFormGenerator($activityId, $resultId): Form
    {
        $element = getElementSchema('result');
        $activityResult = $this->getResult($resultId);
        $this->resultElementFormCreator->url = route('admin.activity.result.update', [$activityId, $resultId]);

        return $this->resultElementFormCreator->editForm($activityResult->result, $element, 'PUT', '/activity/' . $activityId);
    }

    /**
     * Checks if result has indicator and periods.
     *
     * @param $results
     *
     * @return int[]
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
            'period'    => $hasPeriod,
        ];
    }
}
