<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\RecipientCountry\RecipientCountryRequest;
use App\IATI\Services\Activity\RecipientCountryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

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
     * RecipientCountryController Constructor.
     *
     * @param RecipientCountryService $recipientCountryService
     */
    public function __construct(RecipientCountryService $recipientCountryService)
    {
        $this->recipientCountryService = $recipientCountryService;
    }

    /**
     * Renders recipient country edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->recipientCountryService->getActivityData($id);
            $form = $this->recipientCountryService->formGenerator($id);
            $data = ['core' => $element['recipient_country']['criteria'] ?? '', 'title' => $element['recipient_country']['label'], 'name' => 'recipient_country'];

            return view('admin.activity.recipientCountry.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening recipient-country form.');
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
            $activityData = $this->recipientCountryService->getActivityData($id);
            $activityRecipientCountry = $request->all();

            if (!$this->recipientCountryService->update($activityRecipientCountry, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating recipient-country.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Recipient-country updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating recipient-country.');
        }
    }
}
