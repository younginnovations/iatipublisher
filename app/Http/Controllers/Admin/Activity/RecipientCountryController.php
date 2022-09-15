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
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = getElementSchema('recipient_country');
            $activity = $this->recipientCountryService->getActivityData($id);
            $form = $this->recipientCountryService->formGenerator($id);
            $data = ['core' => $element['recipient_country']['criteria'] ?? '', 'title' => $element['label'], 'name' => 'recipient_country'];

            return view('admin.activity.recipientCountry.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while opening recipient-country form.');
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
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating recipient-country.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Recipient-country updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating recipient-country.');
        }
    }
}
