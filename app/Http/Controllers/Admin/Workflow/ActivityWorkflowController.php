<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Workflow;

use App\Exceptions\PublisherNotFound;
use App\Http\Controllers\Controller;
use App\IATI\Services\ApiLog\ApiLogService;
use App\IATI\Services\Validator\ActivityValidatorResponseService;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use App\IATI\Traits\IatiValidatorResponseTrait;
use App\Jobs\RegistryValidatorJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * Class ActivityWorkflowController.
 */
class ActivityWorkflowController extends Controller
{
    use IatiValidatorResponseTrait;

    /**
     * @var ActivityWorkflowService
     */
    protected ActivityWorkflowService $activityWorkflowService;

    /**
     * @var ActivityValidatorResponseService
     */
    protected ActivityValidatorResponseService $validatorService;

    /**
     * @var ApiLogService
     */
    protected ApiLogService $apiLogService;

    /**
     * ActivityWorkflowController Constructor.
     *
     * @param ActivityWorkflowService $activityWorkflowService
     * @param ActivityValidatorResponseService $validatorService
     * @param ApiLogService $apiLogService
     */
    public function __construct(ActivityWorkflowService $activityWorkflowService, ActivityValidatorResponseService $validatorService, ApiLogService $apiLogService)
    {
        $this->activityWorkflowService = $activityWorkflowService;
        $this->validatorService = $validatorService;
        $this->apiLogService = $apiLogService;
    }

    /**
     * Publish an activity.
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function publish($id): JsonResponse
    {
        try {
            $activity = $this->activityWorkflowService->findActivity($id);
            $message = $this->activityWorkflowService->getPublishErrorMessage($activity->organization);

            if (!empty($message)) {
                Session::put('error', $message);

                return response()->json(['success' => false, 'message' => $message]);
            }

            DB::beginTransaction();
            $this->activityWorkflowService->publishActivity($activity);
            DB::commit();
            $translatedData = trans('work_flow/activity_workflow_controller.activity_has_been_published_successfully');
            Session::put('success', $translatedData);

            return response()->json(['success' => true, 'message' => $translatedData]);
        } catch (PublisherNotFound $message) {
            DB::rollBack();
            logger()->error($message->getMessage());
            Session::put('error', $message->getMessage());

            return response()->json(['success' => false, 'message' => $message->getMessage()]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            $translatedData = trans('work_flow/activity_workflow_controller.error_has_occurred_while_publishing_activity');

            Session::put('error', $translatedData);

            return response()->json(['success' => false, 'message' => $translatedData]);
        }
    }

    /**
     * Unpublish an activity from the IATI registry.
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function unpublish($id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $activity = $this->activityWorkflowService->findActivity($id);

            if (!$activity->linked_to_iati) {
                $translatedData = trans('work_flow/activity_workflow_controller.this_activity_has_not_been_published_to_un_publish');

                Session::put('error', $translatedData);

                return response()->json(['success' => false, 'message' => $translatedData]);
            }

            $this->activityWorkflowService->unpublishActivity($activity);
            DB::commit();
            $this->activityWorkflowService->deletePublishedFile($activity);
            $translatedData = trans('work_flow/activity_workflow_controller.activity_has_been_un_published_successfully');
            Session::put('success', $translatedData);

            return response()->json(['success' => true, 'message' => $translatedData]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            $translatedData = trans('work_flow/activity_workflow_controller.error_has_occurred_while_un_publishing_activity');
            Session::put('error', $translatedData);

            return response()->json(['success' => false, 'message' => $translatedData]);
        }
    }

    /**
     * Validates activity on the IATI Validator.
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function validateActivity($id): JsonResponse
    {
        try {
            $activity = $this->activityWorkflowService->findActivity($id);
            $message = $this->activityWorkflowService->getPublishErrorMessage($activity->organization);
            $user = Auth::user();

            if (!empty($message)) {
                Session::put('error', $message);

                return response()->json(['success' => false, 'message' => $message]);
            }

            RegistryValidatorJob::dispatch($activity, $user);
            $translatedData = trans('work_flow/activity_workflow_controller.validating_activities');

            return response()->json(['success' => true, 'message' => $translatedData]);
        } catch (\Exception $e) {
            logger()->error($e);
            $translatedData = trans('work_flow/activity_workflow_controller.error_has_occurred_while_validating_activity');

            return response()->json(['success' => false, 'error' => $translatedData]);
        }
    }

    /**
     * Performs required checks for publishing activity.
     *
     * @return JsonResponse
     */
    public function checksForActivityPublish(): JsonResponse
    {
        try {
            $message = $this->activityWorkflowService->getPublishErrorMessage(auth()->user()->organization);

            if (!empty($message)) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            $translatedData = trans('work_flow/activity_workflow_controller.activity_is_ready_to_be_published');

            return response()->json(['success' => true, 'message' => $translatedData]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            $translatedData = trans('work_flow/activity_workflow_controller.error_has_occurred_while_checking_activity');

            return response()->json(['success' => false, 'message' => $translatedData]);
        }
    }
}
