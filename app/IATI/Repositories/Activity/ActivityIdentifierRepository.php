<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivityIdentifierRepository.
 */
class ActivityIdentifierRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * ActivityIdentifierRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns iati activity identifier data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getActivityIdentifierData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->identifier;
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
     * Updates activity identifier.
     * @param $activityIdentifier
     * @param $activity
     * @return bool
     */
    public function update($activityIdentifier, $activity): bool
    {
        $activity->identifier = $activityIdentifier;

        return $activity->save();
    }
}
