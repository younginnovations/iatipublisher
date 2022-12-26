<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\CountryBudgetItem\CountryBudgetItemRequest;
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
     * @var CountryBudgetItemService
     */
    protected CountryBudgetItemService $countryBudgetItemService;

    /**
     * CountryBudgetItemController Constructor.
     *
     * @param CountryBudgetItemService $countryBudgetItemService
     */
    public function __construct(CountryBudgetItemService $countryBudgetItemService)
    {
        $this->countryBudgetItemService = $countryBudgetItemService;
    }

    /**
     * Renders country budget item edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('country_budget_items');
            $activity = $this->countryBudgetItemService->getActivityData($id);
            $form = $this->countryBudgetItemService->formGenerator($id);
            $data = [
                'title'  => $element['label'],
                'name'   => 'country_budget_items',
            ];

            return view('admin.activity.countryBudgetItem.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.rendering'), 'suffix'=>trans('elements_common.country_budget_form')]));
        }
    }

    /**
     * Updates country budget item data.
     *
     * @param CountryBudgetItemRequest $request
     * @param                          $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(CountryBudgetItemRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityCountryBudgetItem = $request->except(['_token', '_method']);

            if (!$this->countryBudgetItemService->update($id, $activityCountryBudgetItem)) {
                return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.country_budget_items')]));
            }

            return redirect()->route('admin.activity.show', $id)->with('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('responses.country_budget_items'), 'event'=>trans('events.updated')])));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.country_budget_items')]));
        }
    }
}
