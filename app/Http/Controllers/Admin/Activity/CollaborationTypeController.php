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
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('collaboration_type');
            $activity = $this->collaborationTypeService->getActivityData($id);
            $form = $this->collaborationTypeService->formGenerator($id);
            $data = [
                'title' => $element['label'],
                'name' => 'collaboration_type',
            ];

            return view('admin.activity.collaborationType.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)
                ->with('error', translateErrorHasOccurred('responses.activity_collaboration_type', 'rendering', 'form'));
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
            $activityCollaborationType = $request->get('collaboration_type') !== null ? (int) $request->get('collaboration_type') : null;

            if (!$this->collaborationTypeService->update($id, $activityCollaborationType)) {
                return redirect()->route('admin.activity.show', $id)->with('error', translateErrorHasOccurred('responses.activity_collaboration_type', 'updating'));
            }

            return redirect()->route('admin.activity.show', $id)->with('success', translateElementSuccessfully('activity_collaboration_type', 'updated'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', translateErrorHasOccurred('responses.activity_collaboration_type', 'updating'));
        }
    }
}
