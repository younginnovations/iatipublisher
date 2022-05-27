<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DefaultFinanceTypeRepository.
 */
class DefaultFinanceTypeRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * DefaultFinanceTypeRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns default finance type data of an activity.
     * @param $activityId
     * @return int|null
     */
    public function getDefaultFinanceTypeData($activityId): ?int
    {
        return $this->activity->findorFail($activityId)->default_finance_type;
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
     * Updates activity default finance type.
     * @param $activityDefaultFinanceType
     * @param $activity
     * @return bool
     */
    public function update($activityDefaultFinanceType, $activity): bool
    {
        $activity->default_finance_type = $activityDefaultFinanceType;

        return $activity->save();
    }
}
