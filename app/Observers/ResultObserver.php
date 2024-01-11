<?php

declare(strict_types=1);

namespace App\Observers;

use App\IATI\Models\Activity\Activity;
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
     * @param  bool  $changeUpdatedAt
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function updateActivityElementStatus($result, bool $changeUpdatedAt = true): void
    {
        $activityObj = $result->activity;
        $elementStatus = $activityObj->element_status;
        $elementStatus['result'] = $this->elementCompleteService->isResultElementCompleted($activityObj);
        $activityObj->element_status = $elementStatus;
        $activityObj->complete_percentage = $this->elementCompleteService->calculateCompletePercentage($activityObj->element_status);

        if (!$changeUpdatedAt) {
            $activityObj->timestamps = false;
            $activityObj->saveQuietly(['touch'=>false]);
        } else {
            $activityObj->saveQuietly();
        }
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
        $changeUpdatedAt = !$result->migrated_from_aidstream;

        $this->setResultDefaultValues($result, $changeUpdatedAt);
        $this->updateActivityElementStatus($result, $changeUpdatedAt);

        if ($changeUpdatedAt) {
            $this->resetActivityStatus($result);
        }
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
        $this->setResultDefaultValues($result);
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
    public function resetActivityStatus($result): void
    {
        $activityObject = $result->activity;
        $activityObject->status = 'draft';
        $activityObject->saveQuietly();
    }

    /**
     * Sets default values for language and currency for result.
     *
     * @param $result
     * @param  bool  $changeUpdatedAt
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function setResultDefaultValues($result, bool $changeUpdatedAt = true): void
    {
        if (!$changeUpdatedAt) {
            $result->timestamps = false;
            $result->saveQuietly(['touch'=>false]);
        } else {
            $result->saveQuietly();
        }
    }
}
