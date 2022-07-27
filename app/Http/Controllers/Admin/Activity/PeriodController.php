<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Period\PeriodRequest;
use App\IATI\Elements\Builder\ResultElementFormCreator;
use App\IATI\Models\Activity\Period;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\IndicatorService;
use App\IATI\Services\Activity\PeriodService;
use App\IATI\Services\Activity\ResultService;

class PeriodController extends Controller
{
    /**
     * @var ResultElementFormCreator
     */
    protected ResultElementFormCreator $resultElementFormCreator;

    /**
     * @var PeriodService
     */
    protected PeriodService $periodService;

    /**
     * @var IndicatorService
     */
    protected IndicatorService $indicatorService;

    /**
     * @var ResultService
     */
    protected ResultService $ResultService;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * IndicatorController Constructor.
     *
     * @param ResultElementFormCreator $resultElementFormCreator
     * @param PeriodService $periodService
     * @param IndicatorService $indicatorService
     * @param ResultService $resultService
     * @param ActivityService $activityService
     */
    public function __construct(
        ResultElementFormCreator $resultElementFormCreator,
        PeriodService $periodService,
        IndicatorService $indicatorService,
        ResultService $resultService,
        ActivityService $activityService
    ) {
        $this->resultElementFormCreator = $resultElementFormCreator;
        $this->periodService = $periodService;
        $this->indicatorService = $indicatorService;
        $this->resultService = $resultService;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the period.
     *
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return \Illuminate\Http\Response
     */
    public function index($activityId, $resultId, $indicatorId)
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $resultTitle = $this->resultService->getResult($resultId, $activityId)['result']['title'];
            $indicatorTitle = $this->indicatorService->getResultIndicator($resultId, $indicatorId)['indicator']['title'];
            $period = $this->periodService->getPeriodOfIndicator($indicatorId)->toArray();

            return view('admin.activity.period.period', compact('activity', 'indicatorTitle', 'resultTitle', 'period'));
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
     * @param $indicatorId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function create($activityId, $resultId, $indicatorId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($activityId);
            $this->resultElementFormCreator->url = route('admin.activities.result.indicator.period.store', [$activityId, $resultId, $indicatorId]);
            $form = $this->resultElementFormCreator->editForm([], $element['period']);
            $data = ['core' => $element['period']['criteria'] ?? false, 'status' => false, 'title' => $element['period']['label'], 'name' => 'period'];

            return view('activity.period.period', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rendering indicator period form.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PeriodRequest  $request
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PeriodRequest $request, $activityId, $resultId, $indicatorId): \Illuminate\Http\RedirectResponse
    {
        try {
            $periodData = $request->except(['_token']);

            if (!$this->periodService->create([
                'indicator_id'  => $indicatorId,
                'period'        => $periodData,
            ])) {
                return redirect()->route('admin.activities.show', $activityId)->with(
                    'error',
                    'Error has occurred while creating indicator period.'
                );
            }

            return redirect()->route('admin.activities.show', $activityId)->with(
                'success',
                'Indicator period created successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while creating indicator period.'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $activityId
     * @param  $resultId
     * @param  $indicatorId
     * @param  $periodId
     *
     * @return \Illuminate\Http\Response
     */
    public function show($activityId, $resultId, $indicatorId, $periodId)
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $resultTitle = $this->resultService->getResult($resultId, $activityId)['result']['title'];
            $indicatorTitle = $this->indicatorService->getResultIndicator($resultId, $indicatorId)['indicator']['title'];
            $period = $this->periodService->getIndicatorPeriod($indicatorId, $periodId);

            return view('admin.activity.period.detail', compact('activity', 'resultTitle', 'indicatorTitle', 'period'));
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
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     * @param $periodId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function edit($activityId, $resultId, $indicatorId, $periodId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($activityId);
            $indicatorPeriod = $this->periodService->getIndicatorPeriod($indicatorId, $periodId);
            $this->resultElementFormCreator->url = route('admin.activities.result.indicator.period.update', [$activityId, $resultId, $indicatorId, $periodId]);
            $form = $this->resultElementFormCreator->editForm($indicatorPeriod->period, $element['period'], 'PUT');
            $data = ['core' => $element['period']['criteria'] ?? false, 'status' => false, 'title' => $element['period']['label'], 'name' => 'period'];

            return view('activity.period.period', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rendering indicator period form.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PeriodRequest  $request
     * @param $activityId
     * @param $resultId
     * @param $indicatorId
     * @param $periodId
     *
     * @return
     */
    public function update(PeriodRequest $request, $activityId, $resultId, $indicatorId, $periodId)
    {
        try {
            $periodData = $request->except(['_method', '_token']);
            $period = $this->periodService->getIndicatorPeriod($indicatorId, $periodId);

            if (!$this->periodService->update([
                'indicator_id'  => $indicatorId,
                'period'        => $periodData,
            ], $period)) {
                return redirect()->route('admin.activities.show', $activityId)->with(
                    'error',
                    'Error has occurred while updating indicator period.'
                );
            }

            return redirect()->route('admin.activities.show', $activityId)->with(
                'success',
                'Indicator period updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while updating indicator period.'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IATI\Models\Activity\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function destroy(Period $period)
    {
        //
    }
}
