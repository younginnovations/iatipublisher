<?php

declare(strict_types=1);

namespace App\IATI\Services\Workflow;

use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Organization\OrganizationService;

/**
 * Class ActivityWorkflowService.
 */
class ActivityWorkflowService
{
    /**
     * @var OrganizationService
     */
    protected OrganizationService $organizationService;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * ActivityWorkflowService Constructor.
     *
     * @param OrganizationService $organizationService
     * @param ActivityService $activityService
     */
    public function __construct(OrganizationService $organizationService, ActivityService $activityService)
    {
        $this->organizationService = $organizationService;
        $this->activityService = $activityService;
    }

    /**
     * Returns desired activity.
     *
     * @param $activityId
     *
     * @return \App\IATI\Models\Activity\Activity
     */
    public function findActivity($activityId): \App\IATI\Models\Activity\Activity
    {
        return $this->activityService->getActivity($activityId);
    }

    /**
     * Publish an activity to the IATI registry.
     *
     * @param $activity
     *
     * @return array
     */
    public function publishActivity($activity)
    {
        $organization = $activity->organization;
        $settings = $organization->settings;
        $publishedActivities = $organization->publishedFiles;
    }
}
