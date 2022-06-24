<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BudgetRepository.
 */
class BudgetRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * BudgetRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns budget data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getBudgetData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->budget;
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
     * Updates activity budget.
     * @param $activityBudget
     * @param $activity
     * @return bool
     */
    public function update($activityBudget, $activity): bool
    {
        $activity->budget = array_values($activityBudget['budget']);

        return $activity->save();
    }
}
