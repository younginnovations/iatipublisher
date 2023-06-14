<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Workflow;

use App\Exceptions\PublisherNotFound;
use App\Http\Controllers\Controller;
use App\IATI\Services\ApiLog\ApiLogService;
use App\IATI\Services\Validator\ActivityValidatorResponseService;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * Class ActivityWorkflowController.
 */
class ActivityWorkflowController extends Controller
{
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
            Session::put('success', trans('responses.event_successfully', ['event'=>trans('events.published'), 'prefix'=>ucfirst(trans('elements_common.activity'))]));

            return response()->json(['success' => true, 'message' => ucfirst(trans('responses.has_been_event_successfully', ['prefix'=>trans('elements_common.activity'), 'event'=>trans('events.published')]))]);
        } catch (PublisherNotFound $message) {
            DB::rollBack();
            logger()->error($message->getMessage());
            Session::put('error', $message->getMessage());

            return response()->json(['success' => false, 'message' => $message->getMessage()]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            Session::put('error', trans('responses.error_has_occurred', ['event'=>trans('events.publishing'), 'suffix'=>trans('elements_common.activity')]));

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.publishing'), 'suffix'=>trans('elements_common.activity')])]);
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
                Session::put('error', trans('responses.activity_not_been_published_to_unpublish'));

                return response()->json(['success' => false, 'message' => trans('responses.activity_not_been_published_to_unpublish')]);
            }

            $this->activityWorkflowService->unpublishActivity($activity);
            DB::commit();
            $this->activityWorkflowService->deletePublishedFile($activity);
            Session::put('success', ucfirst(trans('responses.has_been_event_successfully', ['prefix'=>trans('elements_common.activity'), 'event'=>trans('events.unpublished')])));

            return response()->json(['success' => true, 'message' => ucfirst(trans('responses.has_been_event_successfully', ['prefix'=>trans('elements_common.activity'), 'event'=>trans('events.unpublished')]))]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            Session::put('error', trans('responses.error_has_occurred', ['event'=>trans('events.unpublishing'), 'suffix'=>trans('elements_common.activity')]));

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.unpublishing'), 'suffix'=>trans('elements_common.activity')])]);
        }
    }

    /**
     * Validates activity on the IATI Validator.
     *
     * @param $id
     *
     * @return JsonResponse
     * @throws \JsonException
     */
    public function validateActivity($id): JsonResponse
    {
        try {
            $activity = $this->activityWorkflowService->findActivity($id);
            $message = $this->activityWorkflowService->getPublishErrorMessage($activity->organization);

            if (!empty($message)) {
                Session::put('error', $message);

                return response()->json(['success' => false, 'message' => $message]);
            }

            $response = $this->activityWorkflowService->validateActivityOnIATIValidator($activity);
            $this->apiLogService->store(generateApiInfo('POST', env('IATI_VALIDATOR_ENDPOINT'), ['form_params' => json_encode($activity)], json_encode($response)));

            if ($this->validatorService->updateOrCreateresponse($id, json_decode($response, true, 512, JSON_THROW_ON_ERROR))) {
                return response()->json(json_decode($response, true, 512, JSON_THROW_ON_ERROR));
            }

            return response()->json(['success' => false, 'error' => trans('responses.error_has_occurred', ['event'=>trans('events.validating'), 'suffix'=>trans('elements_common.activity')])]);
        } catch (BadResponseException $ex) {
            if ($ex->getCode() === 422) {
                $response = $ex->getResponse()->getBody()->getContents();
                $this->apiLogService->store(generateApiInfo('POST', env('IATI_VALIDATOR_ENDPOINT'), ['form_params' => json_encode($activity)], json_encode($response)));

                if ($this->validatorService->updateOrCreateResponse($id, json_decode($response, true, 512, JSON_THROW_ON_ERROR))) {
                    return response()->json(json_decode($response, true, 512, JSON_THROW_ON_ERROR));
                }
            }

            return response()->json(['success' => false, 'error' => trans('responses.error_has_occured', ['event'=>trans('events.validating'), 'suffix'=>trans('elements_common.activity')])]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => trans('responses.error_has_occured', ['event'=>trans('events.validating'), 'suffix'=>trans('elements_common.activity')])]);
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

            return response()->json(['success' => true, 'message' => trans('responses.activity_ready_to_publish')]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.checking'), 'suffix'=>trans('elements_common.activity')])]);
        }
    }
}
