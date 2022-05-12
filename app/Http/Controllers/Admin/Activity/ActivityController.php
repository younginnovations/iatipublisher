<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\IATI\Models\Activity\Activity;
use App\IATI\Requests\ActivityCreateRequest;
use App\IATI\Services\Activity\ActivityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * ActivityController Constructor.
     * @param ActivityService $activityService
     */
    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('admin.activity.activities');
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

    /**
     * Stores activity in activity table.
     * @param ActivityCreateRequest $request
     * @return JsonResponse
     */
    public function store(ActivityCreateRequest $request) : JsonResponse
    {
        try {
            $input = $request->all();

            if (!$this->activityService->store($input, auth()->user()->organization->id)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while saving activity.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity created successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while saving activity.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IATI\Models\Activity\Activity  $activity
     * @return void
     */
    public function show(Activity $activity): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IATI\Models\Activity\Activity  $activity
     * @return void
     */
    public function edit(Activity $activity): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IATI\Models\Activity\Activity  $activity
     * @return void
     */
    public function update(Request $request, Activity $activity): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IATI\Models\Activity\Activity  $activity
     * @return void
     */
    public function destroy(Activity $activity): void
    {
        //
    }
}
