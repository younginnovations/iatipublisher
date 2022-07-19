<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DefaultAidType\DefaultAidTypeRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\DefaultAidTypeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class DefaultAidTypeController.
 */
class DefaultAidTypeController extends Controller
{
    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var DefaultAidTypeService
     */
    protected DefaultAidTypeService $defaultAidTypeService;

    /**
     * DefaultAidTypeController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param DefaultAidTypeService $defaultAidTypeService
     */
    public function __construct(BaseFormCreator $baseFormCreator, DefaultAidTypeService $defaultAidTypeService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->defaultAidTypeService = $defaultAidTypeService;
    }

    /**
     * Renders aid type edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->defaultAidTypeService->getActivityData($id);
            $model['default_aid_type'] = $this->defaultAidTypeService->getDefaultAidTypeData($id);
            $this->baseFormCreator->url = route('admin.activities.default-aid-type.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['default_aid_type'], 'PUT', '/activities/' . $id);
            $data = ['core' => $element['default_aid_type']['criteria'] ?? '', 'status' => $activity->default_aid_type_element_completed, 'title' => $element['default_aid_type']['label'], 'name' => 'default_aid_type'];

            return view('activity.defaultAidType.defaultAidType', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering default-aid-type form.');
        }
    }

    /**
     * Updates default aid type data.
     * @param DefaultAidTypeRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(DefaultAidTypeRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->defaultAidTypeService->getActivityData($id);
            $activityDefaultAidType = $request->all();

            if (!$this->defaultAidTypeService->update($activityDefaultAidType, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating default-aid-type.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Default-aid-type updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating default aid type.');
        }
    }
}
