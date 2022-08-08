<?php

declare(strict_types=1);

namespace App\Observers;

use App\IATI\Models\Activity\Activity;
use App\IATI\Services\ElementCompleteService;

/**
 * Class ActivityObserver.
 */
class ActivityObserver
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
     * @param $updatedAttributes
     *
     * @return array
     * @throws \JsonException
     */
    public function getUpdatedElement($updatedAttributes): array
    {
        $elements = getElements();
        $updatedElements = [];

        foreach ($updatedAttributes as $element => $updatedAttribute) {
            if (in_array($element, $elements, true)) {
                $updatedElements[$element] = $updatedAttribute;
            }
        }

        return $updatedElements;
    }

    /**
     * Sets the complete status of elements.
     *
     * @param      $model
     * @param bool $isNew
     *
     * @return void
     * @throws \JsonException
     */
    public function setElementStatus($model, bool $isNew = false): void
    {
        $elementStatus = $model->element_status;
        $updatedElements = ($isNew) ? $this->getUpdatedElement($model->getAttributes()) : $this->getUpdatedElement($model->getChanges());

        foreach ($updatedElements as $attribute => $value) {
            $elementStatus[$attribute] = call_user_func([$this->elementCompleteService, dashesToCamelCase('is_' . $attribute . '_element_completed')], $model);
        }

        $model->element_status = $elementStatus;
    }

    /**
     * Handle the Activity "created" event.
     *
     * @param Activity $activity
     *
     * @return void
     * @throws \JsonException
     */
    public function created(Activity $activity): void
    {
        $this->setElementStatus($activity, true);
        $activity->saveQuietly();
    }

    /**
     * Handle the Activity "updated" event.
     *
     * @param Activity $activity
     *
     * @return void
     * @throws \JsonException
     */
    public function updated(Activity $activity): void
    {
        $this->setElementStatus($activity);
        $activity->saveQuietly();
    }
}
