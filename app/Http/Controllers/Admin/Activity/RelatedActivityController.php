<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\RelatedActivity\RelatedActivityRequest;
use App\IATI\Services\Activity\RelatedActivityService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->relatedActivityService->getActivityData($id);
            $model['related_activity'] = $this->relatedActivityService->getRelatedActivityData($id);
            $this->baseFormCreator->url = route('admin.activities.related-activity.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['related_activity'], 'PUT', '/activities/' . $id);
            $data = ['core' => $element['related_activity']['criteria'] ?? '', 'status' => $activity->related_activity_element_completed, 'title' => $element['related_activity']['label'], 'name' => 'related_activity'];

            return view('admin.activity.relatedActivity.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening related-activity form.');
        }
    }

    /**
     * Updates related-activity data.
     * @param RelatedActivityRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(RelatedActivityRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->relatedActivityService->getActivityData($id);
            $activityRelatedActivity = $request->all();

            if (!$this->relatedActivityService->update($activityRelatedActivity, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating related-activity.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Related-activity updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating related-activity.');
        }
    }
}
