<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

/**
 * Class ActivityService.
 */
class ActivityService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

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
     * @return Collection
     */
    public function getAllActivities(): Collection
    {
        return $this->activityRepository->getActivityForOrganization(Auth::user()->organization_id);
    }

    /**
     * Returns all activities present in database.
     *
     * @param int   $page
     * @param array $queryParams
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getPaginatedActivities(int $page, array $queryParams): Collection|LengthAwarePaginator
    {
        return $this->activityRepository->getActivityForOrganization(Auth::user()->organization_id, $queryParams, $page);
    }

    /**
     * Stores activity in activity table.
     *
     * @param $input
     *
     * @return Model
     */
    public function store($input): Model
    {
        $activity_identifier = [
            'activity_identifier'  => $input['activity_identifier'],
            'iati_identifier_text' => Auth::user()->organization->identifier . '-' . $input['activity_identifier'],
        ];

        $activity_title = [
            [
                'narrative' => $input['narrative'],
                'language'  => $input['language'],
            ],
        ];

        return $this->activityRepository->store([
            'iati_identifier' => $activity_identifier,
            'title'           => $activity_title,
            'org_id'          => Auth::user()->organization_id,
            'element_status'  => getDefaultElementStatus(),
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
     * Checks if specific activity exists.
     *
     * @param int $id
     *
     * @return bool
     */
    public function activityExists(int $id): bool
    {
        return $this->getActivity($id) !== null;
    }

    /**
     * Returns activity identifiers used by an organization.
     *
     * @param $id
     *
     * @return Activity|null
     */
    public function getActivity($id): ?Activity
    {
        return $this->activityRepository->find($id);
    }

    /**
     * Return activity publishing progress in percentage.
     *
     * @param $activity
     *
     * @return float|int
     */
    public function activityPublishingProgress($activity): float|int
    {
        $core_elements = getCoreElements();
        $completed_core_element_count = $activity->organization->reporting_org_complete_status ? 1 : 0;

        foreach ($core_elements as $core_element) {
            if (array_key_exists($core_element, $activity->element_status) && $activity->element_status[$core_element]) {
                $completed_core_element_count++;
            }
        }

        return ($completed_core_element_count / count($core_elements)) * 100;
    }
}
