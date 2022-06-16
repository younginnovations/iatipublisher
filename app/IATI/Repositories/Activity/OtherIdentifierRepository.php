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
     * @param $activityOtherIdentifier
     * @param $activity
     *
     * @return bool
     */
    public function update($activityOtherIdentifier, $activity): bool
    {
        // foreach ($activityOtherIdentifier['other-identifier'] as $key => $conditions) {
        //     $activityOtherIdentifier['condition'][$key]['narrative'] = array_values($conditions['narrative']);
        // }
        dd($activityOtherIdentifier);
        $activityOtherIdentifier['other_identifier'] = array_values($activityOtherIdentifier['other_identifier']);
        $activity->other_identifier = $activityOtherIdentifier;

        return $activity->save();
    }
}
