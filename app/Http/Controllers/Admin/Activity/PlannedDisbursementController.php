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
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('planned_disbursement');
            $activity = $this->plannedDisbursementService->getActivityData($id);
            $form = $this->plannedDisbursementService->formGenerator($id);
            $data = ['title' => $element['label'], 'name' => 'planned_disbursement'];

            return view('admin.activity.plannedDisbursement.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.rendering'), 'suffix'=>trans('elements_common.planned_disbursement')]));
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
            if (!$this->plannedDisbursementService->update($id, $request->except(['_token', '_method']))) {
                return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.planned_disbursement')]));
            }

            return redirect()->route('admin.activity.show', $id)->with('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.planned_disbursement'), 'event'=>trans('events.updated')])));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.planned_disbursement')]));
        }
    }
}
