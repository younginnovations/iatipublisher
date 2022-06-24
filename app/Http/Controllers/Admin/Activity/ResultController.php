<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Result\ResultRequest;
use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Models\Activity\Result;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\ResultService;

/**
 * Class ResultController.
 */
class ResultController extends Controller
{
    /**
     * @var ResultElementFormCreator
     */
    protected ResultElementFormCreator $resultElementFormCreator;

    /**
     * @var ResultService
     */
    protected ResultService $resultService;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * ResultController Constructor.
     *
     * @param ResultElementFormCreator $resultElementFormCreator
     * @param ResultService $resultService
     * @param ActivityService $activityService
     */
    public function __construct(
        ResultElementFormCreator $resultElementFormCreator,
        ResultService $resultService,
        ActivityService $activityService
    ) {
        $this->resultElementFormCreator = $resultElementFormCreator;
        $this->resultService = $resultService;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function create($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($id);
            $this->resultElementFormCreator->url = route('admin.activities.results.store', $id);
            $form = $this->resultElementFormCreator->editForm([], $element['result']);

            return view('activity.result.result', compact('form', 'activity'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $id)->with(
                'error',
                'Error has occurred while rendering activity result form.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ResultRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ResultRequest $request, $activityId): \Illuminate\Http\RedirectResponse
    {
        try {
            $resultData = $request->except(['_token']);

            if (!$this->resultService->create([
                'activity_id' => $activityId,
                'result'      => $resultData,
            ])) {
                return redirect()->route('admin.activities.show', $activityId)->with(
                    'error',
                    'Error has occurred while creating activity result.'
                );
            }

            return redirect()->route('admin.activities.show', $activityId)->with(
                'success',
                'Activity result created successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while creating activity result.'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\IATI\Models\Activity\Result $result
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $activityId
     * @param $resultId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(
        $activityId,
        $resultId
    ): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($activityId);
            $activityResult = $this->resultService->getResult($resultId, $activityId);
            $this->resultElementFormCreator->url = route('admin.activities.results.update', [$activityId, $resultId]);
            $form = $this->resultElementFormCreator->editForm($activityResult->result, $element['result'], 'PUT');

            return view('activity.result.result', compact('form', 'activity'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rendering activity result form.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $activityId
     * @param $resultId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ResultRequest $request, $activityId, $resultId): \Illuminate\Http\RedirectResponse
    {
        try {
            $resultData = $request->except(['_method', '_token']);
            $result = $this->resultService->getResult($resultId, $activityId);

            if (!$this->resultService->update([
                'activity_id' => $activityId,
                'result'      => $resultData,
            ], $result)) {
                return redirect()->route('admin.activities.show', $activityId)->with(
                    'error',
                    'Error has occurred while updating activity result.'
                );
            }

            return redirect()->route('admin.activities.show', $activityId)->with(
                'success',
                'Activity result updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while updating activity result.'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\IATI\Models\Activity\Result $result
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }
}
