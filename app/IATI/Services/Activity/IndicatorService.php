<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Indicator;
use App\IATI\Repositories\Activity\IndicatorRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
     * IndicatorService constructor.
     *
     * @param IndicatorRepository $indicatorRepository
     */
    public function __construct(IndicatorRepository $indicatorRepository)
    {
        $this->indicatorRepository = $indicatorRepository;
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
     * @return Model
     */
    public function getResultIndicator($resultId, $resultIndicatorId): Model
    {
        return $this->indicatorRepository->getResultIndicator($resultId, $resultIndicatorId);
    }
}
