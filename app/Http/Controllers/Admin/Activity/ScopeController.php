<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Scope\ScopeRequest;
use App\IATI\Services\Activity\ScopeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class ScopeController.
 */
class ScopeController extends Controller
{
    /**
     * @var ScopeService
     */
    protected ScopeService $scopeService;

    /**
     * ScopeController Constructor.
     *
     * @param ScopeService $scopeService
     */
    public function __construct(ScopeService $scopeService)
    {
        $this->scopeService = $scopeService;
    }

    /**
     * Renders scope edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('activity_scope');
            $activity = $this->scopeService->getActivityData($id);
            $form = $this->scopeService->formGenerator($id);
            $data = ['title' => $element['label'], 'name' => 'activity_scope'];

            return view('admin.activity.scope.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.opening'), 'suffix'=>trans('elements_common.activity_form')]));
        }
    }

    /**
     * Updates scope data.
     *
     * @param ScopeRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(ScopeRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityScope = $request->get('activity_scope') !== null ? (int) $request->get('activity_scope') : null;

            if (!$this->scopeService->update($id, $activityScope)) {
                return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.activity_scope')]));
            }

            return redirect()->route('admin.activity.show', $id)->with('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.activity_scope'), 'event'=>trans('events.updated')])));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.activity_scope')]));
        }
    }
}
