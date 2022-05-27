<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\CollaborationType\CollaborationTypeRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\CollaborationTypeService;
use Illuminate\Http\JsonResponse;

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
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id)
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $model['collaboration_type'] = $this->collaborationTypeService->getCollaborationTypeData($id);
            $this->baseFormCreator->url = route('admin.activities.collaboration-type.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['collaboration-type']);

            return view('activity.collaborationType.collaborationType', compact('form'));
        } catch (\Exception $e) {
            dd(logger()->error($e->getMessage()));
            logger()->error($e->getMessage());
        }
    }

    /**
     * @param CollaborationTypeRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(CollaborationTypeRequest $request, $id): JsonResponse
    {
        try {
            $activityData = $this->collaborationTypeService->getActivityData($id);
            $activityCollaborationType = (int) $request->get('collaboration_type');

            if (!$this->collaborationTypeService->update($activityCollaborationType, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity collaboration type.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity collaboration type updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity collaboration type.']);
        }
    }
}
