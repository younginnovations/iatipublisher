<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\CountryBudgetItem\CountryBudgetItemRequest;
use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Services\Activity\CountryBudgetItemService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class CountryBudgetItemController.
 */
class CountryBudgetItemController extends Controller
{
    /**
     * @var MultilevelSubElementFormCreator
     */
    protected MultilevelSubElementFormCreator $multilevelSubElementFormCreator;

    /**
     * @var CountryBudgetItemService
     */
    protected CountryBudgetItemService $countryBudgetItemService;

    /**
     * CountryBudgetItemController Constructor.
     *
     * @param MultilevelSubElementFormCreator $multilevelSubElementFormCreator
     * @param CountryBudgetItemService $countryBudgetItemService
     */
    public function __construct(MultilevelSubElementFormCreator $multilevelSubElementFormCreator, CountryBudgetItemService $countryBudgetItemService)
    {
        $this->multilevelSubElementFormCreator = $multilevelSubElementFormCreator;
        $this->countryBudgetItemService = $countryBudgetItemService;
    }

    /**
     * Renders country budget item edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id):View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->countryBudgetItemService->getActivityData($id);
            $model = $this->countryBudgetItemService->getCountryBudgetItemData($id) ?: [];
            $this->multilevelSubElementFormCreator->url = route('admin.activities.country-budget-items.update', [$id]);
            $form = $this->multilevelSubElementFormCreator->editForm($model, $element['country-budget-items']);

            return view('activity.countryBudgetItem.countryBudgetItem', compact('form', 'activity'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering country budget item form.');
        }
    }

    /**
     * Updates country budget item data.
     *
     * @param CountryBudgetItemRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(CountryBudgetItemRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->countryBudgetItemService->getActivityData($id);
            $activityCountryBudgetItem = $request->except(['_token', '_method']);

            if (!$this->countryBudgetItemService->update($activityCountryBudgetItem, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating country budget item.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Country budget item updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating country budget item.');
        }
    }
}
