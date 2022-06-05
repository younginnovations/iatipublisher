<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LegacyDataRepository.
 */
class LegacyDataRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * LegacyDataRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns legacy data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getActivityLegacyData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->legacy_data;
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
     * Updates activity legacy.
     * @param $activityLegacy
     * @param $activity
     * @return bool
     */
    public function update($activityLegacy, $activity): bool
    {
        $activity->legacy_data = array_values($activityLegacy['legacy_data']);

        return $activity->save();
    }
}
