<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ActivityCreateRequest;
use App\IATI\Models\Activity\Activity;
use App\IATI\Services\Activity\ActivityService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ActivityController.
 */
class ActivityController extends Controller
{
    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $db;

    /**
     * ActivityController Constructor.
     * @param ActivityService $activityService
     */
    public function __construct(ActivityService $activityService, DatabaseManager $db)
    {
        $this->activityService = $activityService;
        $this->db = $db;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View|JsonResponse
    {
        try {
            $languages = getCodeListArray('Languages', 'ActivityArray');

            return view('admin.activity.index', compact('languages'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while fetching activities.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create(): void
    {
        //
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
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while saving activity.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Activity $activity
     *
     * @return View
     */
    public function show(Activity $activity): View|JsonResponse
    {
        try {
            $elements = json_decode(file_get_contents(app_path('Data/Activity/Element.json')), true);
            $elementGroups = json_decode(file_get_contents(app_path('Data/Activity/ElementGroup.json')), true);
            $progress = 75;

            return view('admin.activity.show', compact('elements', 'elementGroups', 'progress', 'activity'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Activity $activity
     *
     * @return void
     */
    public function edit(Activity $activity): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Activity $activity
     *
     * @return void
     */
    public function update(Request $request, Activity $activity): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Activity $activity
     *
     * @return void
     */
    public function destroy(Activity $activity): void
    {
        //
    }

    /*
     * Get activities of the corresponding organization
     *
     * @return JsonResponse
     */
    public function getActivities($page = 1): JsonResponse
    {
        try {
            $activities = $this->activityService->getPaginatedActivities($page);

            return response()->json(['success' => true, 'message' => 'Activities fetched successfully', 'data' => $activities]);
        } catch (Exgitception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
        }
    }

    /*
    * Get languages
    *
    * @return JsonResponse
    */
    public function getLanguagesOrganization(): JsonResponse
    {
        try {
            $languages = getCodeListArray('Languages', 'ActivityArray');
            $organization = Auth::user()->organization;

            return response()->json([
                'success' => true, 'message' => 'Languages fetched successfully',
                'data' => [
                    'languages' => $languages,
                    'organization' => $organization,
                ],
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
        }
    }
}
