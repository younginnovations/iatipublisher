<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Activity;
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
    public function getAllActivities(): Collection
    {
        return $this->activityRepository->getActivityForOrganization(Auth::user()->organization_id);
    }

    /**
     * Returns all activities present in database.
     *
     * @param $page
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaginatedActivities($page = 1): Collection | \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->activityRepository->getActivityForOrganization(Auth::user()->organization_id, $page);
    }

    /**
     * Stores activity in activity table.
     *
     * @param $input
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($input): \Illuminate\Database\Eloquent\Model
    {
        $activity_identifier = [
            'activity_identifier' => $input['activity_identifier'],
            'iati_identifier_text' => Auth::user()->organization->identifier . '-' . $input['activity_identifier'],
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

    /**
     * Returns activity identifiers used by an organization.
     *
     * @param $organizationId
     *
     * @return Activity
     */
    public function getActivity($id): Activity
    {
        return $this->activityRepository->find($id);
    }
}
