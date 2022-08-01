<?php

namespace App\Observers;

use App\IATI\Models\Activity\Activity;

class ActivityObserver
{
    /**
     * @param mixed $updatedAttributes
     *
     * @return mixed
     */
    public function unsetAttributes(mixed $updatedAttributes): mixed
    {
        if (array_key_exists('created_at', $updatedAttributes)) {
            unset($updatedAttributes['created_at']);
        }

        if (array_key_exists('updated_at', $updatedAttributes)) {
            unset($updatedAttributes['updated_at']);
        }

        return $updatedAttributes;
    }

    /**
     * @param mixed $updatedAttributes
     * @param       $model
     * @param mixed $elementStatus
     *
     * @return void
     */
    public function setElementStatus(mixed $updatedAttributes, $model, mixed $elementStatus): void
    {
        foreach ($updatedAttributes as $attribute => $value) {
            $fx = $attribute . '_element_completed';
            $elementStatus[$attribute] = $model[$fx];
        }

        $model->element_status = $elementStatus;
    }

    /**
     * @param mixed $updatedAttributes
     * @param       $model
     *
     * @return void
     */
    public function setStatus(mixed $updatedAttributes, $model): void
    {
        if (!empty(array_intersect_key($updatedAttributes, getCoreElements()))) {
            if ($model->status === 'draft' || $model->status === 'published') {
                $model->status = (coreElementCompleted($model->element_status)) ? 'ready_to_publish' : $model->status;
            } elseif ($model->status === 'ready_to_publish') {
                $model->status = !(coreElementCompleted($model->element_status)) ? 'draft' : $model->status;
            }
        }
    }

    /**
     * Handle the Activity "updated" event.
     *
     * @param Activity $activity
     *
     * @return void
     */
    public function updated(Activity $activity): void
    {
        $elementStatus = $activity->element_status;
        $updatedAttributes = $this->unsetAttributes($activity->getChanges());

        $this->setElementStatus($updatedAttributes, $activity, $elementStatus);
        $this->setStatus($updatedAttributes, $activity);
        $activity->saveQuietly();
    }
}
