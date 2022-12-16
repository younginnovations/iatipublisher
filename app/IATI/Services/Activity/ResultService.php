<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Repositories\Activity\ResultRepository;
use App\IATI\Traits\DataSanitizeTrait;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ResultService.
 */
class ResultService
{
    use XmlBaseElement, DataSanitizeTrait;

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
     * @param int $activityId
     * @param int $page
     *
     * @return LengthAwarePaginator|Collection
     */
    public function getPaginatedResult(int $activityId, int $page): LengthAwarePaginator|Collection
    {
        $results = $this->resultRepository->getPaginatedResult($activityId, $page);

        foreach ($results as $idx => $result) {
            $results[$idx]['default_title_narrative'] = $result->default_title_narrative;
        }

        return $results;
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
     * Checks if specific result exists for specific activity.
     *
     * @param int $activityId
     * @param int $id
     *
     * @return bool
     */
    public function activityResultExists(int $activityId, int $id): bool
    {
        return $this->getActivityResult($activityId, $id) !== null;
    }

    /**
     * Returns specific result of specific activity.
     *
     * @param int $activityId
     * @param int $id
     *
     * @return mixed
     */
    public function getActivityResult(int $activityId, int $id): mixed
    {
        return $this->resultRepository->getActivityResult($activityId, $id);
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
     * Create a new ActivityResult.
     *
     * @param array $resultData
     *
     * @return Model
     */
    public function create(array $resultData): Model
    {
        $resultData['result'] = $this->sanitizeData($resultData['result']);

        return $this->resultRepository->create($resultData);
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
        $resultData['result'] = $this->sanitizeData($resultData['result']);

        return $this->resultRepository->update($resultId, $resultData);
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
     * Checks if result indicator has ref code.
     *
     * @param $resultId
     *
     * @return bool
     */
    public function indicatorHasRefCode($resultId): bool
    {
        $result = $this->resultRepository->getResultWithIndicator($resultId);

        if (!empty($result['indicators'])) {
            $indicators = $result['indicators'];

            foreach ($indicators as $item) {
                $indicator = $item['indicator'];
                $refs = $indicator['reference'];

                if (!empty($refs)) {
                    foreach ($refs as $ref) {
                        if (array_key_exists('code', $ref) && $ref['code'] && !empty($ref['code'])) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * Checks if result indicator has ref code.
     *
     * @param $resultId
     *
     * @return bool
     */
    public function resultHasRefCode($resultId): bool
    {
        $result = $this->resultRepository->getResult($resultId);

        if (!empty($result['result']) && array_key_exists('reference', $result['result']) && !empty($result['result']['reference'])) {
            $refs = $result['result']['reference'];

            foreach ($refs as $ref) {
                if (array_key_exists('code', $ref) && $ref['code']) {
                    return true;
                }
            }
        }

        return false;
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
    public function editFormGenerator($resultId, $activityId): Form
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
                    '@attributes'   => [
                        'type'               => Arr::get($result, 'type', null),
                        'aggregation-status' => Arr::get($result, 'aggregation_status', null),
                    ],
                    'title'         => [
                        'narrative' => $this->buildNarrative(Arr::get($result, 'title.0.narrative', [])),
                    ],
                    'description'   => [
                        'narrative' => $this->buildNarrative(Arr::get($result, 'description.0.narrative', [])),
                    ],
                    'document-link' => $this->buildDocumentLink(Arr::get($result, 'document_link', [])),
                    'reference'     => $this->buildReference(Arr::get($result, 'reference', []), 'vocabulary-uri'),
                    'indicator'     => $this->buildIndicator($totalResult->indicators),
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
                    '@attributes'   => [
                        'measure'            => Arr::get($indicator, 'measure', null),
                        'ascending'          => Arr::get($indicator, 'ascending', null),
                        'aggregation-status' => Arr::get($indicator, 'aggregation_status', null),
                    ],
                    'title'         => [
                        'narrative' => $this->buildNarrative(Arr::get($indicator, 'title.0.narrative', null)),
                    ],
                    'description'   => [
                        'narrative' => $this->buildNarrative(Arr::get($indicator, 'description.0.narrative', null)),
                    ],
                    'document-link' => $this->buildDocumentLink(Arr::get($indicator, 'document_link', [])),
                    'reference'     => $this->buildReference(Arr::get($indicator, 'reference', []), 'indicator-uri'),
                    'baseline'      => $this->buildBaseline(Arr::get($indicator, 'baseline', []), Arr::get($indicator, 'measure', null)),
                    'period'        => $this->buildPeriod($totalIndicator->periods, Arr::get($indicator, 'measure', null)),
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

                if ($measure !== 5) {
                    $baselineValue = Arr::get($baseline, 'value', null);
                }

                $baselineData[] = [
                    '@attributes'   => [
                        'year'     => Arr::get($baseline, 'year', null),
                        'iso-date' => Arr::get($baseline, 'date', null),
                        'value'    => $baselineValue,
                    ],
                    'location'      => $this->buildLocation(Arr::get($baseline, 'location', [])),
                    'dimension'     => $this->buildDimension(Arr::get($baseline, 'dimension', []), $measure),
                    'document-link' => $this->buildDocumentLink(Arr::get($baseline, 'document_link', [])),
                    'comment'       => [
                        'narrative' => $this->buildNarrative(Arr::get($baseline, 'comment.0.narrative')),
                    ],
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
                    'period-end'   => [
                        '@attributes' => [
                            'iso-date' => Arr::get($period, 'period_end.0.date', null),
                        ],
                    ],
                    'target'       => $this->buildFunction(Arr::get($period, 'target', []), $measure),
                    'actual'       => $this->buildFunction(Arr::get($period, 'actual', []), $measure),
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
                    '@attributes'   => [
                        'value' => Arr::get($period, 'value', null),
                    ],
                    'location'      => $this->buildLocation(Arr::get($period, 'location', [])),
                    'dimension'     => $this->buildDimension(Arr::get($period, 'dimension', []), $measure),
                    'comment'       => [
                        'narrative' => $this->buildNarrative(Arr::get($period, 'comment.0.narrative', [])),
                    ],
                    'document-link' => $this->buildDocumentLink(Arr::get($period, 'document_link', [])),
                ];
            }
        }

        return $targetData;
    }

    /**
     * Deletes specific result.
     *
     * @param $id
     *
     * @return bool
     */
    public function deleteResult($id): bool
    {
        return $this->resultRepository->delete($id);
    }
}
