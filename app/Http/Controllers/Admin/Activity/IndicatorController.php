<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Indicator\IndicatorRequest;
use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\IndicatorService;
use App\IATI\Services\Activity\ResultService;
use Illuminate\Http\Request;

class IndicatorController extends Controller
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
     * @param ResultService $resultService
     * @param IndicatorService $indicatorService
     * @param ActivityService $activityService
     */
    public function __construct(
        ResultElementFormCreator $resultElementFormCreator,
        ResultService $resultService,
        IndicatorService $indicatorService,
        ActivityService $activityService
    ) {
        $this->resultElementFormCreator = $resultElementFormCreator;
        $this->indicatorService = $indicatorService;
        $this->resultService = $resultService;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($activityId, $resultId): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $indicators = $this->indicatorService->getResultIndicators($resultId);
            $types = getIndicatorTypes();

            return view('admin.activity.indicator.indicator', compact('activity', 'indicators', 'types'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rendering activity transactions listing.'
            );
        }
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
            $form = $this->resultElementFormCreator->editForm([], $element['indicator']);
            $data = ['core'=> $element['indicator']['criteria'] ?? false, 'status'=> false, 'title'=> $element['indicator']['label'], 'name'=>'indicator'];

            return view('activity.indicator.indicator', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rendering result indicator form.'
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
    public function show($activityId, $resultId, $indicatorId)
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $resultTitle = $this->resultService->getResult($resultId, $activityId)['result']['title'];
            $indicator = $this->indicatorService->getResultIndicator($resultId, $indicatorId);
            $types = getIndicatorTypes();

            return view('admin.activity.indicator.detail', compact('activity', 'resultTitle', 'indicator', 'types'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rending result detail page.'
            );
        }
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
            $form = $this->resultElementFormCreator->editForm($resultIndicator->indicator, $element['indicator'], 'PUT');
            $data = ['core'=> $element['indicator']['criteria'] ?? false, 'status'=> false, 'title'=> $element['indicator']['label'], 'name'=>'indicator'];

            return view('activity.indicator.indicator', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rendering result indicator form.'
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
                'Result indicator updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while updating result indicator.'
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
