<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Period;
use App\IATI\Repositories\Activity\PeriodRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
     * PeriodService constructor.
     *
     * @param PeriodRepository $periodRepository
     */
    public function __construct(PeriodRepository $periodRepository)
    {
        $this->periodRepository = $periodRepository;
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
}
