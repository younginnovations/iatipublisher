<?php

declare(strict_types=1);

namespace App\Observers;

use App\IATI\Models\Activity\Period;
use App\IATI\Services\ElementCompleteService;

/**
 * Class PeriodObserver.
 */
class PeriodObserver
{
    /**
     * @var ElementCompleteService
     */
    protected ElementCompleteService $elementCompleteService;

    /**
     * Indicator observer constructor.
     */
    public function __construct()
    {
        $this->elementCompleteService = new ElementCompleteService();
    }

    /**
     * Handle the Period "created" event.
     *
     * @param Period $period
     *
     * @return void
     * @throws \JsonException
     */
    public function created(Period $period): void
    {
        $resultObserver = new ResultObserver();

        $resultObserver->updateActivityElementStatus($period->indicator->result);
        $resultObserver->resetActivityStatus($period->indicator->result);
        $this->setPeriodDefaultValues($period);
    }

    /**
     * Handle the Period "updated" event.
     *
     * @param Period $period
     *
     * @return void
     * @throws \JsonException
     */
    public function updated(Period $period): void
    {
        $resultObserver = new ResultObserver();

        $resultObserver->updateActivityElementStatus($period->indicator->result);
        $resultObserver->resetActivityStatus($period->indicator->result);
        $this->setPeriodDefaultValues($period);
    }

    /**
     * Sets default values for language and currency for period.
     *
     * @param $period
     *
     * @return void
     */
    public function setPeriodDefaultValues($period): void
    {
        $periodData = $period->period;
        $updatedData = $this->elementCompleteService->setDefaultValues($periodData, $period->indicator->result->activity);
        $period->period = $updatedData;
        $period->saveQuietly();
    }
}
