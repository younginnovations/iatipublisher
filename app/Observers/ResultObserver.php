<?php

namespace App\Observers;

use App\IATI\Models\Activity\Result;
use App\IATI\Services\ElementCompleteService;

class ResultObserver
{
    protected ElementCompleteService $elementCompleteService;

    /**
     * Activity observer constructor.
     */
    public function __construct()
    {
        $this->elementCompleteService = new ElementCompleteService();
    }

    /**
     * @param $result
     *
     * @return void
     * @throws \JsonException
     */
    public function updateActivityElementStatus($result): void
    {
        $activityObj = $result->activity;
        $elementStatus = $activityObj->element_status;
        $elementStatus['result'] = $this->elementCompleteService->isResultElementCompleted($activityObj);

        $activityObj->element_status = $elementStatus;

        $activityObj->saveQuietly();
    }

    /**
     * @param Result $result
     *
     * @return void
     * @throws \JsonException
     */
    public function created(Result $result): void
    {
        $this->updateActivityElementStatus($result);
    }

    /**
     * @param Result $result
     *
     * @return void
     * @throws \JsonException
     */
    public function updated(Result $result): void
    {
        $this->updateActivityElementStatus($result);
    }
}
