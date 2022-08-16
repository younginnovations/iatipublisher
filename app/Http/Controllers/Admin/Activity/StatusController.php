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
     * @return View|RedirectResponse|JsonResponse
     */
    public function edit(int $id): View|RedirectResponse|JsonResponse
    {
        try {
            $element = getElementSchema('activity_status');
            $activity = $this->statusService->getActivityData($id);
            $form = $this->statusService->formGenerator($id);
            $data = [
                'core' => $element['criteria'] ?? false,
                'status' => $activity->activity_status_element_completed ?? false,
                'title' => $element['label'],
                'name' => 'activity_status',
            ];

            return view('admin.activity.status.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while opening activity title form.');
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
            $activityStatus = $request->get('activity_status') !== null ? (int) $request->get('activity_status') : null;

            if (!$this->statusService->update($id, $activityStatus)) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating activity status.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Activity status updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(
                ['success' => false, 'error' => 'Error has occurred while updating activity status.']
            );
        }
    }
}
