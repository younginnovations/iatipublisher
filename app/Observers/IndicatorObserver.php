<?php

declare(strict_types=1);

namespace App\Observers;

use App\IATI\Models\Activity\Indicator;

/**
 * Class IndicatorObserver.
 */
class IndicatorObserver
{
    /**
     * Handle the Indicator "created" event.
     *
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
     * Handle the Indicator "updated" event.
     *
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
