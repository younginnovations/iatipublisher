<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\DefaultFormRequest;
use App\IATI\Services\Activity\ActivityDefaultService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class ActivityDefaultController.
 */
class ActivityDefaultController extends Controller
{
    /**
     * @var ActivityDefaultService
     */
    protected ActivityDefaultService $activityDefaultService;

    /**
     * ActivityDefaultController Constructor.
     *
     * @param ActivityDefaultService $activityDefaultService
     */
    public function __construct(ActivityDefaultService $activityDefaultService)
    {
        $this->activityDefaultService = $activityDefaultService;
    }

    /**
     * Activity default values edit form.
     *
     * @param $activityId
     *
     * @return View|RedirectResponse
     */
    public function edit($activityId): View|RedirectResponse
    {
        try {
            $currencies = getCodeListArray('Currency', 'OrganizationArray');
            $languages = getCodeList('Language', 'Organization');
            $humanitarian = trans('setting.humanitarian_types');
            $budgetNotProvided = getCodeList('BudgetNotProvided', 'Activity');

            return view(
                'admin.activity.defaultValue.edit',
                compact('currencies', 'languages', 'humanitarian', 'budgetNotProvided', 'activityId')
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $activityId)->with(
                'error',
                translateErrorHasOccurred('elements_common.default_values', 'rendering', 'form')
            );
        }
    }

    /**
     * Returns activity default values.
     *
     * @param $activityId
     *
     * @return JsonResponse
     */
    public function getActivityDefaultValues($activityId): JsonResponse
    {
        try {
            $setting = $this->activityDefaultService->getActivityDefaultValues($activityId);

            return response()->json(['success' => true, 'message' => translateElementSuccessfully('default_values', 'fetched'), 'data' => $setting]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => translateErrorHasOccurred('responses.the_data', 'fetching')]);
        }
    }

    /**
     * Update default data of activity.
     *
     * @param DefaultFormRequest $request
     * @param $activityId
     *
     * @return JsonResponse
     */
    public function update(DefaultFormRequest $request, $activityId): JsonResponse
    {
        try {
            DB::beginTransaction();

            $this->activityDefaultService->updateActivityDefaultValues($activityId, $request->all());

            DB::commit();

            return response()->json(['success' => true, 'message' => translateElementSuccessfully('activity_default_values', 'updated')]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' =>translateErrorHasOccurred('responses.the_data', 'updating')]);
        }
    }
}
