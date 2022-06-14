<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TitleRepository.
 */
class TitleRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * TitleRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns title data of an activity.
     * @param $activityId
     * @return array
     */
    public function getTitleData($activityId): array
    {
        return $this->activity->findorFail($activityId)->title;
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
     * Updates activity title.
     * @param $activityTitle
     * @param $activityData
     * @return bool
     */
    public function update($activityTitle, $activity): bool
    {
        return $this->activity->update($activityTitle, $activity);
    }
}
