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
            $form = $this->locationService->formGenerator($id);
            $data = ['title' => $element['label'], 'name' => 'location'];

            return view('admin.activity.location.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.rendering'), 'suffix'=>trans('elements_common.location')]));
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
                return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.location')]));
            }

            return redirect()->route('admin.activity.show', $id)->with('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.location'), 'event'=>trans('events.updated')])));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.location')]));
        }
    }
}
