<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DefaultFlowType\DefaultFlowTypeRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\DefaultFlowTypeService;
use Illuminate\Http\JsonResponse;

/**
 * Class DefaultFlowTypeController.
 */
class DefaultFlowTypeController extends Controller
{
    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var DefaultFlowTypeService
     */
    protected DefaultFlowTypeService $defaultFlowTypeService;

    /**
     * DefaultFlowTypeController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param DefaultFlowTypeService $defaultFlowTypeService
     */
    public function __construct(BaseFormCreator $baseFormCreator, DefaultFlowTypeService $defaultFlowTypeService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->defaultFlowTypeService = $defaultFlowTypeService;
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
            $model['default_flow_type'] = $this->defaultFlowTypeService->getDefaultFlowTypeData($id);
            $this->baseFormCreator->url = route('admin.activities.default-flow-type.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['default-flow-type']);

            return view('activity.defaultFlowType.defaultFlowType', compact('form'));
        } catch (\Exception $e) {
            dd(logger()->error($e->getMessage()));
            logger()->error($e->getMessage());
        }
    }

    /**
     * @param DefaultFlowTypeRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(DefaultFlowTypeRequest $request, $id): JsonResponse
    {
        try {
            $activityData = $this->defaultFlowTypeService->getActivityData($id);
            $activityDefaultFlowType = (int) $request->get('default_flow_type');

            if (!$this->defaultFlowTypeService->update($activityDefaultFlowType, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity default flow type.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity default flow type updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity default flow type.']);
        }
    }
}
