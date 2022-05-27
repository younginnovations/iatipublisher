<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\LegacyData\LegacyDataRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\LegacyDataService;
use Illuminate\Http\JsonResponse;

/**
 * Class LegacyDataController.
 */
class LegacyDataController extends Controller
{
    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var LegacyDataService
     */
    protected LegacyDataService $activityLegacyDataService;

    /**
     * LegacyDataController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param LegacyDataService $activityLegacyDataService
     */
    public function __construct(BaseFormCreator $baseFormCreator, LegacyDataService $activityLegacyDataService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->activityLegacyDataService = $activityLegacyDataService;
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
            $model['legacy_data'] = $this->activityLegacyDataService->getActivityLegacyData($id);
            $this->baseFormCreator->url = route('admin.activities.legacy-data.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['legacy-data']);

            return view('activity.legacyData.legacyData', compact('form'));
        } catch (\Exception $e) {
            dd(logger()->error($e->getMessage()));
            logger()->error($e->getMessage());
        }
    }

    /**
     * @param LegacyDataRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(LegacyDataRequest $request, $id): JsonResponse
    {
        try {
            $activityData = $this->activityLegacyDataService->getActivityData($id);
            $activityLegacyData = $request->all();

            if (!$this->activityLegacyDataService->update($activityLegacyData, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity legacy data.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity legacy data updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity legacy data.']);
        }
    }
}
