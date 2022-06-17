<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Identifier\IdentifierRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\ActivityIdentifierService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class IdentifierController.
 */
class IdentifierController extends Controller
{
    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var ActivityIdentifierService
     */
    protected ActivityIdentifierService $identifierService;

    /**
     * IdentifierController Constructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param ActivityIdentifierService $identifierService
     */
    public function __construct(BaseFormCreator $baseFormCreator, ActivityIdentifierService $identifierService)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->identifierService = $identifierService;
    }

    /**
     * Renders status edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->identifierService->getActivityData($id);
            $model['activity_identifier'] = $this->identifierService->getActivityIdentifierData($id);
            $this->baseFormCreator->url = route('admin.activities.identifier.update', [$id]);
            $form = $this->baseFormCreator->editForm($model['activity_identifier'], $element['activity-identifier']);

            return view('activity.identifier.identifier', compact('form', 'activity'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while rendering activity identifier form.']);
        }
    }

    /**
     * Updates identifier data.
     *
     * @param IdentifierRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(IdentifierRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->identifierService->getActivityData($id);
            $activityIdentifier = $request->except(['_method', '_token']);

            if (!$this->identifierService->update($activityIdentifier, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity identifier.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Activity identifier updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity identifier.']);
        }
    }
}
