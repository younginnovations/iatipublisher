<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\LegacyData\LegacyDataRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\LegacyDataService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

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
     * Renders legacy data form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $model['legacy_data'] = $this->activityLegacyDataService->getActivityLegacyData($id);
            $activity = $this->activityLegacyDataService->getActivityData($id);
            $this->baseFormCreator->url = route('admin.activities.legacy-data.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['legacy_data'], 'PUT', '/activities/' . $id);
            $data = ['core' => $element['legacy_data']['criteria'] ?? '', 'status' => $activity->legacy_data_element_completed, 'title' => $element['legacy_data']['label'], 'name' => 'legacy_data'];

            return view('activity.legacyData.legacyData', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            dd($e);
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering legacy-data form.');
        }
    }

    /**
     * Updates legacy data.
     *
     * @param LegacyDataRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(LegacyDataRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->activityLegacyDataService->getActivityData($id);
            $activityLegacyData = $request->all();

            if (!$this->activityLegacyDataService->update($activityLegacyData, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating legacy-data.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Legacy-data updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating legacy-data.');
        }
    }
}
