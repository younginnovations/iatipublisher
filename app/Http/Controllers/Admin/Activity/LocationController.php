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
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('location');
            $activity = $this->locationService->getActivityData($id);
            $form = $this->locationService->formGenerator($id, $activity->default_field_values ?? []);
            $data = ['title' => $element['label'], 'name' => 'location'];

            return view('admin.activity.location.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while rendering location form.');
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
            if (!$this->locationService->update($id, $request->except(['_token', '_method']))) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating location.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Location updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating location.');
        }
    }
}
