<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DefaultAidTypeRepository.
 */
class DefaultAidTypeRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * DefaultAidTypeRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns default aid type data of an activity.
     * @param $activityId
     * @return int|null
     */
    public function getDefaultAidTypeData($activityId): ?int
    {
        return $this->activity->findorFail($activityId)->default_aid_type;
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
     * Updates activity default aid type.
     * @param $activityDefaultAidType
     * @param $activity
     * @return bool
     */
    public function update($activityDefaultAidType, $activity): bool
    {
        $activity->default_aid_type = $activityDefaultAidType;

        return $activity->save();
    }
}
