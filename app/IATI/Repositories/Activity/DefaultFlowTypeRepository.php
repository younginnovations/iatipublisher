<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DefaultFlowTypeRepository.
 */
class DefaultFlowTypeRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * DefaultFlowTypeRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns default flow type data of an activity.
     * @param $activityId
     * @return int|null
     */
    public function getDefaultFlowTypeData($activityId): ?int
    {
        return $this->activity->findorFail($activityId)->default_flow_type;
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
     * Updates activity default flow type.
     * @param $activityDefaultFlowType
     * @param $activity
     * @return bool
     */
    public function update($activityDefaultFlowType, $activity): bool
    {
        $activity->default_flow_type = $activityDefaultFlowType;

        return $activity->save();
    }
}
