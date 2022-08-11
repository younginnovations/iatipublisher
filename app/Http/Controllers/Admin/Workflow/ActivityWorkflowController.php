<?php

namespace App\Http\Controllers\Admin\Workflow;

use App\Exceptions\PublisherNotFound;
use App\Http\Controllers\Controller;
use App\IATI\Services\Validator\ActivityValidatorResponseService;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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
     * ActivityWorkflowController Constructor.
     *
     * @param ActivityWorkflowService $activityWorkflowService
     * @param ActivityValidatorResponseService $validatorService
     */
    public function __construct(ActivityWorkflowService $activityWorkflowService, ActivityValidatorResponseService $validatorService)
    {
        $this->activityWorkflowService = $activityWorkflowService;
        $this->validatorService = $validatorService;
    }

    /**
     * Publish an activity.
     *
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function publish($id): JsonResponse|RedirectResponse
    {
        try {
            $activity = $this->activityWorkflowService->findActivity($id);

            if ($this->hasNoPublisherInfo($activity->organization->settings)) {
                return response()->json(['success' => false, 'message' => 'Please update the publishing information first.']);
            }

            DB::beginTransaction();
            $this->activityWorkflowService->publishActivity($activity);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Activity has been published successfully.']);
        } catch (PublisherNotFound $message) {
            DB::rollBack();
            logger()->error($message->getMessage());

            return response()->json(['success' => false, 'message' => $message->getMessage()]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while publishing activity.']);
        }
    }

    /**
     * Check if the Organization's publisher_id and api_token has been filled out and are correct.
     *
     * @param $settings
     *
     * @return bool
     */
    protected function hasNoPublisherInfo($settings): bool
    {
        if (!$settings || !($registryInfo = $settings->publishing_info)) {
            return true;
        }

        if (empty(Arr::get($registryInfo, 'publisher_id', null) ||
            empty(Arr::get($registryInfo, 'api_token', null)) ||
            Arr::get($registryInfo, 'publisher_verification', false) ||
            Arr::get($registryInfo, 'token_verification', false)
        )) {
            return true;
        }

        return false;
    }

    /**
     * Unpublish an activity from the IATI registry.
     *
     * @param $id
     *
     * @return RedirectResponse
     */
    public function unpublish($id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $activity = $this->activityWorkflowService->findActivity($id);

            if (!$activity->already_published && $activity->status === 'draft') {
                return response()->json(['success' => false, 'message' => 'This activity has not been published to un-publish.']);
            }

            $this->activityWorkflowService->unpublishActivity($activity);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Activity has been un-published successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while un-publishing activity.']);
        }
    }

    /**
     * Validates activity on the IATI Validator.
     *
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function validateActivity($id): JsonResponse|RedirectResponse
    {
        try {
            $activity = $this->activityWorkflowService->findActivity($id);
            $response = $this->activityWorkflowService->validateActivityOnIATIValidator($activity);

            if ($this->validatorService->updateOrCreateResponse($id, json_decode($response, true))) {
                return response()->json(json_decode($response, true));
            }

            return response()->json(['success' => false, 'error' => 'Error has occurred while validating activity.']);
        } catch (BadResponseException $ex) {
            if ($ex->getCode() == 422) {
                $response = $ex->getResponse()->getBody()->getContents();

                if ($this->validatorService->updateOrCreateResponse($id, json_decode($response, true))) {
                    return response()->json(json_decode($response, true));
                }
            }

            return response()->json(['success' => false, 'error' => 'Error has occurred while validating activity.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while validating activity.');
        }
    }
}
