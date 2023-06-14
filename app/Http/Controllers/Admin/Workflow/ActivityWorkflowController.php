<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Workflow;

use App\Exceptions\PublisherNotFound;
use App\Http\Controllers\Controller;
use App\IATI\Services\ApiLog\ApiLogService;
use App\IATI\Services\Validator\ActivityValidatorResponseService;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use App\IATI\Traits\IatiValidatorResponseTrait;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\JsonResponse;
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
            Session::put('success', 'Activity has been published successfully.');

            return response()->json(['success' => true, 'message' => 'Activity has been published successfully.']);
        } catch (PublisherNotFound $message) {
            DB::rollBack();
            logger()->error($message->getMessage());
            logger()->error($message);
            Session::put('error', $message->getMessage());

            return response()->json(['success' => false, 'message' => $message->getMessage()]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            logger()->error($e);
            Session::put('error', 'Error has occurred while publishing activity.');

            return response()->json(['success' => false, 'message' => 'Error has occurred while publishing activity.']);
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
                Session::put('error', 'This activity has not been published to un-publish.');

                return response()->json(['success' => false, 'message' => 'This activity has not been published to un-publish.']);
            }

            $this->activityWorkflowService->unpublishActivity($activity);
            DB::commit();
            $this->activityWorkflowService->deletePublishedFile($activity);
            Session::put('success', 'Activity has been un-published successfully.');

            return response()->json(['success' => true, 'message' => 'Activity has been un-published successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            Session::put('error', 'Error has occurred while un-publishing activity.');

            return response()->json(['success' => false, 'message' => 'Error has occurred while un-publishing activity.']);
        }
    }

    /**
     * Validates activity on the IATI Validator.
     *
     * @param $id
     *
     * @return JsonResponse
     *
     * @throws \JsonException|\GuzzleHttp\Exception\GuzzleException
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
            $response = $this->addElementOnIatiValidatorResponse($response, $activity);
            $this->apiLogService->store(generateApiInfo('POST', env('IATI_VALIDATOR_ENDPOINT'), ['form_params' => json_encode($activity)], json_encode($response)));

            if ($this->validatorService->updateOrCreateresponse($id, $response)) {
                return response()->json($response);
            }

            return response()->json(['success' => false, 'error' => 'Error has occurred while validating activity.']);
        } catch (BadResponseException $ex) {
            if ($ex->getCode() === 422) {
                $response = $ex->getResponse()->getBody()->getContents();
                $response = $this->addElementOnIatiValidatorResponse($response, $activity);

                $this->apiLogService->store(generateApiInfo('POST', env('IATI_VALIDATOR_ENDPOINT'), ['form_params' => json_encode($activity)], json_encode($response)));

                if ($this->validatorService->updateOrCreateResponse($id, $response)) {
                    return response()->json($response);
                }
            }

            return response()->json(['success' => false, 'error' => 'Error has occurred while validating activity.']);
        } catch (\Exception $e) {
            logger()->error($e);
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while validating activity.']);
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

            return response()->json(['success' => true, 'message' => 'Activity is ready to be published.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while checking activity.']);
        }
    }
}
