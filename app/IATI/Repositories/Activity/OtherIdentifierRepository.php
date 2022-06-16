<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OtherIdentifierRepository.
 */
class OtherIdentifierRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * OtherIdentifierRepository Constructor.
     *
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns other identifier data of an activity.
     *
     * @param $activityId
     *
     * @return array|null
     */
    public function getOtherIdentifierData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->other_identifier;
    }

    /**
     * Returns activity object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getActivityData($id): Model
    {
        return $this->activity->findOrFail($id);
    }

    /**
     * Updates activity conditions.
     *
     * @param $activityIdentifier
     * @param $activity
     *
     * @return bool
     */
    public function update($activityIdentifier, $activity): bool
    {
        $activityIdentifier['owner_org'] = array_values($activityIdentifier['owner_org']);

        foreach ($activityIdentifier['owner_org'] as $owner_index => $owner_value) {
            foreach ($owner_value['narrative'] as $narrative_key => $narrative_value) {
                $activityIdentifier['owner_org'][$owner_index]['narrative'] = array_values($narrative_value);
            }
        }

        $activity->other_identifier = $activityIdentifier;

        return $activity->save();
    }
}
