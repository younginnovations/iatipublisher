<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ContactInfo\ContactInfoRequest;
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
     * @var ContactInfoService
     */
    protected ContactInfoService $contactInfoService;

    /**
     * ContactInfoControllerConstructor.
     *
     * @param ContactInfoService $contactInfoService
     */
    public function __construct(ContactInfoService $contactInfoService)
    {
        $this->contactInfoService = $contactInfoService;
    }

    /**
     * Renders country budget item edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('contact_info');
            $activity = $this->contactInfoService->getActivityData($id);
            $form = $this->contactInfoService->formGenerator($id);
            $data = [
                'title' => $element['label'],
                'name' => 'contact_info',
            ];

            return view('admin.activity.contactInfo.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.rendering'), 'suffix'=>trans('responses.contact_info_controller')]));
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
            $activityCountryBudgetItem = $request->except(['_token', '_method']);

            if (!$this->contactInfoService->update($id, $activityCountryBudgetItem)) {
                return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.contact_info')]));
            }

            return redirect()->route('admin.activity.show', $id)->with('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.contact_info'), 'event'=>trans('events.updated')])));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.contact-info')]));
        }
    }
}
