<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Date\DateRequest;
use App\IATI\Services\Activity\DateService;
use App\IATI\Traits\EditFormTrait;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;

/**
 * Class DateController.
 */
class DateController extends Controller
{
    use EditFormTrait;

    /**
     * @var DateService
     */
    protected DateService $dateService;

    /**
     * DateController Constructor.
     *
     * @param DateService $dateService
     */
    public function __construct(DateService $dateService)
    {
        $this->dateService = $dateService;
    }

    /**
     * Render activity date edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('activity_date');
            $activity = $this->dateService->getActivityData($id);
            $deprecationStatusMap = Arr::get($activity->deprecation_status_map, 'activity_date', []);
            $form = $this->dateService->formGenerator(
                id                        : $id,
                activityDefaultFieldValues: $activity->default_field_values ?? [],
                deprecationStatusMap      : $deprecationStatusMap
            );

            $hasData = (bool) Arr::get($activity, 'activity_date', false);
            $formHeader = $this->getFormHeader(
                hasData    : $hasData,
                elementName: 'activity_date',
                parentTitle: Arr::get($activity, 'title.0.narrative', 'Untitled')
            );
            $breadCrumbInfo = $this->basicBreadCrumbInfo($activity, 'activity_date');

            $data = [
                'title'            => $element['label'],
                'name'             => 'activity_date',
                'form_header'      => $formHeader,
                'bread_crumb_info' => $breadCrumbInfo,
            ];

            return view('admin.activity.date.edit', compact('form', 'activity', 'data'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with(
                'error',
                'Error has occurred while rendering activity-date form.'
            );
        }
    }

    /**
     * Updates activity date data.
     *
     * @param DateRequest $request
     * @param             $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(DateRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityDate = $request->all();

            if (!$this->dateService->update($id, $activityDate)) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating activity-date.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Activity-date updated successfully.');
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating activity-date.');
        }
    }
}
