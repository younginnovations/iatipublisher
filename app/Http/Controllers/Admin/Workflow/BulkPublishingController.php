<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Workflow;

use App\Http\Controllers\Controller;
use App\IATI\Services\Activity\ActivityPublishedService;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\BulkPublishingStatusService;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use App\IATI\Services\Workflow\BulkPublishingService;
use App\Jobs\BulkPublishActivities;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class BulkPublishingController.
 */
class BulkPublishingController extends Controller
{
    /**
     * @var BulkPublishingService
     */
    protected BulkPublishingService $bulkPublishingService;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * @var ActivityWorkflowService
     */
    protected ActivityWorkflowService $activityWorkflowService;

    protected ActivityPublishedService $activityPublishedService;

    /**
     * @var BulkPublishingStatusService
     */
    protected BulkPublishingStatusService $publishingStatusService;

    /**
     * BulkPublishingController Constructor.
     *
     * @param BulkPublishingService $bulkPublishingService
     * @param ActivityService $activityService
     * @param ActivityWorkflowService $activityWorkflowService
     * @param BulkPublishingStatusService $publishingStatusService
     */
    public function __construct(
        BulkPublishingService $bulkPublishingService,
        ActivityService $activityService,
        ActivityWorkflowService $activityWorkflowService,
        BulkPublishingStatusService $publishingStatusService,
        ActivityPublishedService $activityPublishedService,
    ) {
        $this->bulkPublishingService = $bulkPublishingService;
        $this->activityService = $activityService;
        $this->activityWorkflowService = $activityWorkflowService;
        $this->publishingStatusService = $publishingStatusService;
        $this->activityPublishedService = $activityPublishedService;
    }

