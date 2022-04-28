<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\IATI\Models\Activity\Activity;
use App\IATI\Services\Activity\ActivityService;
use Illuminate\Http\Request;

/**
 * Class ActivityController.
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function store(Request $request): void
    {
        //
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
