<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\RecipientCountry\RecipientCountryRequest;
use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Services\Activity\RecipientCountryService;
use Illuminate\Http\JsonResponse;

/**
 * Class RecipientCountryController.
 */
class RecipientCountryController extends Controller
{
    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * @var RecipientCountryService
     */
    protected RecipientCountryService $recipientCountryService;

    /**
     * RecipientCountryController Constructor.
     *
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param RecipientCountryService $recipientCountryService
     */
    public function __construct(ParentCollectionFormCreator $parentCollectionFormCreator, RecipientCountryService $recipientCountryService)
    {
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->recipientCountryService = $recipientCountryService;
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit(int $id)
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->recipientCountryService->getActivityData($id);
            $model['recipient_country'] = $this->recipientCountryService->getRecipientCountryData($id);
            $this->parentCollectionFormCreator->url = route('admin.activities.recipient-country.update', [$id]);
            $form = $this->parentCollectionFormCreator->editForm($model, $element['recipient-country']);

            return view('activity.recipientCountry.recipientCountry', compact('form', 'activity'));
        } catch (\Exception $e) {
            dd(logger()->error($e->getMessage()));
            logger()->error($e->getMessage());
        }
    }

    /**
     * @param RecipientCountryRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(RecipientCountryRequest $request, $id): JsonResponse
    {
        try {
            $activityData = $this->recipientCountryService->getActivityData($id);
            $activityRecipientCountry = $request->all();

            if (!$this->recipientCountryService->update($activityRecipientCountry, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity recipient country.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity recipient country updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity recipient country.']);
        }
    }
}
