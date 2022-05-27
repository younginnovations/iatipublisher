<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\IATI\Elements\Builder\DescriptionFormCreator;
use App\IATI\Services\Activity\DescriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class DescriptionController.
 */
class DescriptionController extends Controller
{
    /**
     * @var DescriptionFormCreator
     */
    protected DescriptionFormCreator $descriptionFormCreator;

    /**
     * @var DescriptionService
     */
    protected DescriptionService $descriptionService;

    /**
     * DescriptionController Constructor.
     *
     * @param DescriptionFormCreator $descriptionFormCreator
     * @param DescriptionService $descriptionService
     */
    public function __construct(DescriptionFormCreator $descriptionFormCreator, DescriptionService $descriptionService)
    {
        $this->descriptionFormCreator = $descriptionFormCreator;
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
            $model['description'] = $this->descriptionService->getDescriptionData($id);
            $this->descriptionFormCreator->url = route('admin.activities.description.update', [$id]);
            $form = $this->descriptionFormCreator->editForm($model, $element['description']);

            return view('activity.description.description', compact('form'));
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
    public function update(Request $request, $id): JsonResponse
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
