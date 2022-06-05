<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Description\DescriptionRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Services\Activity\DescriptionService;
use Illuminate\Http\JsonResponse;

/**
 * Class DescriptionController.
 */
class DescriptionController extends Controller
{
    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * @var DescriptionService
     */
    protected DescriptionService $descriptionService;

    /**
     * DescriptionController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param DescriptionService $descriptionService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, DescriptionService $descriptionService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->descriptionService = $descriptionService;
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
            $activity = $this->descriptionService->getActivityData($id);
            $model['description'] = $this->descriptionService->getDescriptionData($id);
            $this->parentCollectionFormCreator->url = route('admin.activities.description.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['description']);

            return view('activity.description.description', compact('form', 'activity'));
        } catch (\Exception $e) {
            dd(logger()->error($e->getMessage()));
            logger()->error($e->getMessage());
        }
    }

    /**
     * @param DescriptionRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(DescriptionRequest $request, $id): JsonResponse
    {
        try {
            $activityData = $this->descriptionService->getActivityData($id);
            $activityDescription = $request->all();

            if (!$this->descriptionService->update($activityDescription, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity description.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity description updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity description.']);
        }
    }
}
