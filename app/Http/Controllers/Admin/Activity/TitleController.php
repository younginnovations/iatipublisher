<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Title\TitleRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\TitleService;
use Illuminate\Http\JsonResponse;

/**
 * Class TitleController.
 */
class TitleController extends Controller
{
    protected BaseFormCreator $baseFormCreator;

    protected TitleService $titleService;

    /**
     * TitleController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param TitleService    $titleService
     */
    public function __construct(BaseFormCreator $baseFormCreator, TitleService $titleService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->titleService = $titleService;
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
            $activity = $this->titleService->getActivityData($id);
            $model['narrative'] = $this->titleService->getTitleData($id);
            $this->baseFormCreator->url = route('admin.activities.title.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['title']);

            return view('activity.title.title', compact('form', 'activity'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            logger()->error($e->getMessage());
        }
    }

    /**
     * @param TitleRequest $request
     * @param              $id
     *
     * @return JsonResponse
     */
    public function update(TitleRequest $request, $id): JsonResponse
    {
        try {
            $activityData = $this->titleService->getActivityData($id);
            $activityTitle = $request->all();

            if (!$this->titleService->update($activityTitle, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity title.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity title updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity title.']);
        }
    }
}
