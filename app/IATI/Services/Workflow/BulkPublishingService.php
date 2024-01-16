<?php

declare(strict_types=1);

namespace App\IATI\Services\Workflow;

use App\IATI\Repositories\ApiLog\ApiLogRepository;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\BulkPublishingStatusService;
use App\IATI\Services\Validator\ActivityValidatorResponseService;
use App\IATI\Traits\IatiValidatorResponseTrait;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class BulkPublishingService.
 */
class BulkPublishingService
{
    use IatiValidatorResponseTrait;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * @var ActivityWorkflowService
     */
    protected ActivityWorkflowService $activityWorkflowService;

    /**
     * @var ActivityValidatorResponseService
     */
    protected ActivityValidatorResponseService $validatorService;

    /**
     * @var BulkPublishingStatusService
     */
    protected BulkPublishingStatusService $publishingStatusService;

    /**
     * @var ApiLogRepository
     */
    protected ApiLogRepository $apiLogRepo;

    /**
     * BulkPublishingService Constructor.
     *
     * @param ActivityService $activityService
     * @param ActivityWorkflowService $activityWorkflowService
     * @param ActivityValidatorResponseService $validatorService
     * @param BulkPublishingStatusService $publishingStatusService
     * @param ApiLogRepository $apiLogRepo
     */
    public function __construct(
        ActivityService $activityService,
        ActivityWorkflowService $activityWorkflowService,
        ActivityValidatorResponseService $validatorService,
        BulkPublishingStatusService $publishingStatusService,
        ApiLogRepository $apiLogRepo
    ) {
        $this->activityService = $activityService;
        $this->activityWorkflowService = $activityWorkflowService;
        $this->validatorService = $validatorService;
        $this->publishingStatusService = $publishingStatusService;
        $this->apiLogRepo = $apiLogRepo;
    }

    /**
     * Returns array with information of activities which have completed core elements and which have not.
     *
     * @param $activityIds
     *
     * @return array
     */
    public function getCoreElementsCompletedArray($activityIds): array
    {
        $coreElementsCompleted = [];
        $coreElementsCompleted['complete'] = [];
        $coreElementsCompleted['incomplete'] = [];

        if (count($activityIds)) {
            foreach ($activityIds as $id) {
                $activity = $this->activityService->getActivity($id);

                if ($activity && $activity->status === 'draft') {
                    $coreElementsCompleted[$this->getCompleteStatus($activity)][] = [
                        'activity_id' => $activity->id,
                        'title' => Arr::get($activity->title, '0.narrative', translateCommon('missing.not_available')) ?: translateCommon('missing.not_available'),
                    ];
                }
            }
        }

        return $coreElementsCompleted;
    }

    /**
     * Returns whether activity is completed or not.
     *
     * @param $activity
     *
     * @return string
     */
    public function getCompleteStatus($activity): string
    {
        if (isCoreElementCompleted(array_merge(['reporting_org' => $activity->organization->reporting_org_element_completed], $activity->element_status))) {
            return 'complete';
        }

        return 'incomplete';
    }

    /**
     * Validates activities on IATI publisher and returns required response.
     *
     * @param $activityIds
     *
     * @return array
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function validateActivitiesOnIATI($activityIds): array
    {
        $totalResponse = [];

        foreach ($activityIds as $activityId) {
            $activity = $this->activityService->getActivity($activityId);

            if ($activity && $activity->status === 'draft') {
                $response = $this->validateWithException($activity);
                $this->apiLogRepo->store(generateApiInfo('POST', env('IATI_VALIDATOR_ENDPOINT'), ['form_params' => json_encode($activity)], json_encode($response)));

                if (!Arr::get($response, 'success', true)) {
                    logger()->error(translateErrorHasOccurred('responses.activity_with_id', 'validating'));
                } else {
                    $totalResponse[$activity->id] = [
                        'activity_id' => $activity->id,
                        'title' => Arr::get($activity->title, '0.narrative', translateCommon('missing.not_available')) ?: translateCommon('missing.not_available'),
                        'response' => $response,
                    ];
                }
            }
        }

        return $this->modifyResponse($totalResponse);
    }

    /**
     * Validates activity on IATI publisher and handles exception.
     *
     * @param $activity
     *
     * @return array
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function validateWithException($activity): array
    {
        try {
            $validatorResponse = $this->activityWorkflowService->validateActivityOnIATIValidator($activity);
            $response = $this->addElementOnIatiValidatorResponse($validatorResponse, $activity);

            if ($this->validatorService->updateOrCreateResponse($activity->id, $response)) {
                return $response;
            }

            return ['success' => false, 'error' =>  translateErrorHasOccurred('elements_common.activity', 'validating')];
        } catch (BadResponseException $ex) {
            if ($ex->getCode() === 422) {
                $validatorResponse = $ex->getResponse()->getBody()->getContents();
                $response = $this->addElementOnIatiValidatorResponse($validatorResponse, $activity);

                if ($this->validatorService->updateOrCreateResponse($activity->id, $response)) {
                    return $response;
                }
            }

            return ['success' => false, 'error' =>  translateErrorHasOccurred('elements_common.activity', 'validating')];
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            throw new \RuntimeException();
        }
    }

    /**
     * Modifies response obtained from IATI publisher to send to frontend.
     *
     * @param $totalResponse
     *
     * @return array
     */
    public function modifyResponse($totalResponse): array
    {
        $modifiedResponse = [
            'no_errors' => [],
            'errors' => [],
            'critical' => [],
        ];

        foreach ($totalResponse as $response) {
            $modifiedResponse = $this->checkActivityError($response, $modifiedResponse);
        }

        return $modifiedResponse;
    }

