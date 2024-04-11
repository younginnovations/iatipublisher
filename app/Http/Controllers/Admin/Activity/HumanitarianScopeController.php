<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\HumanitarianScope\HumanitarianScopeRequest;
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
     * @var HumanitarianScopeService
     */
    protected HumanitarianScopeService $humanitarianScopeService;

    /**
     * HumanitarianScopeController Constructor.
     *
     * @param HumanitarianScopeService $humanitarianScopeService
     */
    public function __construct(HumanitarianScopeService $humanitarianScopeService)
    {
        $this->humanitarianScopeService = $humanitarianScopeService;
    }

    /**
     * Renders humanitarian edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('humanitarian_scope');
            $activity = $this->humanitarianScopeService->getActivityData($id);
            $form = $this->humanitarianScopeService->formGenerator($id, $activity->default_field_values ?? []);
            $data = ['title' => $element['label'], 'name' => 'humanitarian_scope'];

            return view('admin.activity.humanitarianScope.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while rendering humanitarian-scope form.');
        }
    }

    /**
     * Updates humanitarian scope form.
     *
     * @param HumanitarianScopeRequest $request
     * @param                          $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(HumanitarianScopeRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            if ($this->humanitarianScopeService->update($id, $request->except(['_token', '_method']))) {
                return redirect()->route('admin.activity.show', $id)->with('success', 'Humanitarian-scope updated successfully.');
            }

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating humanitarian-scope.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating humanitarian-scope.');
        }
    }
}
