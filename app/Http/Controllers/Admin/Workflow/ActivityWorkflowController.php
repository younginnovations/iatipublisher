<?php

namespace App\Http\Controllers\Admin\Workflow;

use App\Exceptions\PublisherNotFound;
use App\Http\Controllers\Controller;
use App\IATI\Services\Workflow\ActivityWorkflowService;
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

            DB::beginTransaction();
            $this->activityWorkflowService->publishActivity($activity);
            DB::commit();

            return redirect()->route('admin.activities.show', $activityId)->with('success', 'Activity has been published successfully.');
        } catch (PublisherNotFound $message) {
            DB::rollBack();
            logger()->error($message->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with('error', $message->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
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

    /**
     * Unpublish an activity from the IATI registry.
     *
     * @param $activityId
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function unpublish($activityId)
    {
        try {
            DB::beginTransaction();
            $activity = $this->activityWorkflowService->findActivity($activityId);

            if (!$activity->already_published && $activity->status === 'draft') {
                return redirect()->route('admin.activities.show', $activityId)->with('error', 'This activity has not been published to un-publish.');
            }

            $this->activityWorkflowService->unpublishActivity($activity);
            DB::commit();

            return redirect()->route('admin.activities.show', $activityId)->with('success', 'Activity has been un-published successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with('error', 'Error has occurred while un-publishing activity.');
        }
    }
}
