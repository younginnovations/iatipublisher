<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\RecipientRegion\RecipientRegionRequest;
use App\IATI\Services\Activity\RecipientRegionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->recipientRegionService->getActivityData($id);
            $form = $this->recipientRegionService->formGenerator($id);
            $data = ['core' => $element['recipient_region']['criteria'] ?? '', 'title' => $element['recipient_region']['label'], 'name' => 'recipient_region'];

            return view('admin.activity.recipientRegion.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while opening recipient-region form.');
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
            $activityData = $this->recipientRegionService->getActivityData($id);
            $activityRecipientRegion = $request->all();

            if (!$this->recipientRegionService->update($activityRecipientRegion, $activityData)) {
                return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating recipient-region.');
            }

            return redirect()->route('admin.activities.show', $id)->with('success', 'Recipient-Region updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with('error', 'Error has occurred while updating recipient-region.');
        }
    }
}
