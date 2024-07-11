<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\RelatedActivity\RelatedActivityRequest;
use App\IATI\Services\Activity\RelatedActivityService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;

/**
 * Class RelatedActivityController.
 */
class RelatedActivityController extends Controller
{
    /**
     * @var RelatedActivityService
     */
    protected RelatedActivityService $relatedActivityService;

    /**
     * RelatedActivityController Constructor.
     *
     * @param RelatedActivityService $relatedActivityService
     */
    public function __construct(RelatedActivityService $relatedActivityService)
    {
        $this->relatedActivityService = $relatedActivityService;
    }

    /**
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('related_activity');
            $activity = $this->relatedActivityService->getActivityData($id);
            $deprecationStatusMap = Arr::get($activity->deprecation_status_map, 'related_activity', []);
            $form = $this->relatedActivityService->formGenerator($id, deprecationStatusMap: $deprecationStatusMap);
            $data = ['title' => $element['label'], 'name' => 'related_activity'];

            return view('admin.activity.relatedActivity.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while opening related-activity form.');
        }
    }

    /**
     * Updates related-activity data.
     *
     * @param RelatedActivityRequest $request
     * @param                        $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(RelatedActivityRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            if (!$this->relatedActivityService->update($id, $request->all())) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating related-activity.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Related-activity updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating related-activity.');
        }
    }
}
