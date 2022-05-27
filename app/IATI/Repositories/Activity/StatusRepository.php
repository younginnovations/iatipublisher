<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StatusRepository.
 */
class StatusRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * StatusRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns status data of an activity.
     * @param $activityId
     * @return int|null
     */
    public function getStatusData($activityId): ?int
    {
        return $this->activity->findorFail($activityId)->activity_status;
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
     * Updates activity status.
     * @param $activityStatus
     * @param $activity
     * @return bool
     */
    public function update($activityStatus, $activity): bool
    {
        $activity->activity_status = $activityStatus;

        return $activity->save();
    }
}
