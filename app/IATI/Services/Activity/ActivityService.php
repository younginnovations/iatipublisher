<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

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
     *
     * @param ActivityRepository $activityRepository
     */
    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    /**
     * Returns all activities present in database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActivities()
    {
        return $this->activityRepository->getActivityForOrganization(Auth::user()->organization_id, 1);
    }

    /**
     * Returns all activities present in database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaginatedActivities($page = 0)
    {
        return $this->activityRepository->getActivityForOrganization(Auth::user()->organization_id, $page);
    }

    /**
     * Stores activity in activity table.
     *
     * @param $input
     * @param $organizationId
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($input): \Illuminate\Database\Eloquent\Model
    {
        $activity_identifier = [
            'activity_identifier' => $input['activity_identifier'],
            'iati_identifier_text' => $input['iati_identifier_text'],
        ];

        $activity_title = [
            [
                'narrative' => $input['narrative'],
                'language'  => $input['language'],
            ],
        ];

        return $this->activityRepository->store([
            'identifier'    => $activity_identifier,
            'title'         => $activity_title,
            'org_id'        => Auth::user()->organization_id,
        ]);
    }

    /**
     * Returns activity identifiers used by an organization.
     *
     * @param $organizationId
     *
     * @return Collection
     */
    public function getActivityIdentifiersForOrganization($organizationId): Collection
    {
        return $this->activityRepository->getActivityIdentifiersForOrganization($organizationId);
    }
}
