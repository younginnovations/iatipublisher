<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\IATI\Elements\Builder\DateFormCreator;
use App\IATI\Services\Activity\DateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class DateController.
 */
class DateController extends Controller
{
    /**
     * @var DateFormCreator
     */
    protected DateFormCreator $dateFormCreator;

    /**
     * @var DateService
     */
    protected DateService $dateService;

    /**
     * DateController Constructor.
     *
     * @param DateFormCreator $dateFormCreator
     * @param DateService $dateService
     */
    public function __construct(DateFormCreator $dateFormCreator, DateService $dateService)
    {
        $this->dateFormCreator = $dateFormCreator;
        $this->dateService = $dateService;
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id)
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->dateService->getActivityData($id);
            $model['activity_date'] = $this->dateService->getDateData($id);
            $this->dateFormCreator->url = route('admin.activities.date.update', [$id]);
            $form = $this->dateFormCreator->editForm($model, $element['activity_date']);

            return view('activity.date.date', compact('form', 'activity'));
        } catch (\Exception $e) {
            dd(logger()->error($e->getMessage()));
            logger()->error($e->getMessage());
        }
    }

    /**
     * @param $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $activityData = $this->dateService->getActivityData($id);
            $activityDate = $request->all();

            if (!$this->dateService->update($activityDate, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity date.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity date updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity date.']);
        }
    }
}
