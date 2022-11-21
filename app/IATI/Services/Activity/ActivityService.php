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
     * @param int   $page
     * @param array $queryParams
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getPaginatedActivities(int $page, array $queryParams): Collection|LengthAwarePaginator
    {
        $activities = $this->activityRepository->getActivityForOrganization(Auth::user()->organization_id, $queryParams, $page);

        foreach ($activities as $idx => $activity) {
            $activities[$idx]['default_title_narrative'] = $activity->default_title_narrative;
            $activity->setAttribute('coreCompleted', isCoreElementCompleted(array_merge(['reporting_org' => $activity->organization->reporting_org_element_completed], $activity->element_status)));
        }

        return $activities;
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
            'activity_identifier' => $input['activity_identifier'],
        ];

        $activity_title = [
            [
                'narrative' => $input['narrative'],
                'language'  => $input['language'],
            ],
        ];

        return $this->activityRepository->store([
            'iati_identifier'      => $activity_identifier,
            'title'                => $activity_title,
            'org_id'               => Auth::user()->organization_id,
            'element_status'       => getDefaultElementStatus(),
            'default_field_values' => $this->getDefaultValues(),
            'reporting_org'        => Auth::user()->organization->reporting_org,
        ]);
    }

    /**
     * @param $id
     * @param $element
     *
     * @return bool
     */
    public function deleteElement($id, $element): bool
    {
        return $this->activityRepository->update($id, [$element => null]);
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
     * @param $id
     *
     * @return object|null
     */
    public function getActivity($id): ?object
    {
        return $this->activityRepository->find($id);
    }

    /**
     * Returns required service file.
     *
     * @param $serviceName
     *
     * @return mixed
     */
    public function getService($serviceName): mixed
    {
        return app(sprintf("App\IATI\Services\Activity\%s", $serviceName));
    }

    /**
     * Updates status column of activity row.
     *
     * @param $activity
     * @param $status
     * @param $linkedToIati
     *
     * @return bool
     */
    public function updatePublishedStatus($activity, $status, $linkedToIati): bool
    {
        return $this->activityRepository->updatePublishedStatus($activity, $status, $linkedToIati);
    }

    /**
     * Deletes desired activity.
     *
     * @param Activity $activity
     *
     * @return bool
     */
    public function deleteActivity(Activity $activity): bool
    {
        return $this->activityRepository->deleteActivity($activity);
    }

    /**
     * Sets activity status to draft.
     *
     * @param $activity_id
     *
     * @return void
     */
    public function resetActivityWorkflow($activity_id): void
    {
        $this->activityRepository->resetActivityWorkflow($activity_id);
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
        $completed_core_element_count = 0;

        foreach ($core_elements as $core_element) {
            if (array_key_exists($core_element, $activity->element_status) && $activity->element_status[$core_element]) {
                $completed_core_element_count++;
            }
        }

        return ($completed_core_element_count / count($core_elements)) * 100;
    }

    /**
     * Returns default values for activity.
     *
     * @return array|null
     */
    public function getDefaultValues(): ?array
    {
        $organizationSettings = Auth::user()->organization->settings;

        if (!empty($organizationSettings)) {
            if ($organizationSettings->default_values && $organizationSettings->activity_default_values) {
                return array_merge(
                    $organizationSettings->default_values,
                    $organizationSettings->activity_default_values
                );
            }

            if ($organizationSettings->default_values) {
                return $organizationSettings->default_values;
            }

            if ($organizationSettings->activity_default_values) {
                return $organizationSettings->activity_default_values;
            }
        }

        return null;
    }

    /**
     * Returns activities having given ids.
     *
     * @param $activityIds
     *
     * @return object
     */
    public function getActivitiesHavingIds($activityIds): object
    {
        return $this->activityRepository->getActivitiesHavingIds($activityIds);
    }
}
