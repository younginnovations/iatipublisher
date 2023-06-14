<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\ElementCompleteService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

/**
 * Class ActivityController.
 */
class ActivityController extends Controller
{
    /**
     * @var ActivityService
     */
    private ActivityService $activityService;

    /**
     * @var ElementCompleteService
     */
    private ElementCompleteService $elementCompleteService;

    /**
     * @param ActivityService $activityService
     * @param ElementCompleteService $elementCompleteService
     */
    public function __construct(ActivityService $activityService, ElementCompleteService $elementCompleteService)
    {
        $this->activityService = $activityService;
        $this->elementCompleteService = $elementCompleteService;
    }

    /**
     * Deletes activity element.
     *
     * @param $id
     * @param $element
     *
     * @return Response|Application|ResponseFactory
     */
    public function deleteElement($id, $element): Response|Application|ResponseFactory
    {
        try {
            if (!$this->activityService->deleteElement($id, $element)) {
                return response(['status' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.deleting'), 'suffix'=>trans('responses.activity_element')])]);
            }

            if ($element === 'recipient_country' || $element === 'recipient_region') {
                $this->elementCompleteService->refreshElementStatus($this->activityService->getActivity($id));
            }

            $message = ucfirst(trans('responses.event_successfully', ['prefix'=> trans('elements_common.' . $element), 'event'=>trans('events.deleted')]));
            Session::put('success', $message);

            return response(['status' => true, 'message' => $message]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response(['status' => false, 'message' => trans('responses.error_has_occurred', ['event'=>trans('events.deleting'), 'suffix'=>trans('responses.activity_element')])]);
        }
    }
}
