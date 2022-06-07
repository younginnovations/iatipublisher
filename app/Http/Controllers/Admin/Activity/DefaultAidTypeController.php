<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DefaultAidType\DefaultAidTypeRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\DefaultAidTypeService;
use Illuminate\Http\JsonResponse;

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
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id)
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $model['default_aid_type'] = $this->defaultAidTypeService->getDefaultAidTypeData($id);
            $this->baseFormCreator->url = route('admin.activities.default-aid-type.update', [$id]);
            $temp = [];

            foreach ($element['default-aid-type']['attributes']['code']['choices'] as $key => $choice) {
                $temp[$key] = getList($choice, true);
            }

            $element['default-aid-type']['attributes']['code']['choices'] = $temp;
            $form = $this->baseFormCreator->editForm($model, $element['default-aid-type']);

            return view('activity.defaultAidType.defaultAidType', compact('form'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            dd($e);
        }
    }

    /**
     * @param DefaultAidTypeRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(DefaultAidTypeRequest $request, $id): JsonResponse
    {
        try {
            $activityData = $this->defaultAidTypeService->getActivityData($id);
            $activityDefaultAidType = (int) $request->get('default_aid_type');

            if (!$this->defaultAidTypeService->update($activityDefaultAidType, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity default aid type.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity default aid type updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity default aid type.']);
        }
    }
}
