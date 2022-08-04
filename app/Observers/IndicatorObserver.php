<?php

namespace App\Observers;

use App\IATI\Models\Activity\Indicator;

class IndicatorObserver
{
    /**
     * @param Indicator $indicator
     *
     * @return void
     * @throws \JsonException
     */
    public function created(Indicator $indicator): void
    {
        $resultObserver = new ResultObserver();

        $resultObserver->updateActivityElementStatus($indicator->result);
    }

    /**
     * @param Indicator $indicator
     *
     * @return void
     * @throws \JsonException
     */
    public function updated(Indicator $indicator): void
    {
        $resultObserver = new ResultObserver();

        $resultObserver->updateActivityElementStatus($indicator->result);
    }
}
