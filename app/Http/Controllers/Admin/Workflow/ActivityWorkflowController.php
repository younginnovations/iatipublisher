<?php

namespace App\Http\Controllers\Admin\Workflow;

use App\Http\Controllers\Controller;
use App\IATI\Services\Workflow\ActivityWorkflowService;
use Illuminate\Support\Arr;

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
     * ActivityWorkflowController Constructor.
     *
     * @param ActivityWorkflowService $activityWorkflowService
     */
    public function __construct(ActivityWorkflowService $activityWorkflowService)
    {
        $this->activityWorkflowService = $activityWorkflowService;
    }

    /**
     * Publish an activity.
     *
     * @param $activityId
     *
     * @return mixed
     */
    public function publish($activityId)
    {
        try {
            $activity = $this->activityWorkflowService->findActivity($activityId);

            if ($this->hasNoPublisherInfo($activity->organization->settings)) {
                return response()->json(['success' => false, 'error' => 'Please update the publishing information first.']);
            }

            $result = $this->activityWorkflowService->publishActivity($activity);

            return redirect()->route('admin.activities.show', $activityId)->with('success', 'Activity has been published successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with('error', 'Error has occurred while publishing activity.');
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
}
