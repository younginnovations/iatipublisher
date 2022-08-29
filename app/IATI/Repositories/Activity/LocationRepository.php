<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LocationRepository.
 */
class LocationRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * LocationRepository Constructor.
     *
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns location data of an activity.
     *
     * @param $activityId
     *
     * @return array|null
     */
    public function getLocationData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->location;
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
     * Updates location.
     *
     * @param $location
     * @param $activity
     *
     * @return bool
     */
    public function update($location, $activity): bool
    {
        $element = getElementSchema('location');

        foreach ($location['location'] as $key => $location_value) {
            foreach (array_keys($element['sub_elements']) as $subelement) {
                $location['location'][$key][$subelement] = array_values($location_value[$subelement]);
            }
        }

        $activity->location = $location['location'];

        return $activity->save();
    }
}
