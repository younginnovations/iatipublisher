<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Condition\ConditionRequest;
use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Services\Activity\ConditionService;
use Illuminate\Http\JsonResponse;

/**
 * Class ConditionController.
 */
class ConditionController extends Controller
{
    /**
     * @var MultilevelSubElementFormCreator
     */
    protected MultilevelSubElementFormCreator $multilevelSubElementFormCreator;

    /**
     * @var ConditionService
     */
    protected ConditionService $conditionService;

    /**
     * ConditionController Constructor.
     *
     * @param MultilevelSubElementFormCreator $multilevelSubElementFormCreator
     * @param ConditionService $conditionService
     */
    public function __construct(MultilevelSubElementFormCreator $multilevelSubElementFormCreator, ConditionService $conditionService)
    {
        $this->multilevelSubElementFormCreator = $multilevelSubElementFormCreator;
        $this->conditionService = $conditionService;
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
            $activity = $this->conditionService->getActivityData($id);
            $model = $this->conditionService->getConditionData($id) ?: [];
            $this->multilevelSubElementFormCreator->url = route('admin.activities.conditions.update', [$id]);
            $form = $this->multilevelSubElementFormCreator->editForm($model, $element['conditions']);

            return view('activity.condition.condition', compact('form', 'activity'));
        } catch (\Exception $e) {
            dd(logger()->error($e->getMessage()));
            logger()->error($e->getMessage());
        }
    }

    /**
     * @param ConditionRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(ConditionRequest $request, $id): JsonResponse
    {
        try {
            $activityData = $this->conditionService->getActivityData($id);
            $activityCondition = $request->except(['_token', '_method']);

            if (!$this->conditionService->update($activityCondition, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity conditions.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity conditions updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity conditions.']);
        }
    }
}
