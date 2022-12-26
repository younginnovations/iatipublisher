<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DefaultTiedStatus\DefaultTiedStatusRequest;
use App\IATI\Services\Activity\DefaultTiedStatusService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class DefaultTiedStatusController.
 */
class DefaultTiedStatusController extends Controller
{
    /**
     * @var DefaultTiedStatusService
     */
    protected DefaultTiedStatusService $defaultTiedStatusService;

    /**
     * DefaultTiedStatusController Constructor.
     *
     * @param DefaultTiedStatusService $defaultTiedStatusService
     */
    public function __construct(DefaultTiedStatusService $defaultTiedStatusService)
    {
        $this->defaultTiedStatusService = $defaultTiedStatusService;
    }

    /**
     * Renders default tied status edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('default_tied_status');
            $activity = $this->defaultTiedStatusService->getActivityData($id);
            $form = $this->defaultTiedStatusService->formGenerator($id);
            $data = ['title' => $element['label'], 'name' => 'default_tied_status'];

            return view('admin.activity.defaultTiedStatus.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.rendering'), 'suffix'=>trans('elements_common.default_tied_status')]));
        }
    }

    /**
     * Updates default tied status data.
     *
     * @param DefaultTiedStatusRequest $request
     * @param                          $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(DefaultTiedStatusRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityDefaultTiedStatus = $request->get('default_tied_status') !== null ? (int) $request->get('default_tied_status') : null;

            if (!$this->defaultTiedStatusService->update($id, $activityDefaultTiedStatus)) {
                return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.default_tied_status')]));
            }

            return redirect()->route('admin.activity.show', $id)->with('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.default_tied_status'), 'event'=>trans('events.updated')])));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.default_tied_status')]));
        }
    }
}
