<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Budget\BudgetRequest;
use App\IATI\Services\Activity\BudgetService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class BudgetController.
 */
class BudgetController extends Controller
{
    /**
     * @var BudgetService
     */
    protected BudgetService $budgetService;

    /**
     * BudgetController Constructor.
     *
     * @param BudgetService $budgetService
     */
    public function __construct(BudgetService $budgetService)
    {
        $this->budgetService = $budgetService;
    }

    /**
     * Renders budget edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('budget');
            $activity = $this->budgetService->getActivityData($id);
            $form = $this->budgetService->formGenerator($id);
            $data = [
                'core' => $element['criteria'] ?? false,
                'status' => $activity->budget_element_completed ?? false,
                'title' => $element['label'],
                'name' => 'budget',
            ];

            return view('admin.activity.budget.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while opening budget form.'
            );
        }
    }

    /**
     * Updates budget data.
     * @param BudgetRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(BudgetRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->budgetService->getActivityData($id);
            $activityBudget = $request->all();

            if (!$this->budgetService->update($activityBudget, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with(
                    'error',
                    'Error has occurred while updating budget.'
                );
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Budget updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while updating budget.'
            );
        }
    }
}
