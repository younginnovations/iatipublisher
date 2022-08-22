<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DefaultTiedStatus\DefaultTiedStatusRequest;
use App\IATI\Services\Activity\DefaultTiedStatusService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class DefaultTiedStatusController.
 */
class DefaultTiedStatusController extends Controller
{
    /**
     * @var DefaultTiedStatusService
     */
    protected DefaultTiedStatusService $defaultTiedStatusService;

    /**
     * DefaultTiedStatusController Constructor.
     *
     * @param DefaultTiedStatusService $defaultTiedStatusService
     */
    public function __construct(DefaultTiedStatusService $defaultTiedStatusService)
    {
        $this->defaultTiedStatusService = $defaultTiedStatusService;
    }

    /**
     * Renders default tied status edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->defaultTiedStatusService->getActivityData($id);
            $form = $this->defaultTiedStatusService->formGenerator($id);
            $data = [
                'core' => $element['default_tied_status']['criteria'] ?? '',
                'status' => $activity->default_tied_status_element_completed,
                'title' => $element['default_tied_status']['label'],
                'name' => 'default_tied_status',
            ];

            return view('admin.activity.defaultTiedStatus.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while rendering default-tied-status form.'
            );
        }
    }

    /**
     * Updates default tied status data.
     *
     * @param DefaultTiedStatusRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(DefaultTiedStatusRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->defaultTiedStatusService->getActivityData($id);
            $activityDefaultTiedStatus = $request->get('default_tied_status') ? (int) $request->get(
                'default_tied_status'
            ) : null;

            if (!$this->defaultTiedStatusService->update($activityDefaultTiedStatus, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with(
                    'error',
                    'Error has occurred while updating default-tied-status.'
                );
            }

            return redirect()->route('admin.activities.show', $id)->with(
                'success',
                'Default-tied-status updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while updating default-tied-status.'
            );
        }
    }
}
