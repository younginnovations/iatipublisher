<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Database\Eloquent\Collection;

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
    public function getAllActivities(): Collection
    {
        return $this->activityRepository->getAllActivities();
    }

    /**
     * Stores activity in activity table.
     * @param $input
     * @param $organizationId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($input, $organizationId) : \Illuminate\Database\Eloquent\Model
    {
        return $this->activityRepository->store($input, $organizationId);
    }

    /**
     * Returns activity identifiers used by an organization.
     * @param $organizationId
     * @return Collection
     */
    public function getActivityIdentifiersForOrganization($organizationId) : Collection
    {
        return $this->activityRepository->getActivityIdentifiersForOrganization($organizationId);
    }
}
