<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Repositories\Activity\IndicatorRepository;
use App\IATI\Traits\DataSanitizeTrait;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Kris\LaravelFormBuilder\Form;

/**
 * Class IndicatorService.
 */
class IndicatorService
{
    use DataSanitizeTrait;

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
     * @param IndicatorRepository      $indicatorRepository
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
        $indicators = $this->indicatorRepository->getPaginatedIndicator($resultId, $page);

        foreach ($indicators as $idx => $indicator) {
            $indicators[$idx]['default_title_narrative'] = $indicator->default_title_narrative;
        }

        return $indicators;
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
     * Checks if specific indicator exists for specific result.
     *
     * @param int $resultId
     * @param int $id
     *
     * @return bool
     */
    public function resultIndicatorExists(int $resultId, int $id): bool
    {
        return $this->getResultIndicator($resultId, $id) !== null;
    }

    /**
     * Returns specific result of specific activity.
     *
     * @param int $resultId
     * @param int $id
     *
     * @return mixed
     */
    public function getResultIndicator(int $resultId, int $id): mixed
    {
        return $this->indicatorRepository->getResultIndicator($resultId, $id);
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
        $indicatorData['indicator'] = $this->sanitizeData($indicatorData['indicator']);
        $indicatorData['indicator_code'] = Auth::user()->id . Carbon::now();

        return $this->indicatorRepository->store($indicatorData);
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
        $indicatorData['indicator'] = $this->sanitizeData($indicatorData['indicator']);

        return $this->indicatorRepository->update($id, $indicatorData);
    }

    /**
     * Generates create indicator form.
     *
     * @param $resultId
     *
     * @return Form
     * @throws \JsonException
     */
    public function createFormGenerator($resultId): Form
    {
        $element = getElementSchema('indicator');
        $this->resultElementFormCreator->url = route('admin.result.indicator.store', [$resultId]);

        return $this->resultElementFormCreator->editForm([], $element, 'POST', route('admin.result.indicator.index', $resultId));
    }

    /**
     * Generates indicator form.
     *
     * @param $resultId
     * @param $indicatorId
     *
     * @return Form
     * @throws \JsonException
     */
    public function editFormGenerator($resultId, $indicatorId): Form
    {
        $element = getElementSchema('indicator');
        $resultIndicator = $this->getIndicator($indicatorId);
        $this->resultElementFormCreator->url = route('admin.result.indicator.update', [$resultId, $indicatorId]);

        return $this->resultElementFormCreator->editForm($resultIndicator->indicator, $element, 'PUT', route('admin.result.indicator.index', $resultId));
    }

    /**
     * Deletes indicator.
     *
     * @param $id
     *
     * @return bool
     */
    public function deleteIndicator($id): bool
    {
        return $this->indicatorRepository->delete($id);
    }

    /**
     * Returns indicator measure.
     *
     * @param $indicatorId
     *
     * @return string
     */
    public function getIndicatorMeasure($indicatorId): string
    {
        $indicator = $this->getIndicator($indicatorId)->toArray();

        if (!empty($indicator) && (array_key_exists('indicator', $indicator) && array_key_exists('measure', $indicator['indicator']))) {
            return (string) $indicator['indicator']['measure'];
        }

        return '';
    }

    /**
     * Returns indicator measure type.
     *
     * @param $indicatorId
     *
     * @return array
     */
    public function getIndicatorMeasureType($indicatorId): array
    {
        $measure = $this->getIndicatorMeasure($indicatorId);

        return ['qualitative' => $measure === '5', 'non_qualitative' =>  in_array($measure, ['1', '2', '3', '4'])];
    }
}
