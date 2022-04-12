<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\ActivityRepository;

/**
 * Class ActivityService.
 */
class ActivityService
{
    /**
     * @var ActivityRepository
     */
    protected $activityRepository;

    /**
     * ActivityService constructor.
     * @param ActivityRepository $activityRepository
     */
    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    /**
     * Returns all activities present in database.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActivities(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->activityRepository->getAllActivities();
    }
}
