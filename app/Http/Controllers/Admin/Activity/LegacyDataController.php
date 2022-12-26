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
            $data = ['title' => $element['label'], 'name' => 'legacy_data'];

            return view('admin.activity.legacyData.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.rendering'), 'suffix'=>trans('elements_common.legacy_data')]));
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
                return redirect()->route('admin.activity.show', $id)->with('success', trans('responses.event_successfully', ['prefix'=>ucfirst(trans('elements_common.legacy_data')), ':event'=>trans('elements_common.updated')]));
            }

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.legacy_data')]));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.legacy_data')]));
        }
    }
}
