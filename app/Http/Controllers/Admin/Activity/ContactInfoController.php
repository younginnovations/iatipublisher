<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ContactInfo\ContactInfoRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\ContactInfoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class ContactInfoController
 *.
 */
class ContactInfoController extends Controller
{
    /**
     * @var MultilevelSubElementFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var ContactInfoService
     */
    protected ContactInfoService $contactInfoService;

    /**
     * ContactInfoControllerConstructor.
     *
     * @param BaseFormCreator $baseFormCreator
     * @param ContactInfoService $contactInfoService
     */
    public function __construct(ContactInfoService $contactInfoService, BaseFormCreator $baseFormCreator)
    {
        $this->baseFormCreator = $baseFormCreator;
        $this->contactInfoService = $contactInfoService;
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
            $activity = $this->contactInfoService->getActivityData($id);
            $model = $this->contactInfoService->getContactInfoData($id) ?: [];
            $this->baseFormCreator->url = route('admin.activities.contact-info.update', [$id]);
            $form = $this->baseFormCreator->editForm($model, $element['contact_info']);

            return view('activity.contactInfo.contactInfo', compact('form', 'activity'));
        } catch (\Exception $e) {
            dd($e);
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while rendering country budget item form.');
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
            $activityData = $this->contactInfoService->getActivityData($id);
            $activityCountryBudgetItem = $request->except(['_token', '_method']);

            if (!$this->contactInfoService->update($activityCountryBudgetItem, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating country budget item.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Country budget item updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating country budget item.');
        }
    }
}
