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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActivities(): Collection
    {
        return $this->activityRepository->getActivityForOrganization(Auth::user()->organization_id);
    }

    /**
     * Returns all activities present in database.
     *
     * @param int $page
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaginatedActivities(int $page = 1): Collection|\Illuminate\Pagination\LengthAwarePaginator
    {
        $activities = $this->activityRepository->getActivityForOrganization(Auth::user()->organization_id, $page);

        foreach ($activities as $activity) {
            $activity->setAttribute('coreCompleted', isCoreElementCompleted(array_merge(['reporting_org' => $activity->organization->reporting_org_complete_status], $activity->element_status)));
        }

        return $activities;
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
            'default_field_values' => $this->getDefaultValues(),
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
     * @param $id
     *
     * @return Activity
     */
    public function getActivity($id): Activity
    {
        return $this->activityRepository->find($id);
    }

    /**
     * Returns required service file.
     *
     * @param $serviceName
     *
     * @return \Illuminate\Contracts\Foundation\Application|mixed
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
     * @param $alreadyPublished
     * @param $linkedToIati
     *
     * @return bool
     */
    public function updatePublishedStatus($activity, $status, $alreadyPublished, $linkedToIati): bool
    {
        return $this->activityRepository->updatePublishedStatus($activity, $status, $alreadyPublished, $linkedToIati);
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
    public function resetActivityWorkflow($activity_id)
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
        $completed_core_element_count = $activity->organization->reporting_org_complete_status ? 1 : 0;

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

        if ($organizationSettings->default_values && $organizationSettings->activity_default_values) {
            return array_merge(
                $organizationSettings->default_values,
                $organizationSettings->activity_default_values
            );
        } elseif ($organizationSettings->default_values) {
            return $organizationSettings->default_values;
        } elseif ($organizationSettings->activity_default_values) {
            return $organizationSettings->activity_default_values;
        }

        return null;
    }
}
