<?php

declare(strict_types=1);

namespace App\Observers;

use App\IATI\Models\Activity\Period;

/**
 * Class PeriodObserver.
 */
class PeriodObserver
{
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
    }
}
