<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\OtherIdentifier\OtherIdentifierRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Services\Activity\OtherIdentifierService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class OtherIdentifierController.
 */
class OtherIdentifierController extends Controller
{
    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * @var otherIdentifierService
     */
    protected OtherIdentifierService $otherIdentifierService;

    /**
     * OtherIdentifierController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param otherIdentifierService $otherIdentifierService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, OtherIdentifierService $otherIdentifierService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->otherIdentifierService = $otherIdentifierService;
    }

    /**
     * Renders condition edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->otherIdentifierService->getActivityData($id);
            $model['other_identifier'] = $this->otherIdentifierService->getOtherIdentifierData($id) ?: [];
            $this->parentCollectionFormCreator->url = route('admin.activities.other-identifier.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['other_identifier'], 'PUT', '/activities/' . $id);
            $data = ['core' => $element['other_identifier']['criteria'], 'status' => $activity->other_identifier_element_completed, 'title' => $element['other_identifier']['label'], 'name' => 'other_identifier'];

            return view('activity.otherIdentifier.other_identifier', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening other-identifier edit form.');
        }
    }

    /**
     * Updates condition data.
     *
     * @param OtherIdentifierRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(OtherIdentifierRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->otherIdentifierService->getActivityData($id);
            $activityCondition = $request->get('other_identifier');

            if (!$this->otherIdentifierService->update($activityCondition, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating other-identifier.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Other-identifier updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating other-identifier.');
        }
    }
}
