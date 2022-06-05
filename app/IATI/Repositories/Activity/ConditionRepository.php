<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConditionRepository.
 */
class ConditionRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * ConditionRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns conditions data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getConditionData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->conditions;
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
     * Updates activity conditions.
     * @param $activityCondition
     * @param $activity
     * @return bool
     */
    public function update($activityCondition, $activity): bool
    {
        foreach ($activityCondition['condition'] as $key => $conditions) {
            $activityCondition['condition'][$key]['narrative'] = array_values($conditions['narrative']);
        }

        $activityCondition['condition'] = array_values($activityCondition['condition']);
        $activity->conditions = $activityCondition;

        return $activity->save();
    }
}
