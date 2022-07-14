<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Indicator\IndicatorRequest;
use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\IndicatorService;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    /**
     * @var ResultElementFormCreator
     */
    protected ResultElementFormCreator $resultElementFormCreator;

    /**
     * @var IndicatorService
     */
    protected IndicatorService $indicatorService;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * IndicatorController Constructor.
     *
     * @param ResultElementFormCreator $resultElementFormCreator
     * @param IndicatorService $indicatorService
     * @param ActivityService $activityService
     */
    public function __construct(
        ResultElementFormCreator $resultElementFormCreator,
        IndicatorService $indicatorService,
        ActivityService $activityService
    ) {
        $this->resultElementFormCreator = $resultElementFormCreator;
        $this->indicatorService = $indicatorService;
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
     * @param $activityId
     * @param $resultId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function create($activityId, $resultId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($activityId);
            $this->resultElementFormCreator->url = route('admin.activities.result.indicator.store', [$activityId, $resultId]);
            $form = $this->resultElementFormCreator->editForm([], $element['indicator'], 'POST', '/activities/' . $activityId);
            $data = ['core' => $element['indicator']['criteria'] ?? false, 'status' => false, 'title' => $element['indicator']['label'], 'name' => 'indicator'];

            return view('activity.indicator.indicator', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rendering indicator form.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IndicatorRequest $request
     * @param $activityId
     * @param $resultId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $activityId, $resultId): \Illuminate\Http\RedirectResponse
    {
        try {
            $indicatorData = $request->except(['_token']);

            if (!$this->indicatorService->create([
                'result_id'     => $resultId,
                'indicator'     => $indicatorData,
            ])) {
                return redirect()->route('admin.activities.show', $activityId)->with(
                    'error',
                    'Error has occurred while creating result indicator.'
                );
            }

            return redirect()->route('admin.activities.show', $activityId)->with(
                'success',
                'Result indicator created successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while creating result indicator.'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IATI\Models\Activity\Indicator  $indicator
     * @return \Illuminate\Http\Response
     */
    public function show(Indicator $indicator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function edit($activityId, $resultId, $indicatorId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($activityId);
            $resultIndicator = $this->indicatorService->getResultIndicator($resultId, $indicatorId);
            $this->resultElementFormCreator->url = route('admin.activities.result.indicator.update', [$activityId, $resultId, $indicatorId]);
            $form = $this->resultElementFormCreator->editForm($resultIndicator->indicator, $element['indicator'], 'PUT', '/activities/' . $activityId);
            $data = ['core' => $element['indicator']['criteria'] ?? false, 'status' => false, 'title' => $element['indicator']['label'], 'name' => 'indicator'];

            return view('activity.indicator.indicator', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rendering indicator form.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IndicatorRequest $request
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(IndicatorRequest $request, $activityId, $resultId, $indicatorId): \Illuminate\Http\RedirectResponse
    {
        try {
            $indicatorData = $request->except(['_method', '_token']);
            $indicator = $this->indicatorService->getResultIndicator($resultId, $indicatorId);

            if (!$this->indicatorService->update([
                'result_id'     => $resultId,
                'indicator'     => $indicatorData,
            ], $indicator)) {
                return redirect()->route('admin.activities.show', $activityId)->with(
                    'error',
                    'Error has occurred while updating result indicator.'
                );
            }

            return redirect()->route('admin.activities.show', $activityId)->with(
                'success',
                'Indicator updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while updating indicator.'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IATI\Models\Activity\Indicator  $indicator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Indicator $indicator)
    {
        //
    }
}
