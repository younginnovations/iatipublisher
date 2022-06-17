<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientRegionRepository.
 */
class RecipientRegionRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * RecipientRegionRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns recipient region data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getRecipientRegionData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->recipient_region;
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
     * Updates activity recipient region.
     * @param $activityRecipientRegion
     * @param $activity
     * @return bool
     */
    public function update($activityRecipientRegion, $activity): bool
    {
        foreach ($activityRecipientRegion['recipient_region'] as $key => $recipient_region) {
            $activityRecipientRegion['recipient_region'][$key]['narrative'] = array_values($recipient_region['narrative']);
        }

        $activity->recipient_region = array_values($activityRecipientRegion['recipient_region']);

        return $activity->save();
    }
}
