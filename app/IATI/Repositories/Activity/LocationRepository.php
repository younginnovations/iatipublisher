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
        return $this->activity->findorFail($activityId)->contact_info;
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
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true)['location'];

        foreach (array_keys($element['sub_elements']) as $subelement) {
            $location[$subelement] = array_values($location[$subelement]);
        }

        $activity->contact_info = $location;

        return $activity->save();
    }
}
