<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyMarkerRepository.
 */
class PolicyMarkerRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * PolicyMarkerRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns policy marker data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getPolicyMarkerData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->policy_marker;
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
     * Updates activity policy marker.
     * @param $activityPolicyMarker
     * @param $activity
     * @return bool
     */
    public function update($activityPolicyMarker, $activity): bool
    {
        foreach ($activityPolicyMarker['policy_marker'] as $key => $policy_marker) {
            $activityPolicyMarker['policy_marker'][$key]['narrative'] = array_values($policy_marker['narrative']);
        }

        $activity->policy_marker = array_values($activityPolicyMarker['policy_marker']);

        return $activity->save();
    }
}
