<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Condition\ConditionRequest;
use App\IATI\Services\Activity\ConditionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class ConditionController.
 */
class ConditionController extends Controller
{
    /**
     * @var ConditionService
     */
    protected ConditionService $conditionService;

    /**
     * ConditionController Constructor.
     *
     * @param ConditionService $conditionService
     */
    public function __construct(ConditionService $conditionService)
    {
        $this->conditionService = $conditionService;
    }

    /**
     * Renders condition edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->conditionService->getActivityData($id);
            $form = $this->conditionService->formGenerator($id);
            $data = ['core' => $element['conditions']['criteria'] ?? false, 'status' => $activity->conditions_element_completed, 'title' => $element['conditions']['label'], 'name' => 'conditions'];

            return view('admin.activity.condition.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering activity condition form.');
        }
    }

    /**
     * Updates condition data.
     *
     * @param ConditionRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(ConditionRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->conditionService->getActivityData($id);
            $activityCondition = $request->except(['_token', '_method']);

            if (!$this->conditionService->update($activityCondition, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity condition.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Activity condition updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity condition.');
        }
    }
}
