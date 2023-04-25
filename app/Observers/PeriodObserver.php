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
        $changeUpdatedAt = !$period->migrated_from_aidstream;

        $resultObserver = new ResultObserver();

        $this->setPeriodDefaultValues($period, $changeUpdatedAt);
        $resultObserver->updateActivityElementStatus($period->indicator->result, $changeUpdatedAt);

        if ($changeUpdatedAt) {
            $resultObserver->resetActivityStatus($period->indicator->result);
        }
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

        $this->setPeriodDefaultValues($period);
        $resultObserver->updateActivityElementStatus($period->indicator->result);
        $resultObserver->resetActivityStatus($period->indicator->result);
    }

    /**
     * Sets default values for language and currency for period.
     *
     * @param $period
     * @param  bool  $changeUpdatedAt
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function setPeriodDefaultValues($period, bool $changeUpdatedAt = true): void
    {
        if (!$changeUpdatedAt) {
            $period->timestamps = false;
        }

        $period->saveQuietly();
    }
}
