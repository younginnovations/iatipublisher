<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\HumanitarianScope\HumanitarianScopeRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Services\Activity\HumanitarianScopeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class HumanitarianScopeController.
 */
class HumanitarianScopeController extends Controller
{
    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * @var HumanitarianScopeService
     */
    protected HumanitarianScopeService $humanitarianScopeService;

    /**
     * HumanitarianScopeController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param HumanitarianScopeService $humanitarianScopeService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, HumanitarianScopeService $humanitarianScopeService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->humanitarianScopeService = $humanitarianScopeService;
    }

    /**
     * Renders humanitarian edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->humanitarianScopeService->getActivityData($id);
            $model['humanitarian_scope'] = $this->humanitarianScopeService->getHumanitarianScopeData($id);
            $this->parentCollectionFormCreator->url = route('admin.activities.humanitarian-scope.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['humanitarian_scope'], 'PUT', '/activities/' . $id);
            $data = ['core' => $element['humanitarian_scope']['criteria'] ?? '', 'status' => $activity->humanitarian_scope_element_completed, 'title' => $element['humanitarian_scope']['label'], 'name' => 'humanitarian_scope'];

            return view('activity.humanitarianScope.humanitarianScope', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering humanitarian-scope form.');
        }
    }

    /**
     * Updates humanitarian scope form.
     *
     * @param HumanitarianScopeRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(HumanitarianScopeRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->humanitarianScopeService->getActivityData($id);
            $activityHumanitarianScope = $request->all();

            if (!$this->humanitarianScopeService->update($activityHumanitarianScope, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating humanitarian-scope.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Humanitarian-scope updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating humanitarian-scope.');
        }
    }
}
