<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Description\DescriptionRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Services\Activity\DescriptionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

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
     * Renders description edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->descriptionService->getActivityData($id);
            $model['description'] = $this->descriptionService->getDescriptionData($id);
            $this->parentCollectionFormCreator->url = route('admin.activities.description.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['description'], 'PUT', '/activities/' . $id);
            $data = ['core' => $element['description']['criteria'] ?? '', 'status' => $activity->description_element_completed, 'title' => $element['description']['label'], 'name' => 'description'];

            return view('activity.description.description', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering activity description form.');
        }
    }

    /**
     * Updates description data.
     *
     * @param DescriptionRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(DescriptionRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->descriptionService->getActivityData($id);
            $activityDescription = $request->all();

            if (!$this->descriptionService->update($activityDescription, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating description.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Description updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating description.');
        }
    }
}
