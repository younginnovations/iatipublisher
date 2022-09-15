<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\LegacyData\LegacyDataRequest;
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
     * @var LegacyDataService
     */
    protected LegacyDataService $activityLegacyDataService;

    /**
     * LegacyDataController Constructor.
     *
     * @param LegacyDataService $activityLegacyDataService
     */
    public function __construct(LegacyDataService $activityLegacyDataService)
    {
        $this->activityLegacyDataService = $activityLegacyDataService;
    }

    /**
     * Renders legacy data form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('legacy_data');
            $activity = $this->activityLegacyDataService->getActivityData($id);
            $form = $this->activityLegacyDataService->formGenerator($id);
            $data = ['core' => $element['legacy_data']['criteria'] ?? '', 'title' => $element['label'], 'name' => 'legacy_data'];

            return view('admin.activity.legacyData.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while rendering legacy-data form.');
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
            if ($this->activityLegacyDataService->update($id, $request->all())) {
                return redirect()->route('admin.activity.show', $id)->with('success', 'Legacy-data updated successfully.');
            }

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating legacy-data.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating legacy-data.');
        }
    }
}