    /**
     * Checks if core elements are completed or not.
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function checkCoreElementsCompleted(Request $request): JsonResponse
    {
        try {
            $message = $this->activityWorkflowService->getPublishErrorMessage(auth()->user()->organization);

            if (!empty($message)) {
                Session::put('error', $message);

                return response()->json(['success' => false, 'message' => $message]);
            }

            if ($this->publishingStatusService->ongoingBulkPublishing(auth()->user()->organization->id)) {
                $pubishingStatus = $this->bulkPublishingService->getOrganisationBulkPublishingStatus();

                return response()->json([
                    'success' => false,
                    'message' => 'Another bulk publishing is already in progress.',
                    'data' => $pubishingStatus['publishingData'],
                    'in_progress' => $pubishingStatus['inProgress'],
                ]);
            }

            $activityIds = json_decode($request->get('activities'), true, 512, JSON_THROW_ON_ERROR);

            if (!empty($activityIds)) {
                return response()->json(['success' => true, 'message' => 'Retrieved data successfully.', 'data' => $this->bulkPublishingService->getCoreElementsCompletedArray($activityIds)]);
            }

            return response()->json(['success' => false, 'message' => 'No activities selected.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while checking core elements completed.']);
        }
    }

    /**
     * Validates activities on IATI validator.
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function validateActivities(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $message = $this->activityWorkflowService->getPublishErrorMessage(auth()->user()->organization);

            if (!empty($message)) {
                Session::put('error', $message);

                return response()->json(['success' => false, 'message' => $message]);
            }

            $activityIds = json_decode($request->get('activities'), true, 512, JSON_THROW_ON_ERROR);

            if (!empty($activityIds)) {
                $validationResponse = $this->bulkPublishingService->validateActivitiesOnIATI($activityIds);
                DB::commit();

                if (!Arr::get($validationResponse, 'success', true)) {
                    return response()->json(['success' => false, 'message' => 'Activities validation failed.']);
                }

                return response()->json(['success' => true, 'message' => 'Activities validated successfully.', 'data' => $validationResponse]);
            }

            return response()->json(['success' => false, 'message' => 'No activities selected.']);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while validating activities.']);
        }
    }

    /**
     * Starts bulk publishing job and sends initial response.
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function startBulkPublish(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $message = $this->activityWorkflowService->getPublishErrorMessage(auth()->user()->organization);

            if (!empty($message)) {
                Session::put('error', $message);

                return response()->json(['success' => false, 'message' => $message]);
            }

            if ($this->publishingStatusService->ongoingBulkPublishing(auth()->user()->organization->id)) {
                $pubishingStatus = $this->bulkPublishingService->getOrganisationBulkPublishingStatus();

                return response()->json([
                    'success' => false,
                    'message' => 'Another bulk publishing is already in progress.',
                    'data' => $pubishingStatus['publishingData'],
                    'in_progress' => $pubishingStatus['inProgress'],
                ]);
            }

            $activityIds = json_decode($request->get('activities'), false, 512, JSON_THROW_ON_ERROR);

            if (!empty($activityIds)) {
                $activities = $this->activityService->getActivitiesHavingIds($activityIds);

                if (!count($activities)) {
                    return response()->json(['success' => false, 'message' => 'No activities selected.']);
                }

                $response = $this->bulkPublishingService->generateInitialBulkPublishingResponse($activities);
                $this->publishingStatusService->storeProcessingActivities($activities, $response['organization_id'], $response['job_batch_uuid']);
                dispatch(new BulkPublishActivities($activities, $response['organization_id'], $response['job_batch_uuid']));
                DB::commit();

                return response()->json(['success' => true, 'message' => 'Bulk publishing started', 'data' => $response]);
            }

            return response()->json(['success' => false, 'message' => 'No activities selected.']);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Bulk publishing failed.']);
        }
    }

    /**
     * Get status of bulk publishing.
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function getBulkPublishStatus(): JsonResponse
    {
        try {
            $organizationId = Auth::user()->organization_id;
            $uuid = $this->publishingStatusService->getPublishingUuid($organizationId);

            if ($uuid) {
                $publishStatus = $this->publishingStatusService->getActivityPublishingStatus($organizationId, $uuid);

                if ($publishStatus && count($publishStatus)) {
                    $response = $this->bulkPublishingService->getPublishingResponse($publishStatus);

                    return response()->json(['success' => true, 'message' => $response['message'], 'data' => $response, 'publishing' => true]);
                }
            }

            return response()->json(['success' => false, 'message' => 'No bulk publishing in progress', 'publishing' => false]);
        } catch (\Exception $e) {
            logger()->error($e);

            return response()->json(['success' => false, 'message' => 'Status generation failed.']);
        } catch (NotFoundExceptionInterface | ContainerExceptionInterface $e) {
            logger()->error($e);

            return response()->json(['success' => false, 'message' => 'Request error']);
        }
    }

    /**
     * Cancels Bulk Publishing.
     *
     * @return JsonResponse
     */
    public function cancelBulkPublishing(): JsonResponse
    {
        try {
            DB::beginTransaction();
            $deletedIds = $this->bulkPublishingService->stopBulkPublishing(auth()->user()->organization->id);
            $numberOfDeletedRows = count($deletedIds);

            if ($deletedIds) {
                DB::commit();

                return response()->json(
                    [
                        'success' => true,
                        'message' => "Bulk publish of {$numberOfDeletedRows} activities canceled.",
                        'data' => $deletedIds,
                    ]
                );
            }

            return response()->json(['success' => true, 'message' => 'No bulk publish were cancelled.']);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to stop bulk publishing']);
        }
    }

    /**
     * Performs required checks for publishing activity.
     *
     * @return JsonResponse
     */
    public function checksForActivityBulkPublish(): JsonResponse
    {
        try {
            $message = $this->activityWorkflowService->getPublishErrorMessage(auth()->user()->organization);

            if (!empty($message)) {
                return response()->json(['success' => false, 'message' => $message]);
            }

            if ($this->publishingStatusService->ongoingBulkPublishing(auth()->user()->organization->id)) {
                $pubishingStatus = $this->bulkPublishingService->getOrganisationBulkPublishingStatus();

                return response()->json([
                    'success' => false,
                    'message' => 'Another bulk publishing is already in progress.',
                    'data' => $pubishingStatus['publishingData'],
                    'in_progress' => $pubishingStatus['inProgress'],
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Activity is ready to be published.', 'status' => 'completed']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while checking activity.']);
        }
    }

    /**
     * Checks if activity with publishing in bulk publish status is published or draft in activities table
     * Updates it and returns msg.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function clearBulkPublishStatus(): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->publishingStatusService->deleteBulkPublishingStatus(Auth::user()->organization->id);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Bulk publishing status successfully deleted.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            DB::rollBack();

            return response()->json(['success' => false, 'message' => 'Failed to delete bulk publishing status']);
        }
    }
}