    /**
     * Checks errors in activity and returns modified array.
     *
     * @param $response
     * @param $modifiedResponse
     *
     * @return array
     */
    public function checkActivityError($response, $modifiedResponse): array
    {
        $summary = Arr::get($response, 'response.summary', []);

        if (array_sum($summary) === 0) {
            $modifiedResponse['no_errors'][] = [
                'activity_id' => Arr::get($response, 'activity_id', translateCommon('missing.not_available')),
                'title' => Arr::get($response, 'title', translateCommon('missing.not_available')),
                'errors' => [],
            ];
        }

        if (Arr::get($summary, 'critical', 0) > 0) {
            $modifiedResponse['critical'][] = [
                'activity_id' => Arr::get($response, 'activity_id', translateCommon('missing.not_available')),
                'title' => Arr::get($response, 'title', translateCommon('missing.not_available')),
                'errors' => [
                    'critical' => Arr::get($summary, 'critical', 0),
                ],
            ];
        }

        if ((Arr::get($summary, 'error', 0) > 0) || (Arr::get($summary, 'warning', 0) > 0)) {
            $modifiedResponse['errors'][] = [
                'activity_id' => Arr::get($response, 'activity_id', translateCommon('missing.not_available')),
                'title' => Arr::get($response, 'title', translateCommon('missing.not_available')),
                'errors' => [
                    'error' => Arr::get($summary, 'error', 0),
                    'warning' => Arr::get($summary, 'warning', 0),
                ],
            ];
        }

        return $modifiedResponse;
    }

    /**
     * Returns initial response after starting bulk publishing of activities.
     *
     * @param $activities
     *
     * @return array
     */
    public function generateInitialBulkPublishingResponse($activities): array
    {
        $response = [];
        $response['status'] = 'processing';
        $response['organization_id'] = auth()->user()->organization->id;
        $response['job_batch_uuid'] = (string) Str::uuid();
        $response['message'] = trans('responses.bulk_publishing', ['suffix'=>trans('responses.started')]);
        $response['activities'] = [];

        if (count($activities)) {
            foreach ($activities as $activity) {
                $response['activities'][$activity->id]['activity_id'] = $activity->id;
                $response['activities'][$activity->id]['activity_title'] = Arr::get($activity->title, '0.narrative', translateCommon('missing.not_available')) ?: translateCommon('missing.not_available');
                $response['activities'][$activity->id]['status'] = 'created';
            }
        }

        return $response;
    }

    /**
     * Get response during bulk publishing of activities.
     *
     * @param $publishStatus
     *
     * @return array
     */
    public function getPublishingResponse($publishStatus): array
    {
        $processing = false;

        $response = [];
        $response['status'] = 'completed';
        $response['organization_id'] = $publishStatus->first()->organization_id;
        $response['job_batch_uuid'] = $publishStatus->first()->job_batch_uuid;
        $response['message'] = trans('responses.bulk_publishing', ['suffix'=>trans('responses.completed')]);
        $response['activities'] = [];

        if (count($publishStatus)) {
            foreach ($publishStatus as $status) {
                if ($status->status === 'created' || $status->status === 'processing') {
                    $processing = true;
                }

                $response['activities'][$status->activity_id]['activity_id'] = $status->activity_id;
                $response['activities'][$status->activity_id]['activity_title'] = $status->activity_title;
                $response['activities'][$status->activity_id]['status'] = $status->status;
            }
        }

        if ($processing) {
            $response['status'] = 'processing';
            $response['message'] = trans('responses.bulk_publishing', ['suffix'=>trans('responses.processing')]);
        }

        return $response;
    }

    /**
     * Stop bulk publishing.
     *
     * @param $organizationId
     *
     * @return array
     */
    public function stopBulkPublishing($organizationId): array
    {
        return $this->publishingStatusService->stopBulkPublishing($organizationId);
    }

    /**
     * Get status of bulk publishing for users belonging to same org.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getOrganisationBulkPublishingStatus(): array
    {
        $organizationId = auth()->user()->organization->id;

        $publishStatus = $this->publishingStatusService->getActivityPublishingStatus($organizationId);

        if ($publishStatus && count($publishStatus)) {
            $response = $this->getPublishingResponse($publishStatus);

            return ['inProgress' => true, 'publishingData' => $response];
        }

        return ['inProgress' => false, 'publishingData' => []];
    }

    /**
     * Returns status of activity publish based on activity table.
     *
     * @param $activityId
     * @param $uuid
     *
     * @return bool|int|string
     */
    public function checkActivityStatusTest($activityId, $uuid): bool|int|string
    {
        $activity = $this->activityService->getActivity($activityId);
        $returnMsg = false;

        if ($activity->status != 'published') {
            if ($this->publishingStatusService->updateActivityStatus($activityId, $uuid, 'failed')) {
                $returnMsg = 'failed';
            }
        }

        return $returnMsg;
    }

    /**
     * Delete bulk publishing status having organizationId.
     *
     * @param $organizationId
     *
     * @return bool
     */
    public function deleteBulkPublishingStatus($organizationId): bool
    {
        return $this->publishingStatusService->deleteBulkPublishingStatus($organizationId);
    }
}
