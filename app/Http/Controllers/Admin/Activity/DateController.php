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
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('activity_date');
            $activity = $this->dateService->getActivityData($id);
            $form = $this->dateService->formGenerator($id);
            $data = [
                'title' => $element['label'],
                'name' => 'activity_date',
            ];

            return view('admin.activity.date.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)
                ->with('error', translateErrorHasOccurred('elements_common.activity_date', 'rendering', 'form'));
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
                return redirect()->route('admin.activity.show', $id)->with('error', translateErrorHasOccurred('elements_common.activity_date', 'updating'));
            }

            return redirect()->route('admin.activity.show', $id)->with('success', translateElementSuccessfully('activity_date', 'updated'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', translateErrorHasOccurred('elements_common.activity_date', 'updating'));
        }
    }
}
