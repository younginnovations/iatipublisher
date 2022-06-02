<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Scope\ScopeRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\ScopeService;
use Illuminate\Http\JsonResponse;

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
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id)
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->scopeService->getActivityData($id);
            $model['activity_scope'] = $this->scopeService->getScopeData($id);
            $this->baseFormCreator->url = route('admin.activities.scope.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['activity_scope']);

            return view('activity.scope.scope', compact('form', 'activity'));
        } catch (\Exception $e) {
            dd(logger()->error($e->getMessage()));
            logger()->error($e->getMessage());
        }
    }

    /**
     * @param ScopeRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(ScopeRequest $request, $id): JsonResponse
    {
        try {
            $activityData = $this->scopeService->getActivityData($id);
            $activityScope = (int) $request->get('activity_scope');

            if (!$this->scopeService->update($activityScope, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity scope.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity scope updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity scope.']);
        }
    }
}
