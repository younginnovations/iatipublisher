<?php

declare(strict_types=1);

namespace App\IATI\Services\Workflow;

use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Xml\XmlGeneratorService;

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
     * @var XmlGeneratorService
     */
    protected XmlGeneratorService $xmlGeneratorService;

    /**
     * ActivityWorkflowService Constructor.
     *
     * @param OrganizationService $organizationService
     * @param ActivityService $activityService
     */
    public function __construct(OrganizationService $organizationService, ActivityService $activityService, XmlGeneratorService $xmlGeneratorService)
    {
        $this->organizationService = $organizationService;
        $this->activityService = $activityService;
        $this->xmlGeneratorService = $xmlGeneratorService;
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

        $this->xmlGeneratorService->generateActivityXml($activity, $activity->transactions, $activity->results, $settings, $organization);
    }
}
