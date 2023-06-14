<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\RecipientCountry\RecipientCountryRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\RecipientCountryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use JsonException;

/**
 * Class RecipientCountryController.
 */
class RecipientCountryController extends Controller
{
    /**
     * @var RecipientCountryService
     */
    protected RecipientCountryService $recipientCountryService;

    /**
     * For recipient region or country element json schema.
     *
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * RecipientCountryController Constructor.
     *
     * @param RecipientCountryService $recipientCountryService
     * @param ActivityService $activityService
     */
    public function __construct(RecipientCountryService $recipientCountryService, ActivityService $activityService)
    {
        $this->recipientCountryService = $recipientCountryService;
        $this->activityService = $activityService;
    }

    /**
     * Renders recipient country edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $activity = $this->recipientCountryService->getActivityData($id);
            $element = $this->activityService->getRecipientRegionOrCountryManipulatedElementSchema($activity, 'recipient_country');
            $form = $this->recipientCountryService->formGenerator($id, $element);
            $data = ['title' => $element['label'], 'name' => 'recipient_country'];

            return view('admin.activity.recipientCountry.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred_form', ['event'=>trans('events.opening'), 'suffix'=>trans('elements_common.recipient_country')]));
        }
    }

    /**
     * Update the recipient-country data.
     *
     * @param RecipientCountryRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(RecipientCountryRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            if (!$this->recipientCountryService->update($id, $request->all())) {
                return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.recipient_country')]));
            }

            return redirect()->route('admin.activity.show', $id)->with('success', ucfirst(trans('responses.event_successfully', ['prefix'=>trans('elements_common.recipient_country'), 'event'=>trans('events.updated')])));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', trans('responses.error_has_occurred', ['event'=>trans('events.updating'), 'suffix'=>trans('elements_common.recipient_country')]));
        }
    }

    /**
     * append freeze and info_text if recipient country or region exists in any one of the activity transactions
     * if exists then it freezes the section.
     *
     * @param $activity
     *
     * @throws JsonException
     *
     * @return array
     */
    public function getRecipientCountryManipulatedElementSchema($activity): array
    {
        $element = getElementSchema('recipient_country');

        if (count($activity->transactions)) {
            $recipient_region = $activity->transactions->pluck('transaction.recipient_region')->toArray();
            $recipient_country = $activity->transactions->pluck('transaction.recipient_country')->toArray();

            if (!is_array_value_empty($recipient_region) || !is_array_value_empty($recipient_country)) {
                $element['freeze'] = true;
                $element['info_text'] = 'Recipient Country is already added at transaction level. You can add a Recipient Country either at activity level or at transaction level but not at both.';
            }
        }

        return $element;
    }
}
