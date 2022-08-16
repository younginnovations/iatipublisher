<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DefaultFlowType\DefaultFlowTypeRequest;
use App\IATI\Services\Activity\DefaultFlowTypeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class DefaultFlowTypeController.
 */
class DefaultFlowTypeController extends Controller
{
    /**
     * @var DefaultFlowTypeService
     */
    protected DefaultFlowTypeService $defaultFlowTypeService;

    /**
     * DefaultFlowTypeController Constructor.
     *
     * @param DefaultFlowTypeService $defaultFlowTypeService
     */
    public function __construct(DefaultFlowTypeService $defaultFlowTypeService)
    {
        $this->defaultFlowTypeService = $defaultFlowTypeService;
    }

    /**
     * Renders default flow type edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->defaultFlowTypeService->getActivityData($id);
            $form = $this->defaultFlowTypeService->formGenerator($id);
            $data = [
                'core' => $element['default_flow_type']['criteria'] ?? '',
                'status' => $activity->default_flow_type_element_completed,
                'title' => $element['default_flow_type']['label'],
                'name' => 'default_flow_type',
            ];

            return view('admin.activity.defaultFlowType.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while rendering default-flow-type form.'
            );
        }
    }

    /**
     * Updates default flow type data.
     *
     * @param DefaultFlowTypeRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(DefaultFlowTypeRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->defaultFlowTypeService->getActivityData($id);
            $activityDefaultFlowType = $request->get('default_flow_type') != null ? (int) $request->get(
                'default_flow_type'
            ) : null;

            if (!$this->defaultFlowTypeService->update($activityDefaultFlowType, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with(
                    'error',
                    'Error has occurred while updating default-flow-type.'
                );
            }

            return redirect()->route('admin.activities.show', $id)->with(
                'success',
                'Default-flow-type updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while updating default-flow-type.'
            );
        }
    }
}
