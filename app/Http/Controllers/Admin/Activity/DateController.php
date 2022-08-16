<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Date\DateRequest;
use App\IATI\Services\Activity\DateService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class DateController.
 */
class DateController extends Controller
{
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->dateService->getActivityData($id);
            $form = $this->dateService->formGenerator($id);
            $data = [
                'core' => $element['activity_date']['criteria'] ?? '',
                'status' => $activity->activity_date_element_completed,
                'title' => $element['activity_date']['label'],
                'name' => 'activity_date',
            ];

            return view('admin.activity.date.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while rendering activity-date form.'
            );
        }
    }

    /**
     * Updates activity date data.
     *
     * @param $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(DateRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->dateService->getActivityData($id);
            $activityDate = $request->all();
            $messages = $this->validateData(array_values($request->get('activity_date')));

            if ($messages) {
                return redirect()->route('admin.activities.date.edit', $id)->with(
                    'error',
                    array_unique($messages)
                )->withInput();
            }

            if (!$this->dateService->update($activityDate, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with(
                    'error',
                    'Error has occurred while updating activity-date.'
                );
            }

            return redirect()->route('admin.activities.show', $id)->with(
                'success',
                'Activity-date updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while updating activity-date.'
            );
        }
    }

    /**
     * Validate activity date data based on Activity Date and Activity Date Type.
     * @param array $activityDates
     * @return array
     */
    private function validateData(array $activityDates): array
    {
        $messages = [];

        foreach ($activityDates as $activityDateIndex => $activityDate) {
            $blockIndex = $activityDateIndex + 1;
            $date = $activityDate['date'];
            $type = $activityDate['type'];

            if (isset($date) && isset($type)) {
                if ($type == 2 || $type == 4) {
                    (strtotime($date) <= strtotime(date('Y-m-d'))) ?: $messages[] = sprintf(
                        'Actual Start Date and Actual End Date must be Today or past days. (block %s)',
                        $blockIndex
                    );
                }

                if ($type == 4) {
                    $actualStartDate = array_column(
                        array_filter($activityDates, function ($date) {
                            return $date['type'] == 2;
                        }),
                        'date'
                    );

                    if (count($actualStartDate)) {
                        foreach ($actualStartDate as $startDate) {
                            strtotime($date) > strtotime($startDate) ?: $messages[] = sprintf(
                                'End date must be later than the start date. (Block %s)',
                                $blockIndex
                            );
                        }
                    }
                }

                if ($type == 3) {
                    $plannedStartDate = array_column(
                        array_filter($activityDates, function ($date) {
                            return $date['type'] == 1;
                        }),
                        'date'
                    );

                    if (count($plannedStartDate)) {
                        foreach ($plannedStartDate as $startDate) {
                            strtotime($date) > strtotime($startDate) ?: $messages[] = sprintf(
                                'End date must be later than the start date. (Block %s)',
                                $blockIndex
                            );
                        }
                    }
                }
            }
        }

        return $messages;
    }
}
