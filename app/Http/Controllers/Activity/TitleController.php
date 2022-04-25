<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\IATI\Services\Activity\FormCreator\Title;
use App\IATI\Services\Activity\TitleService;
use Illuminate\Http\Request;

/**
 * Class TitleController.
 */
class TitleController extends Controller
{
    /**
     * @var Title
     */
    protected Title $title;

    /**
     * @var TitleService
     */
    protected TitleService $titleService;

    /**
     * TitleController Constructor.
     * @param Title $title
     */
    public function __construct(Title $title, TitleService $titleService)
    {
        $this->title = $title;
        $this->titleService = $titleService;
    }

    /**
     * Display a listing of the resource.
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $activityTitle = $this->titleService->getTitleData($id);
        $form = $this->title->editForm($activityTitle, $id);

        return view('activity.title.title', compact('form'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IATI\Models\Activity\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IATI\Models\Activity\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IATI\Models\Activity\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $activityData = $this->titleService->getActivityData($id);
            $activityTitle = $request->all();

            if (!$this->titleService->update($activityTitle, $activityData)) {
                return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity title.']);
            }

            return response()->json(['success' => true, 'message' => 'Activity title updated successfully.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while updating activity title.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IATI\Models\Activity\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
