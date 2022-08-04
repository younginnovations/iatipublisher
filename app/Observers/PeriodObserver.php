<?php

namespace App\Observers;

use App\IATI\Models\Activity\Period;

class PeriodObserver
{
    /**
     * @param Period $period
     *
     * @return void
     * @throws \JsonException
     */
    public function created(Period $period): void
    {
        $resultObserver = new ResultObserver();

        $resultObserver->updateActivityElementStatus($period->indicator->result);
    }

    /**
     * @param Period $period
     *
     * @return void
     * @throws \JsonException
     */
    public function updated(Period $period): void
    {
        $resultObserver = new ResultObserver();

        $resultObserver->updateActivityElementStatus($period->indicator->result);
    }
}
