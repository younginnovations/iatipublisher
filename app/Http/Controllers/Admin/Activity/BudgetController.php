<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Budget\BudgetRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
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
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * @var BudgetService
     */
    protected BudgetService $budgetService;

    /**
     * BudgetController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param BudgetService $budgetService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, BudgetService $budgetService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->budgetService = $budgetService;
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->budgetService->getActivityData($id);
            $model['budget'] = $this->budgetService->getBudgetData($id);
            $this->parentCollectionFormCreator->url = route('admin.activities.budget.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['budget']);

            return view('activity.budget.budget', compact('form', 'activity'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening budget form.');
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
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating budget.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Budget updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating budget.');
        }
    }
}
