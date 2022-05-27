<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CapitalSpendRepository.
 */
class CapitalSpendRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * CapitalSpendRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns capital spend data of an activity.
     * @param $activityId
     * @return float|null
     */
    public function getCapitalSpendData($activityId): ?float
    {
        return $this->activity->findorFail($activityId)->capital_spend;
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
     * Updates activity capital spend.
     * @param $activityCapitalSpend
     * @param $activity
     * @return bool
     */
    public function update($activityCapitalSpend, $activity): bool
    {
        $activity->capital_spend = $activityCapitalSpend;

        return $activity->save();
    }
}
