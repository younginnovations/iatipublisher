<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Scope\ScopeRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
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
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var ScopeService
     */
    protected ScopeService $scopeService;

    /**
     * ScopeController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param ScopeService $scopeService
     */
    public function __construct(BaseFormCreator $baseFormCreator, ScopeService $scopeService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->scopeService = $scopeService;
    }

    /**
     * Renders scope edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->scopeService->getActivityData($id);
            $model['activity_scope'] = $this->scopeService->getScopeData($id);
            $this->baseFormCreator->url = route('admin.activities.scope.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['activity_scope']);
            $data = ['core'=> $element['activity_scope']['criteria'], 'status'=> $activity->activity_scope_element_completed, 'title'=> $element['activity_scope']['label'], 'name'=>'activity_scope'];

            return view('activity.scope.scope', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening activity scope form.');
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
            $activityData = $this->scopeService->getActivityData($id);
            $activityScope = (int) $request->get('activity_scope');

            if (!$this->scopeService->update($activityScope, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity scope.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Activity scope updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity scope.');
        }
    }
}
