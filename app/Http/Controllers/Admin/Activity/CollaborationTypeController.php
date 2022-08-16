<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\CollaborationType\CollaborationTypeRequest;
use App\IATI\Services\Activity\CollaborationTypeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class CollaborationTypeController.
 */
class CollaborationTypeController extends Controller
{
    /**
     * @var CollaborationTypeService
     */
    protected CollaborationTypeService $collaborationTypeService;

    /**
     * CollaborationTypeController Constructor.
     *
     * @param CollaborationTypeService $collaborationTypeService
     */
    public function __construct(CollaborationTypeService $collaborationTypeService)
    {
        $this->collaborationTypeService = $collaborationTypeService;
    }

    /**
     * Updates collaboration type edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->collaborationTypeService->getActivityData($id);
            $form = $this->collaborationTypeService->formGenerator($id);
            $data = [
                'core' => $element['collaboration_type']['criteria'] ?? '',
                'status' => $activity->collaboration_type_element_completed,
                'title' => $element['collaboration_type']['label'],
                'name' => 'collaboration_type',
            ];

            return view('admin.activity.collaborationType.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while rendering activity collaboration-type form.'
            );
        }
    }

    /**
     * Updates collaboration type data.
     *
     * @param CollaborationTypeRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(CollaborationTypeRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->collaborationTypeService->getActivityData($id);
            $activityCollaborationType = $request->get('collaboration_type') != null ? (int) $request->get(
                'collaboration_type'
            ) : null;

            if (!$this->collaborationTypeService->update($activityCollaborationType, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with(
                    'error',
                    'Error has occurred while updating activity collaboration-type.'
                );
            }

            return redirect()->route('admin.activities.show', $id)->with(
                'success',
                'Activity collaboration-type updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while updating activity collaboration type.'
            );
        }
    }
}
