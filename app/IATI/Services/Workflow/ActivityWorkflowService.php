<?php

declare(strict_types=1);

namespace App\IATI\Services\Workflow;

use App\IATI\Services\Activity\ActivityPublishedService;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Publisher\PublisherService;
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
     * @var PublisherService
     */
    protected PublisherService $publisherService;

    /**
     * @var ActivityPublishedService
     */
    protected ActivityPublishedService $activityPublishedService;

    /**
     * ActivityWorkflowService Constructor.
     *
     * @param OrganizationService $organizationService
     * @param ActivityService $activityService
     * @param XmlGeneratorService $xmlGeneratorService
     * @param PublisherService $publisherService
     * @param ActivityPublishedService $activityPublishedService
     */
    public function __construct(
        OrganizationService $organizationService,
        ActivityService $activityService,
        XmlGeneratorService $xmlGeneratorService,
        PublisherService $publisherService,
        ActivityPublishedService $activityPublishedService
    ) {
        $this->organizationService = $organizationService;
        $this->activityService = $activityService;
        $this->xmlGeneratorService = $xmlGeneratorService;
        $this->publisherService = $publisherService;
        $this->activityPublishedService = $activityPublishedService;
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

//        $this->xmlGeneratorService->generateActivityXml($activity, $activity->transactions, $activity->results, $settings, $organization);
        $activityPublished = $this->activityPublishedService->getActivityPublished($organization->id);
        $this->publisherService->publishFile($settings->publishing_info, $activityPublished, $organization);
    }
}
