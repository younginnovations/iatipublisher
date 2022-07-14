<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Repositories\Activity\ResultRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Kris\LaravelFormBuilder\Form;
use Illuminate\Support\Arr;

/**
 * Class ResultService.
 */
class ResultService
{
    use XmlBaseElement;

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
     * @return Model
     */
    public function getResultWithIndicatorAndPeriod($resultId, $activityId): Model
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
        $this->resultElementFormCreator->url = route('admin.activities.result.store', $activityId);

        return $this->resultElementFormCreator->editForm([], $element['result'], 'POST', '/activities/' . $activityId);
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
        $this->resultElementFormCreator->url = route('admin.activities.result.update', [$activityId, $resultId]);

        return $this->resultElementFormCreator->editForm($activityResult->result, $element['result'], 'PUT', '/activities/' . $activityId);
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

    /**
     * Returns data in required xml array format.
     *
     * @param Collection $results
     *
     * @return array
     */
    public function getXmlData(Collection $results): array
    {
        $resultData = [];

        if (count($results)) {
            foreach ($results as $totalResult) {
                $result = $totalResult->result;

                $resultData[] = [
                    '@attributes' => [
                        'type' => Arr::get($result, 'type', null),
                        'aggregation-status' => Arr::get($result, 'aggregation_status', null),
                    ],
                    'title' => [
                        'narrative' => $this->buildNarrative(Arr::get($result, 'title.0.narrative', [])),
                    ],
                    'description' => [
                        'narrative' => $this->buildNarrative(Arr::get($result, 'description.0.narrative', [])),
                    ],
                    'document-link' => $this->buildDocumentLink(Arr::get($result, 'document_link', [])),
                    'reference' => $this->buildReference(Arr::get($result, 'reference', []), 'vocabulary-uri'),
                    'indicator' => $this->buildIndicator($totalResult->indicators),
                ];
            }
        }

        return $resultData;
    }

    /**
     * Returns xml data for result indicator.
     *
     * @param $indicators
     *
     * @return array
     */
    protected function buildIndicator($indicators): array
    {
        $indicatorData = [];

        if (count($indicators)) {
            foreach ($indicators as $totalIndicator) {
                $indicator = $totalIndicator->indicator;

                $indicatorData[] = [
                    '@attributes' => [
                        'measure' => Arr::get($indicator, 'measure', null),
                        'ascending' => Arr::get($indicator, 'ascending', null),
                        'aggregation-status' => Arr::get($indicator, 'aggregation_status', null),
                    ],
                    'title' => [
                        'narrative' => $this->buildNarrative(Arr::get($indicator, 'title.0.narrative', null)),
                    ],
                    'description' => [
                        'narrative' => $this->buildNarrative(Arr::get($indicator, 'description.0.narrative', null)),
                    ],
                    'document-link' => $this->buildDocumentLink(Arr::get($indicator, 'document_link', [])),
                    'reference' => $this->buildReference(Arr::get($indicator, 'reference', []), 'indicator-uri'),
                    'baseline' => $this->buildBaseline(Arr::get($indicator, 'baseline', []), Arr::get($indicator, 'measure', null)),
                    'period' => $this->buildPeriod($totalIndicator->periods, Arr::get($indicator, 'measure', null)),
                ];
            }
        }

        return $indicatorData;
    }

    /**
     * Returns xml data for baseline.
     *
     * @param $baselines
     * @param $measure
     *
     * @return array
     */
    protected function buildBaseline($baselines, $measure = null): array
    {
        $baselineData = [];

        if (count($baselines)) {
            foreach ($baselines as $baseline) {
                $baselineValue = null;

                if ($measure != 5) {
                    $baselineValue = Arr::get($baseline, 'value', null);
                }

                $baselineData[] = [
                    '@attributes' => [
                        'year' => Arr::get($baseline, 'year', null),
                        'iso-date' => Arr::get($baseline, 'date', null),
                        'value' => $baselineValue,
                    ],
                    'comment' => [
                        'narrative' => $this->buildNarrative(Arr::get($baseline, 'comment.0.narrative')),
                    ],
                    'dimension' => $this->buildDimension(Arr::get($baseline, 'dimension', []), $measure),
                    'document-link' => $this->buildDocumentLink(Arr::get($baseline, 'document_link', [])),
                    'location' => $this->buildLocation(Arr::get($baseline, 'location', [])),
                ];
            }
        }

        return $baselineData;
    }

    /**
     * Returns xml data for periods.
     *
     * @param $periods
     * @param $measure
     *
     * @return array
     */
    protected function buildPeriod($periods, $measure = null): array
    {
        $periodData = [];

        if (count($periods)) {
            foreach ($periods as $totalPeriod) {
                $period = $totalPeriod->period;

                $periodData[] = [
                    'period-start' => [
                        '@attributes' => [
                            'iso-date' => Arr::get($period, 'period_start.0.date', null),
                        ],
                    ],
                    'period-end' => [
                        '@attributes' => [
                            'iso-date' => Arr::get($period, 'period_end.0.date', null),
                        ],
                    ],
                    'target' => $this->buildFunction(Arr::get($period, 'target', []), $measure),
                    'actual' => $this->buildFunction(Arr::get($period, 'actual', []), $measure),
                ];
            }
        }

        return $periodData;
    }

    /**
     * Returns xml data for period target and actual data.
     *
     * @param $data
     * @param $measure
     *
     * @return array
     */
    protected function buildFunction($data, $measure = null): array
    {
        $targetData = [];

        if (count($data)) {
            foreach ($data as $period) {
                $targetData[] = [
                    '@attributes' => [
                        'value' => Arr::get($period, 'value', null),
                    ],
                    'comment' => [
                        'narrative' => $this->buildNarrative(Arr::get($period, 'comment.0.narrative', [])),
                    ],
                    'dimension' => $this->buildDimension(Arr::get($period, 'dimension', []), $measure),
                    'document-link' => $this->buildDocumentLink(Arr::get($period, 'document_link', [])),
                    'location' => $this->buildLocation(Arr::get($period, 'location', [])),
                ];
            }
        }

        return $targetData;
    }
}
