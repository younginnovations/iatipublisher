<?php

declare(strict_types=1);

namespace App\Observers;

use App\IATI\Models\Activity\Result;
use App\IATI\Services\ElementCompleteService;

/**
 * Class ResultObserver.
 */
class ResultObserver
{
    /**
     * @var ElementCompleteService
     */
    protected ElementCompleteService $elementCompleteService;

    /**
     * Result observer constructor.
     */
    public function __construct()
    {
        $this->elementCompleteService = new ElementCompleteService();
    }

    /**
     * Updates the result complete status.
     *
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
     * Handle the Result "created" event.
     *
     * @param Result $result
     *
     * @return void
     * @throws \JsonException
     */
    public function created(Result $result): void
    {
        $this->updateActivityElementStatus($result);
        $this->resetActivityStatus($result);
    }

    /**
     * Handle the Result "updated" event.
     *
     * @param Result $result
     *
     * @return void
     * @throws \JsonException
     */
    public function updated(Result $result): void
    {
        $this->updateActivityElementStatus($result);
        $this->resetActivityStatus($result);
    }

    /**
     * Resets activity status to draft.
     *
     * @param $result
     *
     * @return void
     */
    public function resetActivityStatus($result)
    {
        $activityObject = $result->activity;
        $activityObject->status = 'draft';
        $activityObject->saveQuietly();
    }
}
