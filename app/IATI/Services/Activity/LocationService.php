<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\LocationRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LocationService.
 */
class LocationService
{
    /**
     * @var LocationRepository
     */
    protected LocationRepository $locationRepository;

    /**
     * LocationService constructor.
     *
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * Returns location of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getLocationData(int $activity_id): ?array
    {
        return $this->locationRepository->getLocationData($activity_id);
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
        return $this->locationRepository->getActivityData($id);
    }

    /**
     * Updates activity location.
     *
     * @param $location
     * @param $activity
     *
     * @return bool
     */
    public function update($location, $activity): bool
    {
        return $this->locationRepository->update($location, $activity);
    }
}
