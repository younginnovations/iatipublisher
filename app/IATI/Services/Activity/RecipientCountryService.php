<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\RecipientCountryRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientCountryService.
 */
class RecipientCountryService
{
    /**
     * @var RecipientCountryRepository
     */
    protected RecipientCountryRepository $recipientCountryRepository;

    /**
     * RecipientCountryService constructor.
     *
     * @param RecipientCountryRepository $recipientCountryRepository
     */
    public function __construct(RecipientCountryRepository $recipientCountryRepository)
    {
        $this->recipientCountryRepository = $recipientCountryRepository;
    }

    /**
     * Returns recipient country data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getRecipientCountryData(int $activity_id): ?array
    {
        return $this->recipientCountryRepository->getRecipientCountryData($activity_id);
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
        return $this->recipientCountryRepository->getActivityData($id);
    }

    /**
     * Updates activity recipient country.
     *
     * @param $activityRecipientCountry
     * @param $activity
     *
     * @return bool
     */
    public function update($activityRecipientCountry, $activity): bool
    {
        return $this->recipientCountryRepository->update($activityRecipientCountry, $activity);
    }
}
