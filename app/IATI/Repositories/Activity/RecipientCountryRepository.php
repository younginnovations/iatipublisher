<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientCountryRepository.
 */
class RecipientCountryRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * RecipientCountryRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns recipient country data of an activity.
     * @param $activityId
     * @return array|null
     */
    public function getRecipientCountryData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->recipient_country;
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
     * Updates activity recipient country.
     * @param $activityRecipientCountry
     * @param $activity
     * @return bool
     */
    public function update($activityRecipientCountry, $activity): bool
    {
        foreach ($activityRecipientCountry['recipient_country'] as $key => $recipient_country) {
            $activityRecipientCountry['recipient_country'][$key]['narrative'] = array_values($recipient_country['narrative']);
        }

        $activity->recipient_country = array_values($activityRecipientCountry['recipient_country']);

        return $activity->save();
    }
}
