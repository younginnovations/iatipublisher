<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\PlannedDisbursement\PlannedDisbursementRequest;
use App\IATI\Services\Activity\PlannedDisbursementService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class PlannedDisbursementController
 *.
 */
class PlannedDisbursementController extends Controller
{
    /**
     * @var PlannedDisbursementService
     */
    protected PlannedDisbursementService $plannedDisbursementService;

    /**
     * PlannedDisbursementController Constructor.
     *
     * @param PlannedDisbursementService $plannedDisbursementService
     */
    public function __construct(PlannedDisbursementService $plannedDisbursementService)
    {
        $this->plannedDisbursementService = $plannedDisbursementService;
    }

    /**
     * Renders country budget item edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('planned_disbursement');
            $activity = $this->plannedDisbursementService->getActivityData($id);
            $form = $this->plannedDisbursementService->formGenerator($id);
            $data = [
                'core' => $element['criteria'] ?? 'core',
                'status' => true,
                'title' => $element['label'],
                'name' => 'title',
            ];

            return view('admin.activity.plannedDisbursement.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while rendering planned-disbursement form.'
            );
        }
    }

    /**
     * Updates planned disbursement data.
     *
     * @param PlannedDisbursementRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(PlannedDisbursementRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->plannedDisbursementService->getActivityData($id);
            $activityCountryBudgetItem = $request->except(['_token', '_method']);

            if (!$this->plannedDisbursementService->update($activityCountryBudgetItem, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with(
                    'error',
                    'Error has occurred while updating planned-disbursement.'
                );
            }

            return redirect()->route('admin.activities.show', $id)->with(
                'success',
                'Planned-disbursement updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while updating planned-disbursement.'
            );
        }
    }
}
