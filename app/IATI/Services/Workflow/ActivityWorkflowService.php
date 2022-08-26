<?php

declare(strict_types=1);

namespace App\IATI\Services\Workflow;

use App\IATI\Models\Activity\Activity;
use App\IATI\Services\Activity\ActivityPublishedService;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\ActivitySnapshotService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Publisher\PublisherService;
use App\IATI\Services\Validator\ActivityValidatorResponseService;
use App\IATI\Services\Xml\XmlGeneratorService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;

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
     * @var ActivitySnapshotService
     */
    protected ActivitySnapshotService $activitySnapshotService;

    /**
     * @var ActivityValidatorResponseService
     */
    protected ActivityValidatorResponseService $validatorService;

    /**
     * ActivityWorkflowService Constructor.
     *
     * @param OrganizationService $organizationService
     * @param ActivityService $activityService
     * @param XmlGeneratorService $xmlGeneratorService
     * @param PublisherService $publisherService
     * @param ActivityPublishedService $activityPublishedService
     * @param ActivitySnapshotService $activitySnapshotService
     * @param ActivityValidatorResponseService $validatorService
     */
    public function __construct(
        OrganizationService $organizationService,
        ActivityService $activityService,
        XmlGeneratorService $xmlGeneratorService,
        PublisherService $publisherService,
        ActivityPublishedService $activityPublishedService,
        ActivitySnapshotService $activitySnapshotService,
        ActivityValidatorResponseService $validatorService
    ) {
        $this->organizationService = $organizationService;
        $this->activityService = $activityService;
        $this->xmlGeneratorService = $xmlGeneratorService;
        $this->publisherService = $publisherService;
        $this->activityPublishedService = $activityPublishedService;
        $this->activitySnapshotService = $activitySnapshotService;
        $this->validatorService = $validatorService;
    }

    /**
     * Returns desired activity.
     *
     * @param $activityId
     *
     * @return Activity
     */
    public function findActivity($activityId): Activity
    {
        return $this->activityService->getActivity($activityId);
    }

    /**
     * Publish an activity to the IATI registry.
     *
     * @param $activity
     * @param $publishFile
     *
     * @return void
     */
    public function publishActivity($activity, $publishFile = true): void
    {
        $organization = $activity->organization;
        $settings = $organization->settings;
        $this->xmlGeneratorService->generateActivityXml(
            $activity,
            $activity->transactions,
            $activity->results,
            $settings,
            $organization
        );

        if ($publishFile) {
            $activityPublished = $this->activityPublishedService->getActivityPublished($organization->id);
            $publishingInfo = $settings->publishing_info;
            $this->publisherService->publishFile($publishingInfo, $activityPublished, $organization);
        }

        $this->activityService->updatePublishedStatus($activity, 'published', true, true);
        $this->activitySnapshotService->createOrUpdateActivitySnapshot($activity);
    }

    /**
     * Unpublish activity from the IATI registry.
     *
     * @param $activity
     *
     * @return void
     */
    public function unpublishActivity($activity): void
    {
        $publishedFile = $this->activityPublishedService->getActivityPublished($activity->org_id);
        $this->removeActivityFromPublishedArray($publishedFile, $activity);
        $this->activityService->updatePublishedStatus($activity, 'draft', true, false);
        $this->validatorService->deleteValidatorResponse($activity->id);
        $this->xmlGeneratorService->generateNewXmlFile($publishedFile);
    }

    /**
     * Removes activity file name from activity published row.
     *
     * @param $publishedFile
     * @param $activity
     *
     * @return void
     */
    public function removeActivityFromPublishedArray($publishedFile, $activity): void
    {
        $containedActivities = $publishedFile->extractActivities();
        $unpublishedFile = Arr::get($containedActivities, $activity->id);
        $this->xmlGeneratorService->deleteUnpublishedFile($unpublishedFile);
        $newPublishedFiles = Arr::except($containedActivities, $activity->id);
        $this->activityPublishedService->updateActivityPublished($publishedFile, $newPublishedFiles);
    }

    /**
     * Validates the activity on IATI validator and returns errors.
     *
     * @param $activity
     *
     * @return string
     */
    public function validateActivityOnIATIValidator($activity): string
    {
        $organization = $activity->organization;
        $settings = $organization->settings;

        $xmlData = $this->xmlGeneratorService->getActivityXmlData(
            $activity,
            $activity->transactions,
            $activity->results,
            $settings,
            $organization
        );

        return $this->getResponse($xmlData);
    }

    /**
     * Returns response of validation activity on IATI validator.
     *
     * @param $xmlData
     *
     * @return string
     *
     * @throws BadResponseException
     * @throws GuzzleException
     */
    public function getResponse($xmlData): string
    {
        $client = new Client();
        $URI = env('IATI_VALIDATOR_ENDPOINT');
        $params['headers'] = ['Content-Type' => 'application/json', 'Ocp-Apim-Subscription-Key' => env('IATI_VALIDATOR_KEY')];
        $params['query'] = ['group' => 'false'];
        $params['body'] = $xmlData;
        $response = $client->post($URI, $params);

        return $response->getBody()->getContents();
    }

    /**
     * Check if the Organization's publisher_id and api_token has been filled out and are correct.
     *
     * @param $settings
     *
     * @return bool
     */
    public function hasNoPublisherInfo($settings): bool
    {
        if (!$settings) {
            return true;
        }

        $registryInfo = $settings->publishing_info;

        if (!$registryInfo) {
            return true;
        }

        if (empty(Arr::get($registryInfo, 'publisher_id', null)) ||
            empty(Arr::get($registryInfo, 'api_token', null)) ||
            !Arr::get($registryInfo, 'publisher_verification', false) ||
            !Arr::get($registryInfo, 'token_verification', false)
        ) {
            return true;
        }

        return false;
    }
}
