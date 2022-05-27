<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ScopeRepository.
 */
class ScopeRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * ScopeRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns scope data of an activity.
     * @param $activityId
     * @return int|null
     */
    public function getScopeData($activityId): ?int
    {
        return $this->activity->findorFail($activityId)->activity_scope;
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
     * Updates activity scope.
     * @param $activityScope
     * @param $activity
     * @return bool
     */
    public function update($activityScope, $activity): bool
    {
        $activity->activity_scope = $activityScope;

        return $activity->save();
    }
}
