<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Date\DateRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
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
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * @var DateService
     */
    protected DateService $dateService;

    /**
     * DateController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param DateService $dateService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, DateService $dateService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->dateService = $dateService;
    }

    /**
     * Render activity date edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id):View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->dateService->getActivityData($id);
            $model['activity_date'] = $this->dateService->getDateData($id);
            $this->parentCollectionFormCreator->url = route('admin.activities.date.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['activity_date']);

            return view('activity.date.date', compact('form', 'activity'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity date.');
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
            $messages = $this->validateData($request->get('activity_date'));

            if ($messages) {
                return response()->json(['success' => false, 'error' => array_unique($messages)]);
            }

            if (!$this->dateService->update($activityDate, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity date.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Activity date updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity date.');
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
        $hasStart = false;

        foreach ($activityDates as $activityDateIndex => $activityDate) {
            $blockIndex = $activityDateIndex + 1;
            $date = $activityDate['date'];
            $type = $activityDate['type'];

            if ($type == 2 || $type == 4) {
                (strtotime($date) <= strtotime(date('Y-m-d'))) ?: $messages[] = sprintf('Actual Start Date and Actual End Date must be Today or past days. (block %s)', $blockIndex);
            }

            if ($type == 4) {
                $actualStartDate = array_column(array_filter($activityDates, function ($date) {
                    return $date['type'] == 2;
                }), 'date');

                if (count($actualStartDate)) {
                    foreach ($actualStartDate as $startDate) {
                        strtotime($date) > strtotime($startDate) ?: $messages[] = sprintf('End date must be later than the start date. (Block %s)', $blockIndex);
                    }
                }
            }

            if ($type == 3) {
                $plannedStartDate = array_column(array_filter($activityDates, function ($date) {
                    return $date['type'] == 1;
                }), 'date');

                if (count($plannedStartDate)) {
                    foreach ($plannedStartDate as $startDate) {
                        strtotime($date) > strtotime($startDate) ?: $messages[] = sprintf('End date must be later than the start date. (Block %s)', $blockIndex);
                    }
                }
            }

            if ($type == 1 || $type == 2) {
                $hasStart = true;
            }
        }

        if (!$hasStart) {
            array_unshift($messages, 'Planned Start or Actual Start in Activity Date Type is required.');
        }

        return $messages;
    }
}
