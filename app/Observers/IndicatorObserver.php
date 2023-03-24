<?php

declare(strict_types=1);

namespace App\Observers;

use App\IATI\Models\Activity\Indicator;
use App\IATI\Services\ElementCompleteService;

/**
 * Class IndicatorObserver.
 */
class IndicatorObserver
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
        $this->setIndicatorDefaultValues($indicator);
        $resultObserver->updateActivityElementStatus($indicator->result);

        if (!$indicator->migrated_from_aidstream) {
            $resultObserver->resetActivityStatus($indicator->result);
        }
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

        $this->setIndicatorDefaultValues($indicator);
        $resultObserver->updateActivityElementStatus($indicator->result);
        $resultObserver->resetActivityStatus($indicator->result);
    }

    /**
     * Sets default values for language and currency for indicator.
     *
     * @param $indicator
     *
     * @return void
     * @throws \JsonException
     */
    public function setIndicatorDefaultValues($indicator): void
    {
        $indicatorData = $indicator->indicator;
        $updatedData = $this->elementCompleteService->setDefaultValues($indicatorData, $indicator->result->activity);
        $indicator->indicator = $updatedData;
        $indicator->saveQuietly();
    }
}
