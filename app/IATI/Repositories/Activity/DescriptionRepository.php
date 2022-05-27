<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DescriptionRepository.
 */
class DescriptionRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * DescriptionRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns description data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getDescriptionData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->description;
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
     * Updates activity description.
     * @param $activityDescription
     * @param $activity
     * @return bool
     */
    public function update($activityDescription, $activity): bool
    {
        $activity->description = $activityDescription['description'];

        return $activity->save();
    }
}
