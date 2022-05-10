<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ActivityCreateRequest;
use App\IATI\Services\Activity\ActivityService;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
     * @var DatabaseManager
     */
    protected $db;

    /**
     * ActivityController Constructor.
     * @param ActivityService $activityService
     */
    public function __construct(ActivityService $activityService, DatabaseManager $db)
    {
        $this->activityService = $activityService;
        $this->db = $db;
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
            $organization = Auth::user()->organization;

            return response()->json([
                'success' => true, 'message' => 'Languages fetched successfully',
                'data' => [
                    'languages' => $languages,
                    'organization' => $organization,
                ],
            ]);
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

            $this->db->beginTransaction();
            $activity = $this->activityService->store($input);
            $this->db->commit();

            return response()->json(['success' => true, 'message' => 'Activity created successfully.', 'data' => $activity]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while saving activity.']);
        }
    }
}
