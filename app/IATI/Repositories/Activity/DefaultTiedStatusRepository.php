<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DefaultTiedStatusRepository.
 */
class DefaultTiedStatusRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * DefaultTiedStatusRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns default tied status data of an activity.
     * @param $activityId
     * @return int|null
     */
    public function getDefaultTiedStatusData($activityId): ?int
    {
        return $this->activity->findorFail($activityId)->default_tied_status;
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
     * Updates activity default tied status.
     * @param $activityDefaultTiedStatus
     * @param $activity
     * @return bool
     */
    public function update($activityDefaultTiedStatus, $activity): bool
    {
        $activity->default_tied_status = $activityDefaultTiedStatus;

        return $activity->save();
    }
}
