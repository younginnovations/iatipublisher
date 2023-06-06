<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\RecipientRegion\RecipientRegionRequest;
use App\IATI\Services\Activity\RecipientRegionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use JsonException;

/**
 * Class RecipientRegionController.
 */
class RecipientRegionController extends Controller
{
    /**
     * @var RecipientRegionService
     */
    protected RecipientRegionService $recipientRegionService;

    /**
     * RecipientRegionController Constructor.
     *
     * @param RecipientRegionService $recipientRegionService
     */
    public function __construct(RecipientRegionService $recipientRegionService)
    {
        $this->recipientRegionService = $recipientRegionService;
    }

    /**
     * Renders recipient region edit form.
     *
     * @param int $id
     *
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $activity = $this->recipientRegionService->getActivityData($id);
            $element = $this->getRecipientRegionManipulatedElementSchema($activity);
            $form = $this->recipientRegionService->formGenerator($id, $element);
            $data = ['title' => $element['label'], 'name' => 'recipient_region'];

            return view('admin.activity.recipientRegion.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while opening recipient-region form.');
        }
    }

    /**
     * Updates recipient-region form.
     *
     * @param RecipientRegionRequest $request
     * @param $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function update(RecipientRegionRequest $request, $id): JsonResponse|RedirectResponse
    {
        try {
            if (!$this->recipientRegionService->update($id, $request->all())) {
                return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating recipient-region.');
            }

            return redirect()->route('admin.activity.show', $id)->with('success', 'Recipient-Region updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.show', $id)->with('error', 'Error has occurred while updating recipient-region.');
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
    public function getRecipientRegionManipulatedElementSchema($activity): array
    {
        $element = getElementSchema('recipient_region');

        if (count($activity->transactions)) {
            $recipient_region = $activity->transactions->pluck('transaction.recipient_region')->toArray();
            $recipient_country = $activity->transactions->pluck('transaction.recipient_country')->toArray();

            if (!is_array_value_empty($recipient_region) || !is_array_value_empty($recipient_country)) {
                $element['freeze'] = true;
                $element['info_text'] = 'Recipient Region is already added at transaction level. You can add a Recipient Region either at activity level or at transaction level but not at both.';
            }
        }

        return $element;
    }
}
