<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\DocumentLink\ContactInfoRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Services\Activity\DocumentLinkService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class DocumentLinkController
 *.
 */
class DocumentLinkController extends Controller
{
    /**
     * @var MultilevelSubElementFormCreator
     */
    protected MultilevelSubElementFormCreator $multilevelSubElementFormCreator;
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var DocumentLinkService
     */
    protected DocumentLinkService $documentLinkService;

    /**
     * DocumentLinkControllerConstructor.
     *
     * @param MultilevelSubElementFormCreator $multilevelSubElementFormCreator
     * @param DocumentLinkService $documentLinkService
     */
    public function __construct(MultilevelSubElementFormCreator $multilevelSubElementFormCreator, DocumentLinkService $documentLinkService, BaseFormCreator $baseFormCreator)
    {
        $this->multilevelSubElementFormCreator = $multilevelSubElementFormCreator;
        $this->baseFormCreator = $baseFormCreator;
        $this->documentLinkService = $documentLinkService;
    }

    /**
     * Renders country budget item edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id):View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->documentLinkService->getActivityData($id);
            $model = $this->documentLinkService->getDocumentLinkData($id) ?: [];
            $this->baseFormCreator->url = route('admin.activities.contact-info.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['contact-info']);

            return view('activity.contactInfo.contactInfo', compact('form', 'activity'));
        } catch (\Exception $e) {
            dd($e);
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering contact info form.');
        }
    }

    /**
     * Updates country budget item data.
     *
     * @param ContactInfoRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(ContactInfoRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            $activityData = $this->documentLinkService->getActivityData($id);
            $activityCountryBudgetItem = $request->except(['_token', '_method']);

            if (!$this->documentLinkService->update($activityCountryBudgetItem, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating contact info.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'contact info updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating contact info.');
        }
    }
}
