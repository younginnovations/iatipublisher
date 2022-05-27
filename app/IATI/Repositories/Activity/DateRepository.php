<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DateRepository.
 */
class DateRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * DateRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns date data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getDateData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->activity_date;
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
     * Updates activity activity_date.
     * @param $activityDate
     * @param $activity
     * @return bool
     */
    public function update($activityDate, $activity): bool
    {
        $activity->activity_date = $activityDate['activity_date'];

        return $activity->save();
    }
}
