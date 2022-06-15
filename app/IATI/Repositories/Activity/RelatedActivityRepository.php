<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RelatedActivityRepository.
 */
class RelatedActivityRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * RelatedActivityRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns related activity data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getRelatedActivityData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->related_activity;
    }

    /**
     * Returns activity object.
     * @param $id
     * @return Model
     */
    public function getActivityData($id): Model
    {
        return $this->activity->findOrFail($id);
    }

    /**
     * Updates activity related activity.
     * @param $activityRelatedActivity
     * @param $activity
     * @return bool
     */
    public function update($activityRelatedActivity, $activity): bool
    {
        $activity->related_activity = array_values($activityRelatedActivity['related_activity']);

        return $activity->save();
    }
}
