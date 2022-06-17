<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\CollaborationType\CollaborationTypeRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
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
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var CollaborationTypeService
     */
    protected CollaborationTypeService $collaborationTypeService;

    /**
     * CollaborationTypeController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param CollaborationTypeService $collaborationTypeService
     */
    public function __construct(BaseFormCreator $baseFormCreator, CollaborationTypeService $collaborationTypeService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->collaborationTypeService = $collaborationTypeService;
    }

    /**
     * Updates collaboration type edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id):View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->collaborationTypeService->getActivityData($id);
            $model['collaboration_type'] = $this->collaborationTypeService->getCollaborationTypeData($id);
            $this->baseFormCreator->url = route('admin.activities.collaboration-type.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['collaboration-type']);

            return view('activity.collaborationType.collaborationType', compact('form', 'activity'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering activity collaboration type form.');
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
            $activityCollaborationType = (int) $request->get('collaboration_type');

            if (!$this->collaborationTypeService->update($activityCollaborationType, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity collaboration type.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Activity collaboration type updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity collaboration type.');
        }
    }
}
