<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\OtherIdentifier\OtherIdentifierRequest;
use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
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
     * @var MultilevelSubElementFormCreator
     */
    protected MultilevelSubElementFormCreator $multilevelSubElementFormCreator;

    /**
     * @var otherIdentifierService
     */
    protected OtherIdentifierService $otherIdentifierService;

    /**
     * OtherIdentifierController Constructor.
     *
     * @param MultilevelSubElementFormCreator $multilevelSubElementFormCreator
     * @param otherIdentifierService $otherIdentifierService
     */
    public function __construct(MultilevelSubElementFormCreator $multilevelSubElementFormCreator, OtherIdentifierService $otherIdentifierService)
    {
        $this->multilevelSubElementFormCreator = $multilevelSubElementFormCreator;
        $this->otherIdentifierService = $otherIdentifierService;
    }

    /**
     * Renders condition edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id):View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->otherIdentifierService->getActivityData($id);
            $model = $this->otherIdentifierService->getOtherIdentifierData($id) ?: [];
            $this->multilevelSubElementFormCreator->url = route('admin.activities.other-identifier.update', [$id]);
            $form = $this->multilevelSubElementFormCreator->editForm($model, $element['other_identifier']);

            return view('activity.otherIdentifier.other_identifier', compact('form', 'activity'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening activity other identifier edit form.');
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
            $activityCondition = $request->except(['_token', '_method']);

            if (!$this->otherIdentifierService->update($activityCondition, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity condition.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Activity condition updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating activity condition.');
        }
    }
}
