<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CollaborationTypeRepository.
 */
class CollaborationTypeRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * CollaborationTypeRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns collaboration type data of an activity.
     * @param $activityId
     * @return int|null
     */
    public function getCollaborationTypeData($activityId): ?int
    {
        return $this->activity->findorFail($activityId)->collaboration_type;
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
     * Updates activity collaboration type.
     * @param $activityCollaborationType
     * @param $activity
     * @return bool
     */
    public function update($activityCollaborationType, $activity): bool
    {
        $activity->collaboration_type = $activityCollaborationType;

        return $activity->save();
    }
}
