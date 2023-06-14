<?php

declare(strict_types=1);

namespace App\IATI\Services\Workflow;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\ApiLog\ApiLogRepository;
use App\IATI\Services\Activity\ActivityPublishedService;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\ActivitySnapshotService;
use App\IATI\Services\Audit\AuditService;
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
     * @var AuditService
     */
    protected AuditService $auditService;

    /**
     * @var ApiLogRepository
     */
    protected ApiLogRepository $apiLogRepo;

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
     * @param AuditService $auditService
     * @param ApiLogRepository $apiLogRepo
     */
    public function __construct(
        OrganizationService $organizationService,
        ActivityService $activityService,
        XmlGeneratorService $xmlGeneratorService,
        PublisherService $publisherService,
        ActivityPublishedService $activityPublishedService,
        ActivitySnapshotService $activitySnapshotService,
        ActivityValidatorResponseService $validatorService,
        ApiLogRepository $apiLogRepo,
        AuditService $auditService
    ) {
        $this->organizationService = $organizationService;
        $this->activityService = $activityService;
        $this->xmlGeneratorService = $xmlGeneratorService;
        $this->publisherService = $publisherService;
        $this->activityPublishedService = $activityPublishedService;
        $this->activitySnapshotService = $activitySnapshotService;
        $this->validatorService = $validatorService;
        $this->apiLogRepo = $apiLogRepo;
        $this->auditService = $auditService;
    }

    /**
     * Returns desired activity.
     *
     * @param $activityId
     *
     * @return object
     */
    public function findActivity($activityId): object
    {
        return $this->activityService->getActivity($activityId);
    }

    /**
     * Publish an activity to the IATI registry.
     *
     * @param $activity
     * @param bool $publishFile
     *
     * @return void
     */
    public function publishActivity($activity, bool $publishFile = true): void
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

        $this->activityService->updatePublishedStatus($activity, 'published', true);
        $this->activitySnapshotService->createOrUpdateActivitySnapshot($activity);
    }

    /**
     * Unpublish activity and then republish required file to the IATI registry.
     *
     * @param $activity
     *
     * @return void
     */
    public function unpublishActivity($activity): void
    {
        $organization = $activity->organization;
        $settings = $organization->settings;
        $publishedFile = $this->activityPublishedService->getActivityPublished($activity->org_id);
        $this->removeActivityFromPublishedArray($publishedFile, $activity);
        $activityPublished = $this->activityPublishedService->getActivityPublished($organization->id);
        $this->xmlGeneratorService->generateNewXmlFile($activityPublished);
        $publishingInfo = $settings->publishing_info;
        $this->publisherService->publishFile($publishingInfo, $activityPublished, $organization);
        $this->activityService->updatePublishedStatus($activity, 'draft', false);
        $this->validatorService->deleteValidatorResponse($activity->id);
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
        $newPublishedFiles = Arr::except($containedActivities, $activity->id);
        $this->activityPublishedService->updateActivityPublished($publishedFile, $newPublishedFiles);
    }

    /**
     * Validates the activity on IATI validator and returns errors.
     *
     * @param $activity
     *
     * @return string
     * @throws GuzzleException
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
        awsUploadFile("xmlValidation/$activity->org_id/activity_$activity->id.xml", $xmlData);

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
        $params['query'] = ['group' => 'false', 'details' => 'true'];
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

        if (
            empty(Arr::get($registryInfo, 'publisher_id', null)) ||
            empty(Arr::get($registryInfo, 'api_token', null)) ||
            !Arr::get($registryInfo, 'publisher_verification', false) ||
            !Arr::get($registryInfo, 'token_verification', false)
        ) {
            return true;
        }

        return false;
    }

    /**
     * Returns if logged in user is verified or not.
     *
     * @return bool
     */
    public function isUserVerified(): bool
    {
        return !is_null(auth()->user()->email_verified_at);
    }

    /**
     * Returns errors related to publishing activity.
     *
     * @param $organization
     * @param string $type
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getPublishErrorMessage($organization, string $type = 'activity'): array
    {
        $messages = [];

        if (!$this->isUserVerified()) {
            $messages[] = trans('common.error.you_have_not_verified_your_email');
        }
        if ($this->hasNoPublisherInfo($organization->settings)) {
            $messages[] = trans('common.error.your_api_key_is_not_valid');
        }
        if ($type === 'activity' && !$this->isOrganizationPublished($organization)) {
            $messages[] = trans('common.error.organisation_data_is_not_published');
        }
        if (!$this->organizationService->isPublisherStateActive($organization['publisher_id'])) {
            $messages[] = trans('common.error.the_publisher_id_is_not_verified_in_iati_registry');
        }

        return $messages;
    }

    /**
     * Checks of organization is published or not.
     *
     * @param $organization
     *
     * @return bool
     */
    public function isOrganizationPublished($organization): bool
    {
        return $organization->is_published;
    }

    /**
     * Deletes the unpublished file.
     *
     * @param $activity
     *
     * @return void
     */
    public function deletePublishedFile($activity): void
    {
        $settings = $activity->organization->settings;
        $publishingInfo = $settings->publishing_info;
        $publisherId = Arr::get($publishingInfo, 'publisher_id', 'Not Available');
        $publishedActivity = sprintf('%s-%s.xml', $publisherId, $activity->id);
        $this->xmlGeneratorService->deleteUnpublishedFile($publishedActivity);
    }

    /**
     * Checks if sector is missing from activity and transaction level
     * if Missing it populates default value.
     *
     * @param $activity
     * @return object
     */
    public function populateSectorIfMissing($activity): object
    {
        $data = sectorDefaultValue();

        if ((empty($activity->sector) && !$this->activityService->checkIfTransactionHasSector($activity))
            || (is_variable_null($activity->sector))
        ) {
            $this->sectorService->update($activity->id, $data);
        }

        return $activity->refresh();
    }
}
