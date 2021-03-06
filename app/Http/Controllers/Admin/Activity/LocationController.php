<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Location\LocationRequest;
use App\IATI\Services\Activity\LocationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class LocationController
 *.
 */
class LocationController extends Controller
{
    /**
     * @var LocationService
     */
    protected LocationService $locationService;

    /**
     * LocationController Constructor.
     *
     * @param LocationService $locationService
     */
    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    /**
     * Renders location edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->locationService->getActivityData($id);
            $form = $this->locationService->formGenerator($id);
            $data = ['core' => $element['location']['criteria'] ?? '', 'status' => $activity->location_element_completed ?? false, 'title' => $element['location']['label'], 'name' => 'location'];

            return view('admin.activity.location.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering location form.');
        }
    }

    /**
     * Updates location data.
     *
     * @param LocationRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(LocationRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->locationService->getActivityData($id);
            $activityCountryBudgetItem = $request->except(['_token', '_method']);

            if (!$this->locationService->update($activityCountryBudgetItem, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating location.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Location updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating location.');
        }
    }
}
