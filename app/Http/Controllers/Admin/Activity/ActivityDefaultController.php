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
     * @param $id
     *
     * @return View|RedirectResponse
     */
    public function edit($activityId): View|RedirectResponse
    {
        try {
            $currencies = getCodeList('Currency', 'Organization', filterDeprecated: true);
            $languages = getCodeList('Language', 'Organization', filterDeprecated: true);
            $humanitarian = trans('setting.humanitarian_types');
            $budgetNotProvided = getCodeList('BudgetNotProvided', 'Activity', filterDeprecated: true);

            return view(
                'admin.activity.defaultValue.edit',
                compact('currencies', 'languages', 'humanitarian', 'budgetNotProvided', 'activityId')
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $activityId)->with(
                'error',
                'Error has occurred while rendering default values form.'
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

            return response()->json(['success' => true, 'message' => 'Default values fetched successfully', 'data' => $setting]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
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

            return response()->json(['success' => true, 'message' => 'Activity default values updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while updating data']);
        }
    }
}
