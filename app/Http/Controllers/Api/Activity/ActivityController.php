<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ActivityCreateRequest;
use App\IATI\Services\Activity\ActivityService;
use Illuminate\Http\JsonResponse;

/**
 * Class SettingController.
 */
class ActivityController extends Controller
{
    /**
     * @var ActivityService
     */
    protected $activityService;

    /**
     * ActivityController Constructor.
     * @param ActivityService $activityService
     */
    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    /*
     * Get activities of the corresponding organization
     *
     * @return JsonResponse
     */
    public function getActivities($page): JsonResponse
    {
        try {
            $activities = $this->activityService->getPaginatedActivities($page);

            return response()->json(['success' => true, 'message' => 'Activities fetched successfully', 'data' => $activities]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
        }
    }

    /*
    * Get languages
    *
    * @return JsonResponse
    */
    public function getLanguages(): JsonResponse
    {
        try {
            $languages = getCodeListArray('Languages', 'ActivityArray', false);

            return response()->json(['success' => true, 'message' => 'Languages fetched successfully', 'data' => $languages]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
        }
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return JsonResponse
     */
    public function store(ActivityCreateRequest $request): JsonResponse
    {
        try {
            $input = $request->all();

            if (!$this->activityService->store($input)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while saving activity.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity created successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while saving activity.']);
        }
    }
}
