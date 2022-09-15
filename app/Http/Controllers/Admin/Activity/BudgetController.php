<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Budget\BudgetRequest;
use App\IATI\Services\Activity\ActivityService;
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
     * @var ActivityService
     */
    private ActivityService $activityService;

    /**
     * BudgetController Constructor.
     *
     * @param BudgetService   $budgetService
     * @param ActivityService $activityService
     */
    public function __construct(BudgetService $budgetService, ActivityService $activityService)
    {
        $this->budgetService = $budgetService;
        $this->activityService = $activityService;
    }

    /**
     * Renders budget edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('budget');
            $activity = $this->activityService->getActivity($id);
            $form = $this->budgetService->formGenerator($id);
            $data = [
                'title'  => $element['label'],
                'name'   => 'budget',
            ];

            return view('admin.activity.budget.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while opening budget form.');
        }
    }

    /**
     * Updates budget data.
     *
     * @param BudgetRequest $request
     * @param               $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(BudgetRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityBudget = $request->all();

            if (!$this->budgetService->update($id, $activityBudget)) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating budget.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Budget updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating budget.');
        }
    }
}
