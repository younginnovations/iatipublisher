<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DefaultAidType\DefaultAidTypeRequest;
use App\IATI\Services\Activity\DefaultAidTypeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class DefaultAidTypeController.
 */
class DefaultAidTypeController extends Controller
{
    /**
     * @var DefaultAidTypeService
     */
    protected DefaultAidTypeService $defaultAidTypeService;

    /**
     * DefaultAidTypeController Constructor.
     *
     * @param DefaultAidTypeService $defaultAidTypeService
     */
    public function __construct(DefaultAidTypeService $defaultAidTypeService)
    {
        $this->defaultAidTypeService = $defaultAidTypeService;
    }

    /**
     * Renders aid type edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('default_aid_type');
            $activity = $this->defaultAidTypeService->getActivityData($id);
            $form = $this->defaultAidTypeService->formGenerator($id);
            $data = [
                'title' => $element['label'],
                'name' => 'default_aid_type',
            ];

            return view('admin.activity.defaultAidType.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while rendering default-aid-type form.');
        }
    }

    /**
     * Updates default aid type data.
     * @param DefaultAidTypeRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(DefaultAidTypeRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityDefaultAidType = $request->all();

            if (!$this->defaultAidTypeService->update($id, $activityDefaultAidType)) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating default-aid-type.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Default-aid-type updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating default aid type.');
        }
    }
}
