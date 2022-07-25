<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Status\StatusRequest;
use App\IATI\Services\Activity\StatusService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class StatusController.
 */
class StatusController extends Controller
{
    /**
     * @var StatusService
     */
    protected StatusService $statusService;

    /**
     * StatusController Constructor.
     *
     * @param StatusService $statusService
     */
    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * Renders status edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse|JsonResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->statusService->getActivityData($id);
            $form = $this->statusService->formGenerator($id);
            $data = ['core' => $element['activity_status']['criteria'] ?? false, 'status' => $activity->activity_status_element_completed ?? false, 'title' => $element['activity_status']['label'], 'name' => 'activity_status'];

            return view('admin.activity.status.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening activity title form.');
        }
    }

    /**
     * Updates status data.
     *
     * @param StatusRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(StatusRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->statusService->getActivityData($id);
            $activityStatus = $request->get('activity_status') != null ? (int) $request->get('activity_status') : null;

            if (!$this->statusService->update($activityStatus, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity status.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Activity status updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity status.']);
        }
    }
}
